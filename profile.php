<?php session_start();?>

<html>

    <head> 
        <title>CoderNexus - Profil de <?=$_SESSION["loginUser"]?></title>        
        <?php require_once "includes/head.php"; ?>
        <!-- css de l'extension de whenzhixin https://github.com/wenzhixin/bootstrap-table -->        
        <link rel="stylesheet" href="css/dl/bootstrap-table.css">
        <link rel="stylesheet" href="css/dl/bootstrap-table-filter-control.css">
        <link href="css/profile.css" rel="stylesheet">
    </head> 

    <body>
        <?php
            require_once "includes/connect.php";
            require_once "includes/navbar.php";
            require_once "afficherCompte.php";
        ?>
    
        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h1 class="display-4">Votre profil</h1>
            <p class="lead">Bonjour! Voici vos informations de profil. </p>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-5 offset-md-2">
                    <div class="card-deck mb-3" style="width:400px">
                        <div class="card mb-4 box-shadow">
                            <div class="card-text">
                                <div class="profileinfos">
                                    <p><small class="lead"><?php afficherCompte($_SESSION['loginUser']) ?></small></p>
                                </div>
                                <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="location.href='modifierCompte.php'">Modifier</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <?php
                        //on affiche la photo de profil personnalisée si elle existe, celle par défaut sinon
                        if(file_exists("images/profils/".$_SESSION['id'].".png")) {
                            echo '<img src="images/profils/'.$_SESSION['id'].'.png" width="400px" alt="Photo de profil">';
                        } else {
                            echo '<img src="images/profile_default.jpg" width="50%" alt="Photo de profil">';
                        }
                    ?>
                </div>
            </div>
        </div>
        <center>        
            <div class="mesTutos">
                <h2>Mes tutoriels</h2>

                <?php
                    require_once "includes/functions.php";
                    //récupération de tous les tutoriels auxquels l'utilisateur s'est abonné
                    $resultats = getDb() -> prepare("SELECT * FROM PARTICIPATIONS WHERE ID_USER=?");
                    $resultats -> execute(array($_SESSION['id']));
                    $tot = $resultats -> fetchAll();
                    //s'il en existe..
                    if(count($tot) > 0) {
                        //récupération de toutes les informations des tutoriels auxquels l'utilisateur s'est abonné                        
                        $requete = "SELECT ID, LANGAGE, DATE, NIVEAU, INTITULE FROM TUTORIELS WHERE ID IN (SELECT ID_TUTORIAL FROM PARTICIPATIONS WHERE ID_USER=".$_SESSION['id'].")";
                        $resultats = $BDD -> query($requete);
                        //qu'est-ce que l'utilisateur a indiqué comme état pour chaque tuto
                        $participations = getDb() -> prepare("SELECT ID_TUTORIAL, ETAT FROM PARTICIPATIONS WHERE ID_USER=?");
                        $participations -> execute(array($_SESSION['id']));
                        $res = $participations -> fetchAll();

                        while($tuto = $resultats -> fetch()) {
                            for($i = 0; $i < count($res); $i++ ) {
                                if($res[$i]["ID_TUTORIAL"] == $tuto["ID"]) {
                                    $tuto["AVANCEMENT"] = $res[$i]["ETAT"]; //pour ajouter l'état d'avancement au tableau $tuto
                                }
                            }
                            $data[] = $tuto;
                        }

                        //fichier créé temporairement pour stocker les informations à afficher dans la bootstrap-table
                        $fp = fopen('tutoriels_profil.json', 'w');
                        fwrite($fp, json_encode($data));
                        fclose($fp); ?>

                            <!-- Table de recherche avancée des tutoriels -->

                            <!-- On reprends la même customisation, on rajoute un triage par Avancement par défaut avec les "En cours" en premier -->
                            <table id="tutorialsTable" data-toggle="table" data-pagination="true" data-url="tutoriels_profil.json" data-filter-control="true" data-strict-search="true" data-sort-name="AVANCEMENT" data-sort-order="asc">
                                <thead>
                                    <tr>
                                        <!-- les data-field font référence aux clés du tableau json appelé, on définit les têtes et la bibliothèque gère l'affichage de chaque ligne -->
                                        <th data-field="ID" data-visible="false">ID</th> <!-- pour pouvoir créer les liens href uniquement -->
                                        <th data-field="INTITULE" data-filter-control="input" data-sortable="true" data-formatter="intituleFormatter" data-filter-control-placeholder="<Rechercher un tutoriel spécifique>">Intitulé</th>
                                        <th data-field="LANGAGE" data-filter-control="select" data-sortable="true">Langage</th>
                                        <th data-field="NIVEAU" data-filter-control="select" data-sortable="true">Niveau</th>
                                        <th data-field="DATE" data-sortable="true">Date</th>
                                        <th data-field="AVANCEMENT" data-sortable="true" data-order='asc' data-formatter="avancementFormatter">Avancement</th>
                                    </tr>
                                </thead>
                            </table>
                    
                            <script>
                                //cf commentaire dans index.php
                                function intituleFormatter(value, row) {
                                    let link = "<a href='tutorial.php?id=" + row.ID + "'>" + value + "</a>";
                                    return link;
                                }
                                //ici la valeur de l'avancement est transformé de chiffre (BDD) en texte
                                function avancementFormatter(value) {
                                    let txt = "";
                                    if(value == 0) { txt = "En cours"; }
                                    if(value == 1) { txt = "Terminé"; }
                                    return txt;
                                }
                            </script>

                <?php
                    } else {
                        echo "Vous n'avez toujours pas indiqué de participation à un tutoriel. Rendez-vous sur la page principale pour trouver votre bonheur !";
                    }
                ?>
            </div>
        <center>
    </body>

    <?php require_once "includes/footer.php"; ?>
    <!-- js de l'extension de whenzhixin https://github.com/wenzhixin/bootstrap-table -->
    <script type="text/javascript" src="js/dl/bootstrap-table.js"></script>
    <script type="text/javascript" src="js/dl/bootstrap-table-filter-control.js"></script>

</html>
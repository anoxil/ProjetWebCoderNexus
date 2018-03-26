<?php session_start();?>

<html>

    <head> 
        <link href="css/profile.css" rel="stylesheet">
        <title>CoderNexus - Profil de <?=$_SESSION["loginUser"]?></title>        
        <?php require ("includes/head.php");
        require ("includes/endjs.php"); 
        require ("includes/connect.php");
        require ("includes/navbar.php");
        require ("afficherCompte.php"); 
        require ("includes/head.php");?>
        <?php require_once "includes/navbar.php"; ?>
        <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/src/bootstrap-table.css">
        <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/extensions//filter-control/bootstrap-table-filter-control.css">
        <script src="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/bootstrap-table.js"></script>
        <script src="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/extensions//filter-control/bootstrap-table-filter-control.js"></script>
    </head> 

    <body>
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
                    $requete = "SELECT * FROM PARTICIPATIONS WHERE ID_USER=".$_SESSION['id']."";
                    $resultats = $BDD -> query($requete);
                    $tot = $resultats -> fetchAll();
                    if(count($tot) > 0) {
                        $requete = "SELECT ID, LANGAGE, DATE, NIVEAU, INTITULE FROM TUTORIELS WHERE ID IN (SELECT ID_TUTORIAL FROM PARTICIPATIONS WHERE ID_USER=".$_SESSION['id'].")";
                        $resultats = $BDD -> query($requete);
                        $requete = "SELECT ID_TUTORIAL, ETAT FROM PARTICIPATIONS WHERE ID_USER=".$_SESSION['id']."";
                        $participations = $BDD -> query($requete);
                        $res = $participations -> fetchAll();

                        while($tuto = $resultats -> fetch()) {
                            for($i = 0; $i < count($res); $i++ ) {
                                if($res[$i]["ID_TUTORIAL"] == $tuto["ID"]) {
                                    $tuto["AVANCEMENT"] = $res[$i]["ETAT"]; //pour ajouter la moyenne au tableau $tuto
                                }
                            }
                            $data[] = $tuto;
                        }

                        $fp = fopen('tutoriels_profil.json', 'w');
                        fwrite($fp, json_encode($data));
                        fclose($fp); ?>

                            <!-- Table de recherche avancée des tutoriels -->
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
                                function intituleFormatter(value, row) {
                                    let link = "<a href='tutorial.php?id=" + row.ID + "'>" + value + "</a>";
                                    return link;
                                }
                                //ici la valeur de l'avancement est transformé de chiffre en texte
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

</html>
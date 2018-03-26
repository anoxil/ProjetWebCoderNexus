<?php session_start(); ?>

<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CoderNexus - Page principale</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.6/css/all.css">
        <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/master/src/bootstrap-table.css">
        <link rel="stylesheet" href="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/extensions//filter-control/bootstrap-table-filter-control.css">
        <link href="css/index.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/bootstrap-table.js"></script>
        <script src="https://rawgit.com/wenzhixin/bootstrap-table/develop/src/extensions//filter-control/bootstrap-table-filter-control.js"></script>
        <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </head>

    <body>
        <?php 
            require_once "includes/navbar.php";
            require_once "includes/connect.php";
        ?>
        
        <main role="main">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide" src="images/pc.jpg" alt="First slide">
                    <div class="container">
                        <div class="carousel-caption">
                            <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                                <h2 class="display-4">Apprenez à programmer</h2>
                            </div>
                            <p class="lead">Grâce à un regroupement de tutoriels sur tous les langages de programmation</p>
                            <p><a class="btn btn-lg btn-outline-primary" href="presentation.php" role="button">En savoir plus</a></p>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="images/account.jpg" alt="Second slide">
                    <div class="container">
                        <div class="carousel-caption">
                        <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                            <h2 class="display-4">Créez votre compte</h2>
                        </div>
                        <p class="lead">Pour sauvegarder ou partager vos tutoriels préférés</p>
                        <p><a class="btn btn-lg btn-outline-primary" href="signup.php" role="button">Inscription</a>
                        <a class="btn btn-lg btn-outline-primary" href="login.php" role="button">Connexion</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img class="third-slide" src="images/synthgrid.jpg" alt="Third slide">
                <div class="container">
                    <div class="carousel-caption">
                        <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                            <h2 class="display-4">Raphaël et Margot</h2>
                        </div>
                        <p class="lead">Projet Web ENSC 2018</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <br><br><br>


        <div class="margin">

            <?php
                //on veut récupérer toutes les INFORMATIONS pour classer les tutos
                $requete = "SELECT ID, LANGAGE, DATE, NIVEAU, INTITULE FROM TUTORIELS";
                $resultats = $BDD -> query($requete);

                //on veut récupérer toutes les NOTES moyennées pour classer les tutos
                $requete = "SELECT ID_TUTORIAL, AVG(VOTE_USER) AS MOYENNE FROM VOTES GROUP BY ID_TUTORIAL";
                $moyennes = $BDD -> query($requete);
                $res_moy = $moyennes -> fetchAll();

                //on veut récupérer tous les TYPES des langages
                $requete = "SELECT TYPE, LANGAGE FROM LANGAGES";
                $langages = $BDD -> query($requete);
                $res_lang = $langages -> fetchAll();

                
                while($tuto = $resultats -> fetch()) {
                    //on cherche à faire correspondre l'id actuellement fetché par $tuto
                    for($i = 0; $i < count($res_moy); $i++ ) {
                        if($res_moy[$i]["ID_TUTORIAL"] == $tuto["ID"]) {
                            $tuto["MOYENNE"] = $res_moy[$i]["MOYENNE"]; //pour ajouter la moyenne au tableau $tuto
                        }
                    }
                    //ici on récupère le type du langage du tuto
                    for($i = 0; $i < count($res_lang); $i++ ) {
                        if($res_lang[$i]["LANGAGE"] == $tuto["LANGAGE"]) {
                            $tuto["TYPE"] = $res_lang[$i]["TYPE"];
                        }
                    }
                    $data[] = $tuto; //stockage de chaque tuto dans un array
                }
                if(isset($data)) {
                    $fp = fopen('tutoriels.json', 'w');
                    //on écrit les données dans un json pour l'utiliser dans la balise "table" avec data-url
                    fwrite($fp, json_encode($data));
                    fclose($fp);
                } else { echo "Aucun site n'est pour l'instant référencé ? Mais c'est une fabuleuse occasion d'en <a href='tutorial_add.php'>rajouter</a> si vous êtes administrateur !"; }
            ?>

            <!-- Table de recherche avancée des tutoriels -->
            <table id="tutorialsTable" data-toggle="table" data-pagination="true" data-page-size="15" data-page-list="[15, 30]" data-url="tutoriels.json" data-filter-control="true" data-strict-search="true">
                <thead>
                    <tr>
                        <!-- les data-field font référence aux clés du tableau json appelé, on définit les têtes et la bibliothèque gère l'affichage de chaque ligne -->
                        <th data-field="ID" data-visible="false">ID</th> <!-- pour pouvoir créer les liens href uniquement -->
                        <th data-field="INTITULE" data-sortable="true" data-formatter="intituleFormatter">Intitulé</th>
                        <th data-field="LANGAGE" data-filter-control="select" data-sortable="true">Langage</th>
                        <th data-field="TYPE" data-filter-control="select" data-sortable="true">Type</th>
                        <th data-field="NIVEAU" data-filter-control="select" data-sortable="true">Niveau</th>
                        <th data-field="DATE" data-sortable="true">Date</th>
                        <th data-field="MOYENNE" data-sortable="true">Note moyenne</th>
                    </tr>
                </thead>
            </table>
            <!-- Script pour rendre les intitulés cliquables vers la fiche du tuto -->
            <script>
                function intituleFormatter(value, row) {
                    let link = "<a href='tutorial.php?id=" + row.ID + "'>" + value + "</a>";
                    return link;
                }
            </script>
        </div>
            
        <?php require "includes/endjs.php"; ?>
        
    </body>

    <footer class="container">
        <p class="float-right lead"><a href="#">Retour en haut</a></p>
    </footer>

</html>
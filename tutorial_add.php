<?php session_start(); ?>

<html>


    <head>
        <?php require_once "includes/head.php"; ?>
        <title>CoderNexus - Ajout d'un tutoriel</title>        
        <link href="css/add.css" rel="stylesheet">
    </head>


    <body>

        <?php
            if (isset($_SESSION["loginUser"]) && ($_SESSION["admin"] == 1)) {
        
                require ("InsererTuto.php");
                require ("includes/connect.php");
                require ("includes/navbar.php");

                if (!empty($_POST['lien']) && !empty($_POST['langage']) && !empty($_POST['niveau']) && !empty($_POST['intitule'])) 
                {
                    InsererTuto($_POST['lien'], $_POST['langage'], $_POST['date'], $_POST['niveau'], $_POST['intitule'], $_POST['screen']);
                    header('Location: index.php');
                }  
                else
                { ?>

                    <br/><br/><br/>
                    <div class="container">
                        <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                            <h2 class="display-4">Ajouter un tutoriel</h2>
                                <form class="form-signin" style="width:600px" action="tutorial_add.php" method="POST">
                                    
                                    <p class="lead">Insérez le lien du site contenant le tutoriel </p> 
                                    <input type="text" class="form-control" name="lien" placeholder="Lien" required autofocus> <br/>

                                    <p class="lead">Entrez un intitulé pour le tutoriel</p>
                                    <input type="text" class="form-control" name="intitule" placeholder="Intitulé" required> <br/>

                                    <p class="lead">Sélectionnez le langage sur lequel porte le tutoriel</p> 
                                    <select name="langage" class="form-control" required>
                                    <option disabled selected>Langage</option>
                                    <?php
                                        $requete = "SELECT LANGAGE FROM LANGAGES";
                                        $contenus = $BDD -> query($requete);
                                        while($resultat = $contenus -> fetch()) {
                                            echo '<option value="'.$resultat["LANGAGE"].'">'.$resultat["LANGAGE"].'</option>';
                                        }                                
                                    ?>
                                    </select> <br/>

                                    <p class="lead">Entrez la date de publication du tutoriel</p>
                                    <input type="date" class="form-control" placeholder="Entrez la date de publication du tutoriel" name="date"> <br/>

                                    <p class="lead">Sélectionnez le niveau de difficulté du tutoriel</p> 
                                    <select name="niveau" class="form-control" placeholder="Sélectionnez le langage sur lequel porte le tutoriel" required>
                                        <option disabled selected>Niveau</option>
                                        <option value="1">1 (Très facile)</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5 (Très difficile)</option>
                                    </select> <br/>

                                    <p class="lead">Ajouter un screenshot de la page du tutoriel ? (chargement long)</p> 
                                    <label class="switch">
                                        <input type="checkbox" name="screen">
                                        <span class="slider round"></span>
                                    </label> <br/>

                                    <center>
                                        <button class="btn btn-lg btn-outline-primary btn-block" style="width:150px" type="submit">Envoyer</button>
                                    </center>

                                </form>
                        </div>
                    </div>

                <?php }
            } else {
                echo "Vous n'êtes pas admin, accès non autorisé.";
            }
                    require "includes/endjs.php";
                ?>

    </body>


</html>
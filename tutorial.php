<?php session_start(); ?>

<html>

    <head>
        <title>CoderNexus - Tutoriel</title>        
        <?php require_once "includes/head.php"; ?>
        <link rel="stylesheet" href="css/tutorial.css">

        <script type="text/javascript">
                $(document).ready(function() { //affichage du vote déjà enregistré si existant
                    star_number = $("#hiddenvote").attr("value"); //récupération valeur de star_number caché dans un input hidden
                    let id_star = "#vote" + star_number;
                    $(id_star).prevAll().addBack().attr("src", "images/stars/star_full.png");
                    $(id_star).nextAll().attr("src", "images/stars/star_empty.png");
                });
        </script>
    </head>

    <body>
        
        <?php
            require_once "includes/connect.php";
            require_once "tutorial-dbqueries.php";
            require_once "includes/navbar.php";
        ?>

        <?php
            //Récupération des images, screenshot s'il a été généré lors de l'ajout, l'image du langage sinon
            if(file_exists("images/tutoriels/".$resultat['ID'].".jpeg")) {
                $image = "images/tutoriels/".$resultat['ID'].".jpeg";
            } else {
                $contenus = getDb() -> prepare("SELECT IMAGE FROM LANGAGES WHERE LANGAGE=?");
                $contenus -> execute(array($resultat['LANGAGE']));
                $resultat_image = $contenus -> fetch();
                $image = 'images/langages/'.$resultat_image["IMAGE"].'.png';
            }
        ?>

        <br/><br/><br/>

        <!-- Description tutoriel -->
        <div class="container">
            <div class="row">
                <!-- l'image à gauche -->            
                <div class="col-md-4">
                    <div class="card-deck mb-3 text-center" >
                        <ul class="list-unstyled mt-3 mb-4">
                            <li><a href=<?=$resultat['LIEN']?> target="_blank"><img class="langageImage" <?php echo 'src="'.$image.'" alt="affiche '.$resultat["LANGAGE"].'" title="'.$resultat["LANGAGE"].'"' ?>></a></li>
                        </ul>
                    </div>
                </div>
                <!-- les infos à droite -->
                <div class="col-md-8">
                    <div class="card mb-4 box-shadow" style="width:700px">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center"> 
                                    <h2 class="display-4"> <a href="<?=$resultat['LIEN'] ?>" target="_blank"><?=$resultat["INTITULE"]?></a></h2>
                                </div>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <li class="lead">
                                        Langage associé : <?=$resultat["LANGAGE"]?>
                                    </li><br/>
                                    <li class="lead">
                                        Niveau de difficulté : <?=$resultat["NIVEAU"]?>
                                    </li>
                                    <br/><hr>
                                    <li>
                                        <?php
                                            //peut voter et noter participation si connecté
                                            if(isset($_SESSION['loginUser'])) { ?>
                                                <div class="scoring">
                                                    <img src="images/stars/star_empty.png" class="voting_stars" id="vote1">
                                                    <img src="images/stars/star_empty.png" class="voting_stars" id="vote2">
                                                    <img src="images/stars/star_empty.png" class="voting_stars" id="vote3">
                                                    <img src="images/stars/star_empty.png" class="voting_stars" id="vote4">
                                                    <img src="images/stars/star_empty.png" class="voting_stars" id="vote5">
                                                </div>
                                                <form action="tutorial.php" method="GET">
                                                    <input type="hidden" name="id" value="<?= $_GET['id']?>"> <!-- renvoi de l'id de la page -->
                                                    <input type="hidden" name="vote" value="<?= $star_number?>" id="hiddenvote"><br/> <!-- envoi du vote -->
                                                    <center><input type="submit" class="btn btn-lg btn-outline-primary btn-block" value="Voter" style="width:20%"></center>
                                                </form>
                                                <hr>
                                                <form action="tutorial.php" method="GET">
                                                    <input type="hidden" name="id" value="<?= $_GET['id']?>"> <!-- renvoi de l'id de la page -->
                                                    <label for="enrollment">Etat :</label>
                                                    <center><select class="form-control" style="width:30%" name="enrollment"></center>
                                                        <option value="0">En cours</option>
                                                        <option value="1">Terminé</option>
                                                    </select><br/>
                                                    <input type="submit" class="btn btn-lg btn-outline-primary btn-block" style="width:20%" value="Envoyer">
                                                </form>
                                        <?php } else { ?>
                                            Veuillez vous <a href="login.php">connecter</a> ou vous <a href="signup.php">inscrire</a> pour pouvoir voter ou enregistrer votre participation au cours !
                                        <?php } ?>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    </body>

    <?php require_once "includes/footer.php"; ?>    
    <script type="text/javascript" src="js/tools_tutorial.js"></script>

</html>
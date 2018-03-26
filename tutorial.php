<?php session_start(); ?>

<html>

<head>
    <?php require_once "includes/head.php"; ?>
    <title>CoderNexus - Tutoriel</title>    
    <!--
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    -->
    <link rel="stylesheet" href="css/tutorial.css">

    <script type="text/javascript">
            $(document).ready(function() { //affichage du vote déjà enregistré si existant
                star_number = $("#hiddenvote").attr("value");
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
        //Récupération des images
        if(file_exists("images/tutoriels/".$resultat['ID'].".jpeg")) {
            $image = "images/tutoriels/".$resultat['ID'].".jpeg";
        } else {
            $requete = "SELECT IMAGE FROM LANGAGES WHERE LANGAGE='".$resultat['LANGAGE']."'";
            $contenus = $BDD -> query($requete);
            $resultat_image = $contenus -> fetch();
            $image = 'images/langages/'.$resultat_image["IMAGE"].'.png';
        }
    ?>

    <!-- Description film -->
    <br/><br/><br/>
    <div class="container">
        <div class="row">
        <div class="col-md-4">
      <div class="card-deck mb-3 text-center" >
            <ul class="list-unstyled mt-3 mb-4">
              <li><a href=<?=$resultat['LIEN']?> target="_blank"><img class="langageImage" <?php echo 'src="'.$image.'" alt="affiche '.$resultat["LANGAGE"].'" title="'.$resultat["LANGAGE"].'"' ?>></a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card mb-4 box-shadow" style="width:700px">
          <div class="card-body">
            <ul class="list-unstyled mt-3 mb-4">
            <div class="text-center">
            <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center"> 
            <h2 class="display-4"> <a href="<?=$resultat['LIEN'] ?>" target="_blank"><?=$resultat["INTITULE"]?></a> </h2></div><br/>
              <li class="lead">Langage associé : <?=$resultat["LANGAGE"]?></li><br/>
              <li class="lead">Niveau de difficulté : <?=$resultat["NIVEAU"]?></li><br/>
              <hr>
              <li> <?php if(isset($_SESSION['loginUser'])) { ?>
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
            <?php } ?> </li>
    
            </ul>
          </div>
        </div>
        </div>
        </div>
    </div>


    <script type="text/javascript" src="js/tools_tutorial.js"></script>
    <?php require "includes/endjs.php"; ?>

</body>

</html>
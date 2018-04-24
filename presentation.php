<?php session_start(); ?>

<html>

    <head>
        <title>CoderNexus - Présentation</title>  
        <?php require_once "includes/head.php"; ?>
        <link href="css/index.css" rel="stylesheet">
    </head>

    <body>
        <?php require_once "includes/navbar.php"; ?>

        <div class="container">
            <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                <h2 class="display-4">Bonjour</h2>
            </div>
            <p class="lead">
                Codernexus vous permet d'apprendre à programmer facilement.<br/> 
                Il regroupe un ensemble de tutoriels portant sur les différents langages de programmation.<br/><br/>
                La recherche avancée vous permet de trouver des tutoriels adaptés à vos besoins.<br/>
                En créant votre compte, vous pourrez partager vos propres tutoriels, en les ajoutant via leur URL.<br/>
                Vous pourrez également enregistrer votre progression dans les tutoriels réalisés.<br/><br/>

                Bonne visite
            </p>
            <p><a class="btn btn-lg btn-outline-primary" href="index.php" role="button">Accueil</a></p>
        </div>
    </body>

    <?php require_once "includes/footer.php"; ?>
    
</html>

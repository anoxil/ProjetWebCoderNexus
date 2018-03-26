<?php session_start(); ?>
 <head>
 <?php require_once "includes/head.php"; ?>
 <title>CoderNexus - Connexion</title> 
<meta charset="utf-8">
    <?php require ("includes/connect.php");?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signup_login.css" rel="stylesheet">
    <link href="css/profile.css" rel="stylesheet">
    </head>


<?php

require ("includes/connect.php");


$errorMessage = false;

if (isset($_POST["loginUser"])) {
    
    $loginUser = $_POST['loginUser'];
    $MaRequete="SELECT * FROM COMPTES WHERE LOGIN_USER='$loginUser'";
    $MonRs=$BDD->query($MaRequete);
    if($Tuple=$MonRs->fetch())
        { 
            if ($_POST["userPassword"] == $Tuple["MDP"]) {
                
                $_SESSION['loginUser'] = $_POST['loginUser'];
                $_SESSION['mdp'] = $_POST['userPassword'];
                $_SESSION['id'] = $Tuple['ID'];
                $_SESSION['admin'] = $Tuple['ADMIN'];
                header("Location: index.php");
                } 
            else {
                $errorMessage = true;
            }
        }
    else 
    {
        $errorMessage=true;
    }
            }
?>

<?php require_once "includes/head.php"; ?>
<?php require_once "includes/navbar.php"; ?>

<body>


    <div class="text-center">
    <center>
        <form class="form-signin"  style="width:400px" action="login.php" method="POST">
        <img class="mb-4" src="https://cdn2.iconfinder.com/data/icons/rcons-user/32/male-shadow-fill-circle-512.png" alt="" width="72" height="72">
            <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <h2 class="display-4">Connexion</h2>
            </div>
            <?php
                if ($errorMessage) {
                    echo "<div class='container' style='color: red'>";
                    echo "    Erreur dans le login et/ou mot de passe !";
                    echo "</div><br/>";
                }
            ?>
            <label for="loginUser" class="sr-only">Entrez votre login</label>
            <input type="text" name="loginUser" class="form-control" id="loginUser" placeholder="Login" required autofocus>
            <label for="password" class="sr-only">Entrez votre mot de passe</label>
            <input type="password" name="userPassword" class="form-control" id="password" placeholder="Mot de passe" required>
            <br/>
            <button type="submit" style="width:150px" class="btn btn-lg btn-outline-primary btn-block"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
          
        </form>
        </center>
    </div>


    <?php require "includes/endjs.php"; ?>

</body>

</html>
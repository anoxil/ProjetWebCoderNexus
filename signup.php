<html>

    <head>
        <?php require_once "includes/head.php"; ?>
        <meta charset="utf-8">
        <title>CoderNexus - Inscription</title>        
        <?php require ("includes/connect.php");?>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="images/profile.png">

        <!-- Bootstrap core CSS -->
        <link href="../../../../dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/signup_login.css" rel="stylesheet">
    </head>

    <body>

        <?php
            require ("InsererCompte.php");
            require ("includes/connect.php");
            require ("includes/navbar.php");

            $login_message = false;
            $mdp_message = false;
            $mail_message = false;

            if (!empty($_POST['loginUser']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mdp']) && !empty($_POST['mail'])) {
                $MaRequete="SELECT * FROM COMPTES";
                $MonRs=$BDD->query($MaRequete);
            
                while($Tuple=$MonRs->fetch()) { 
                    if ($Tuple["LOGIN_USER"]==$_POST['loginUser']) {
                        $login_message = true;
                    }
                    if ($Tuple["MAIL"]==$_POST['mail']) {
                        $mail_message = true;
                    }
                }
                if($_POST["mdp"] != $_POST["mdp_check"]) {
                    $mdp_message = true;
                }
                if (!$login_message && !$mdp_message) {
                    InsererCompte($_POST['loginUser'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['mdp']);
                    session_start();
                    $_SESSION["loginUser"] = $_POST['loginUser'];
                    $_SESSION["mdp"] = $_POST['mdp'];
                    $MaRequete="SELECT * FROM COMPTES WHERE LOGIN_USER='".$_POST['loginUser']."'";
                    $MonRs=$BDD->query($MaRequete);
                    if($Tuple=$MonRs->fetch()) { 
                        $_SESSION['id'] = $Tuple["ID"];
                        $_SESSION['admin'] = $Tuple["ADMIN"];
                    }
                    header('Location: index.php');
                }
            }
        ?>

        <div class="text-center">
            <center>
                <form class="form-signin" style="width:400px" action="signup.php" method="POST">
                    <img class="mb-4" src="https://cdn2.iconfinder.com/data/icons/rcons-user/32/male-shadow-fill-circle-512.png" alt="" width="72" height="72">
                    <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                        <h2 class="display-4">Inscription</h2>
                    </div>
                    <input type="text" class="form-control" name="nom" placeholder="Entrez votre nom" required autofocus>
                    <input type="text" class="form-control" name="prenom" placeholder="Entrez votre prénom" required> -
                    <input type="text" class="form-control" name="loginUser" placeholder="Entrez votre login" required>
                    <?php
                        if ($login_message) {
                            echo "<div class='container' style='color: red'>";
                            echo "Ce login est déjà utilisé. Choisissez-en un autre !";
                            echo "</div>";
                        }
                    ?>
                    <input type="email" class="form-control" name="mail" placeholder="Entrez votre mail" required>
                    <?php
                        if ($mail_message) {
                            echo "<div class='container' style='color: red'>";
                            echo "Ce mail est déjà utilisé. Choisissez-en un autre !";
                            echo "</div>";
                        }
                    ?> -
                    <input type="password" class="form-control" name="mdp" placeholder="Entrez votre mot de passe" required>
                    <input type="password" class="form-control" name="mdp_check" placeholder="Confirmez votre mot de passe" required>
                    <?php
                        if ($mdp_message) {
                            echo "<div class='container' style='color: red'>";
                            echo "Les deux mots de passe ne correspondent pas !";
                            echo "</div>";
                        }
                    ?></br>
                    <button type="submit" class="btn btn-lg btn-outline-primary btn-block" style="width:150px"><span class="glyphicon glyphicon-log-in"></span> S'inscrire</button>
                </form>
            </center>
        </div>
        
        <?php require "includes/endjs.php"; ?>

    </body>

</html>
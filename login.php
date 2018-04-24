<?php session_start(); ?>

<html>

    <head>
        <title>CoderNexus - Connexion</title> 
        <?php require_once "includes/head.php"; ?>
        <link href="css/signup_login.css" rel="stylesheet">
        <link href="css/profile.css" rel="stylesheet">
    </head>

    <body>

        <?php
            require_once "includes/functions.php";
            require_once "includes/navbar.php";
            
            $errorMessage = false;

            if (isset($_POST["loginUser"])) {
                $loginUser = $_POST['loginUser'];
                $MaRequete = getDb() -> prepare("SELECT * FROM COMPTES WHERE LOGIN_USER=?");
                $MaRequete -> execute(array($loginUser));
                //si on trouve un compte qui correspond au login
                if($Tuple = $MaRequete->fetch()) { 
                        //si le mdp correspond
                        if ($_POST["userPassword"] == $Tuple["MDP"]) {
                            $_SESSION['loginUser'] = $_POST['loginUser'];
                            $_SESSION['mdp'] = $_POST['userPassword'];
                            $_SESSION['id'] = $Tuple['ID'];
                            $_SESSION['admin'] = $Tuple['ADMIN'];
                            header("Location: index.php");
                        } else {
                            $errorMessage = true;
                        }
                } else {
                    $errorMessage=true;
                }
            }
        ?>

        <div class="text-center">
            <center>
                <form class="form-signin"  style="width:400px" action="login.php" method="POST">
                    <img class="mb-4" src="images/login_shadow.png" width="72" height="72">
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
                    <input type="password" name="userPassword" class="form-control" id="password" placeholder="Mot de passe" required><br/>
                    
                    <button type="submit" style="width:150px" class="btn btn-lg btn-outline-primary btn-block"><span class="glyphicon glyphicon-log-in"></span> Se connecter</button>
                </form>
            </center>
        </div>

    </body>

    <?php require_once "includes/footer.php"; ?>    

</html>
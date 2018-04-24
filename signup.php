<html>

    <head>
        <title>CoderNexus - Inscription</title>
        <?php require_once "includes/head.php"; ?>
        <link href="css/signup_login.css" rel="stylesheet">
        <link rel="icon" href="images/profile.png">      
    </head>

    <body>

        <?php
            require_once ("InsererCompte.php");
            require_once ("includes/connect.php");
            require_once ("includes/functions.php");
            require_once ("includes/navbar.php");

            $login_message = false;
            $mdp_message = false;
            $mail_message = false;

            if (!empty($_POST['loginUser']) && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['mdp']) && !empty($_POST['mail'])) {
                $MaRequete = getDb() -> prepare("SELECT * FROM COMPTES");
                $MaRequete -> execute();
                

                //on vérifie bien que les données envoyées sont correctes pour un ajout de compte
                while($Tuple=$MaRequete->fetch()) {
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
                //si les données sont correctes, on ajoute le compte et on le connecte
                if (!$login_message && !$mail_message && !$mdp_message) {
                    InsererCompte($_POST['loginUser'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['mdp']);
                    session_start();
                    $_SESSION["loginUser"] = $_POST['loginUser'];
                    $_SESSION["mdp"] = $_POST['mdp'];
                    $MonRs = getDb() -> prepare("SELECT * FROM COMPTES WHERE LOGIN_USER=?");
                    $MonRs -> execute(array($_POST["loginUser"]));
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
                <!-- si l'utilisateur a déjà envoyé des données mais qu'il y a eu erreur, on pré-rempli le form avec les données de l'envoi précédent (cf les isset()) -->
                <form class="form-signin" style="width:400px" action="signup.php" method="POST">
                    <img class="mb-4" src="images/login_shadow.png" width="72" height="72">
                    <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                        <h2 class="display-4">Inscription</h2>
                    </div>
                    <input type="text" class="form-control" name="nom" placeholder="Entrez votre nom" <?php if(isset($_POST['nom'])) { echo "value='".$_POST['nom']."'"; } ?> required autofocus>
                    <input type="text" class="form-control" name="prenom" placeholder="Entrez votre prénom" <?php if(isset($_POST['prenom'])) { echo "value='".$_POST['prenom']."'"; } ?> required> -
                    <input type="text" class="form-control" name="loginUser" placeholder="Entrez votre login" <?php if(isset($_POST['loginUser'])) { echo "value='".$_POST['loginUser']."'"; } ?> required>
                    <?php
                        if ($login_message) {
                            echo "<div class='container' style='color: red'>";
                            echo "Ce login est déjà utilisé. Choisissez-en un autre !";
                            echo "</div>";
                        }
                    ?>
                    <input type="email" class="form-control" name="mail" placeholder="Entrez votre mail" <?php if(isset($_POST['mail'])) { echo "value='".$_POST['mail']."'"; } ?> required>
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

    </body>

    <?php require_once "includes/footer.php"; ?>    

</html>
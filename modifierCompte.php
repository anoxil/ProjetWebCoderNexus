<?php session_start(); ?>

<html>

    <head>
        <title>CoderNexus - Modification du profil</title>
        <?php require_once "includes/head.php";?>
        <link href="css/add.css" rel="stylesheet">
    </head>

    <body>

        <?php
            require_once ("includes/connect.php");
            require_once ("includes/functions.php");
            require_once ("includes/navbar.php");

            $loginUser = $_SESSION["loginUser"];
            $MonRs = getDb() -> prepare("SELECT * FROM COMPTES WHERE LOGIN_USER=?");
            $MonRs -> execute(array($loginUser));
            if($Tuple=$MonRs->fetch()) { 
                $_SESSION['id'] = $Tuple["ID"];
            }
        ?>

        <br/>

        <?php
            $error_message = false;

            if (!empty($_POST['loginUser']))
            { 
                $MaRequete="SELECT * FROM COMPTES";
                $MonRs=$BDD->query($MaRequete);
            
                if($Tuple=$MonRs->fetch())
                { 
                    if ($Tuple["LOGIN_USER"]==$_POST['loginUser']) {
                        $error_message = true;
                    } 
                    else {
                        $_SESSION["loginUser"]=$_POST['loginUser'];
                        $MaRequete = $BDD->prepare("UPDATE COMPTES SET LOGIN_USER = :LOGIN_USER WHERE ID = :ID");
                        $loginUser = $_POST['loginUser'];
                        $id = $_SESSION["id"];
                        $MaRequete->bindValue('LOGIN_USER',$loginUser,PDO::PARAM_STR );
                        $MaRequete->bindValue('ID',$id,PDO::PARAM_INT );
                        $MaRequete->execute();
                    }
                }
            }
            
            if (!empty($_FILES['image']))
            {
                $content_dir = 'images/profils/';
                $tmp_file = $_FILES["image"]['tmp_name'];
                $name_file = $_SESSION["id"].".png"; 
                $upload_dir = $content_dir.$name_file;
                move_uploaded_file($tmp_file, $upload_dir);
            }

            if (!empty($_POST['nom']))
            {
                $MaRequete = $BDD->prepare("UPDATE COMPTES SET NOM = :NOM WHERE LOGIN_USER = :loginUser");
                $nom = $_POST['nom'];
                $loginUser = $_SESSION['loginUser'];
                $MaRequete->bindValue('NOM',$nom , PDO::PARAM_STR );
                $MaRequete->bindValue('LOGIN_USER',$loginUser,PDO::PARAM_STR );
                $MaRequete->execute();
            }

            if (!empty($_POST['prenom']))
            {
                $MaRequete = $BDD->prepare("UPDATE COMPTES SET PRENOM = :PRENOM WHERE LOGIN_USER = :loginUser");
                $prenom = $_POST['prenom'];
                $loginUser = $_SESSION['loginUser'];
                $MaRequete->bindValue('PRENOM',$prenom , PDO::PARAM_STR );
                $MaRequete->bindValue('LOGIN_USER',$loginUser,PDO::PARAM_STR );
                $MaRequete->execute();
            }

            if (!empty($_POST['mdp']))
            {
                $_SESSION["pass"] = $_POST['mdp'];
                $MaRequete = $BDD->prepare("UPDATE COMPTES SET MDP = :MDP WHERE LOGIN_USER = :loginUser");
                $mdp = $_POST['mdp'];
                $loginUser = $_SESSION['loginUser'];
                $MaRequete->bindValue('MDP',$mdp , PDO::PARAM_STR );
                $MaRequete->bindValue('LOGIN_USER',$loginUser,PDO::PARAM_STR );
                $MaRequete->execute();
            }

            if (!empty($_POST['mail'])) 
            {
                $MaRequete = $BDD->prepare("UPDATE COMPTES SET MAIL = :MAIL WHERE LOGIN_USER = :loginUser");
                print_r($MaRequete);
                $mail = $_POST['mail'];
                $loginUser = $_SESSION['loginUser'];
                $MaRequete->bindValue('MAIL', $mail, PDO::PARAM_STR );
                $MaRequete->bindValue('LOGIN_USER', $loginUser, PDO::PARAM_STR );
                $MaRequete->execute();
            }
        ?>

        <br/><br/><br/>
        
        <div class="container">
            <div class="spricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto">
                <h2 class="display-4">Modifier les données de profil</h2>

                <form class="form-signin" enctype="multipart/form-data" style="width:600px" action="modifierCompte.php" method="POST">
                    <label for="image">Photo de profil :</label>
                    <input type="file" class="form-control" id="image" name="image"></br>
                    <input type="text" class="form-control" name="nom" placeholder="Nouveau nom ?" autofocus><br/>
                    <input type="text" class="form-control" name="prenom" placeholder="Nouveau prénom ?"><br/>
                    <?php
                        if ($error_message) {
                            echo "<div class='container' style='color: red'>";
                            echo "Ce loginUser est déjà utilisé. Choisissez-en un autre !";
                            echo "</div>";
                        }
                    ?>
                    <input type="text" class="form-control" name="loginUser" placeholder="Nouveau login ?" ><br/>
                    <input type="text" class="form-control" name="mail" placeholder="Nouveau mail ?"><br/>
                    <input type="password" class="form-control" name="mdp" placeholder="Nouveau mot de passe ?"><br/>
                    <center>
                        <button class="btn btn-lg btn-outline-primary btn-block" style="width:150px" type="submit">Envoyer</button>
                    </center>
                </form>
            </div>
        </div>

    </body>

    <?php require_once "includes/footer.php"; ?>    

</html>
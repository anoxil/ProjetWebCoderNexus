<?php


function afficherImage($loginUser)
{
    require ("includes/connect.php");

    $MaRequete="SELECT * FROM COMPTES WHERE login_user='$loginUser' ";
    $MonRs=$BDD->query($MaRequete);

    echo "<div class='row'>";
    if($Tuple=$MonRs->fetch())
    { 
        if (!empty($Tuple['image']))
        {
            $image = $Tuple['image'];
            echo "<div class='border col-xs-6'> <img src='$image' height=500/> </div>";        
        }
    }
}


function afficherCompte($loginUser)
{
    require ("includes/connect.php");

    $MaRequete="SELECT * FROM COMPTES WHERE login_user='$loginUser' ";
    $MonRs=$BDD->query($MaRequete);

    if($Tuple=$MonRs->fetch())
    { 
        echo "<ul class='list-unstyled mt-3 mb-4 text-xs-center'>";
        $prenom = $Tuple["PRENOM"]; 
        echo "<li class='lead'> Votre prénom est $prenom </li>";
        $nom = $Tuple["NOM"]; 
        echo "<li class='lead'> Votre nom est $nom </li>";
        $login = $Tuple["LOGIN_USER"];
        echo "<li class='lead'> Votre login est $login </li>";
        $mail = $Tuple["MAIL"];
        echo "<li class='lead'> Votre mail est $mail </li>";
        echo "</ul>";
    }
}


?>
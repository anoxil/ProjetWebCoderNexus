<?php

function afficherCompte($loginUser)
{
    require_once "includes/functions.php";
    $MaRequete = getDb() -> prepare("SELECT * FROM COMPTES WHERE login_user=?");
    $MaRequete -> execute(array($loginUser));

    if($Tuple=$MaRequete->fetch())
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
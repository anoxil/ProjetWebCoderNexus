<?php

function InsererCompte($loginUser,$nom,$prenom,$mail,$mdp)
{
    require_once "includes/connect.php";
    require_once "includes/functions.php";
   
    $MaRequete = getDb() -> prepare("INSERT INTO COMPTES(LOGIN_USER, NOM, PRENOM, MAIL, MDP)
    VALUES(:LOGIN_USER, :NOM, :PRENOM, :MAIL, :MDP)"); 

    $MaRequete->bindValue('LOGIN_USER', $loginUser, PDO::PARAM_STR); 
    $MaRequete->bindValue('NOM', $nom, PDO::PARAM_STR);
    $MaRequete->bindValue('PRENOM', $prenom, PDO::PARAM_STR);
    $MaRequete->bindValue('MAIL', $mail, PDO::PARAM_STR);
    $MaRequete->bindValue('MDP', $mdp, PDO::PARAM_STR);

    $MaRequete->execute();
};
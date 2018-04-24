<?php
    //récupération des données pour affichages des infos du tutoriel
    require_once "includes/functions.php";


    $contenus = getDb() -> prepare("SELECT NIVEAU, LANGAGE, LIEN, INTITULE, ID FROM TUTORIELS WHERE ID=?");
    $contenus -> execute(array($_GET['id']));
    $resultat = $contenus -> fetch();


    //récupération/traitement des données pour le vote
    if(isset($_SESSION['loginUser'])) {

        //RECUPERATION VOTES
        $contenus = getDb() -> prepare("SELECT VOTE_USER FROM VOTES WHERE ID_USER=".$_SESSION['id']." AND ID_TUTORIAL=?");
        $contenus -> execute(array($_GET['id']));
        $votes = $contenus -> fetchAll();
        $quantity_vote = count($votes);


        //AFFICHAGE VOTE

        //pour récupérer le vote s'il vient de voter (affichage)
        if(isset($_GET['vote']) && ($_GET['vote']<=5) && ($_GET['vote']>=1)) { 
            $star_number = $_GET['vote'];
        }
        //pour récupérer le vote s'il a déjà été réalisé (affichage)
        if(!isset($_GET['vote']) && ($quantity_vote == 1)) {
            $star_number = $votes[0]['VOTE_USER'];
        }


        //INTERACTION BDD

        if (isset($_GET['vote']) && ($_GET['vote']<=5) && ($_GET['vote']>=1)) {
            //si l'utilisateur a auparavant voté et veut voter, on supprime son vote
            if($quantity_vote == 1)  {
                $requete = getDb() -> prepare("DELETE FROM VOTES WHERE ID_USER=".$_SESSION['id']." AND ID_TUTORIAL=?");
                $requete -> execute(array($_GET['id']));
            }

            //qu'il vote pour la première ou n-ième fois, on ajoute son vote
            $requete = getDb() -> prepare("INSERT INTO VOTES (ID_USER, VOTE_USER, ID_TUTORIAL) VALUES (?, ?, ?)");
            $requete -> execute(array($_SESSION['id'], $star_number, $_GET['id']));
        }



        //PARTICIPATION AU COURS

        if (isset($_GET['enrollment']) && ($_GET['enrollment']<=1) && ($_GET['enrollment']>=0)) {

            //récupération de l'état actuel de la participation
            $requete = "SELECT ETAT FROM PARTICIPATIONS WHERE ID_USER=".$_SESSION['id']." AND ID_TUTORIAL=".$_GET['id'];
            $contenus = $BDD -> query($requete);
            $contenus = getDb() -> prepare("SELECT ETAT FROM PARTICIPATIONS WHERE ID_USER=? AND ID_TUTORIAL=?");
            $contenus -> execute(array($_SESSION['id'], $_GET['id']));
            $etats = $contenus -> fetchAll();
            $quantity_etat = count($etats);

            //si l'utilisateur a auparavant indiqué sa participation, on supprime son vote
            if($quantity_etat == 1)  {
                $requete = getDb() -> prepare("DELETE FROM PARTICIPATIONS WHERE ID_USER=? AND ID_TUTORIAL=?");
                $requete -> execute(array($_SESSION['id'], $_GET['id']));
            }

            //qu'il indique pour la première ou n-ième fois, on ajoute son état
            $requete = getDb() -> prepare("INSERT INTO PARTICIPATIONS (ID_USER, ID_TUTORIAL, ETAT) VALUES (?, ?, ?)");
            $requete -> execute(array($_SESSION['id'], $_GET['id'], $_GET['enrollment']));
        }

    }
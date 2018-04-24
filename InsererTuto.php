<?php

function InsererTuto($lien,$langage,$date,$niveau,$intitule,$screen)
{
    require_once "includes/functions.php";
   
    $MaRequete= getDb()->prepare("INSERT INTO TUTORIELS(LIEN, LANGAGE, DATE, NIVEAU, INTITULE)
    VALUES(:LIEN, :LANGAGE, :DATE, :NIVEAU, :INTITULE)"); 

    $MaRequete->bindValue('LIEN', $lien, PDO::PARAM_STR); 
    $MaRequete->bindValue('LANGAGE', $langage, PDO::PARAM_STR);
    $MaRequete->bindValue('DATE', $date, PDO::PARAM_STR);
    $MaRequete->bindValue('NIVEAU', $niveau, PDO::PARAM_INT);
    $MaRequete->bindValue('INTITULE', $intitule, PDO::PARAM_STR);

    $MaRequete->execute();

    //si on veut ajouter un screenshot de la page principale du tutoriel
    if(!empty($screen)){
        //appeler Google PageSpeed Insights API
        $url = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$lien&screenshot=true";

        //sécurité ssl pour accèder au lien, on utilise le certificat cacert.pem
        $arrContextOptions=array(
            "ssl"=>array(
                "cafile" => "includes/cacert.pem",
                "verify_peer"=> true,
                "verify_peer_name"=> true,
            ),
        );

        $googlePagespeedData = file_get_contents($url, false, stream_context_create($arrContextOptions));
        
        //decode json data
        $googlePagespeedData = json_decode($googlePagespeedData, true);

        //récupération des données du screenshot de l'api
        $img = $googlePagespeedData['screenshot']['data'];
        
        //traduction des données en base64
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(array('_','-'),array('/','+'), $img);
        $fileData = base64_decode($img);

        $MaRequete= getDb() ->prepare("SELECT ID FROM TUTORIELS WHERE INTITULE = :INTITULE");
        $MaRequete->bindValue('INTITULE', $intitule, PDO::PARAM_STR);
        $MaRequete->execute();
        $resultats = $MaRequete->fetch();

        //on sauvegarde l'image dans le dossier images/tutoriels/
        $fileName = 'images/tutoriels/'.$resultats["ID"].'.jpeg';
        file_put_contents($fileName, $fileData);
    }
};
<?php

function InsererTuto($lien,$langage,$date,$niveau,$intitule,$screen)
{
    require ("includes/connect.php");
   
    $MaRequete=$BDD->prepare("INSERT INTO TUTORIELS(LIEN, LANGAGE, DATE, NIVEAU, INTITULE)
    VALUES(:LIEN, :LANGAGE, :DATE, :NIVEAU, :INTITULE)"); 

    $MaRequete->bindValue('LIEN', $lien, PDO::PARAM_STR); 
    $MaRequete->bindValue('LANGAGE', $langage, PDO::PARAM_STR);
    $MaRequete->bindValue('DATE', $date, PDO::PARAM_STR);
    $MaRequete->bindValue('NIVEAU', $niveau, PDO::PARAM_INT);
    $MaRequete->bindValue('INTITULE', $intitule, PDO::PARAM_STR);

    $MaRequete->execute();

    if(!empty($screen)){
        //call Google PageSpeed Insights API
        $url = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$lien&screenshot=true";

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

        //screenshot data
        $img = $googlePagespeedData['screenshot']['data'];
        
        $img = str_replace('data:image/jpeg;base64,', '', $img);
        $img = str_replace(array('_','-'),array('/','+'), $img);
        $fileData = base64_decode($img);
        //saving

        $MaRequete=$BDD->prepare("SELECT ID FROM TUTORIELS WHERE INTITULE = :INTITULE");
        $MaRequete->bindValue('INTITULE', $intitule, PDO::PARAM_STR);
        $MaRequete->execute();
        $resultats = $MaRequete->fetch();

        $fileName = 'images/tutoriels/'.$resultats["ID"].'.jpeg';
        file_put_contents($fileName, $fileData);
    }
};
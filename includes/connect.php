<?php

try {
    $BDD = new PDO( "mysql:host=localhost;dbname=codernexus;charset=utf8", "admin", "password",
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION) );
}
catch (Exception $e) {
    die('Erreur fatale : '.$e->getMessage());
}
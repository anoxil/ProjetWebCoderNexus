<?php

function getDb() {
    
    $server = "localhost";
    $username = "admin";
    $password = "password";
    $db = "codernexus";
    
    return new PDO("mysql:host=$server;dbname=$db;charset=utf8", "$username", "$password",
    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}

function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8', false);
}
<?php

try{
    $pdo = new PDO("mysql:host=localhost;dbname=bot_telegram","root","");
}
catch(PDOException $e){
    exit("Error: " . $e -> getMessage());
}

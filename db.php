<?php
// Database Connection
$dsn = "mysql:host=localhost;port=8889;dbname=test;charset=utf8mb4";
$user = "root" ; // root at home
$pass = "root" ;

try {
    $db = new PDO($dsn, $user, $pass) ;
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
} catch(PDOException $ex) {
    echo "Connection Problem" ;
    exit ;
}

function getGame($id) {
    global $db;
    $stmt = $db->prepare("select * from games where id = ?") ;
    $stmt->execute([$id]) ;
    return $stmt->fetch(PDO::FETCH_ASSOC) ;
}


<?php


/*$host     = 'localhost';
$user     = 'root';
$password = 'linux1404';
$dbName   = 'vcub';*/

$host     = 'mastere.estei.fr';
$user     = 'admin';
$password = 'Rs3JYqFn';
$dbName   = 'vcub';

$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8";

$pdo;

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $errMsg = 'Connection error: ' . $e->getMessage();
}

// (2) Définition d'une requête

$sql  = 'SELECT * ';
$sql .= 'FROM stations';

// (3) Exécution de la requête sur le serveur
try {
    $stt = $pdo->prepare($sql);
    $stt->execute();
} catch (PDOException $e) {
    $queryError = true;
    $errMsg = 'Query error : ' . $e->getMessage();
}

echo json_encode($stt->fetchAll(PDO::FETCH_OBJ));




// (5) Fermeture de la connexion à la base de données
$pdo = null;




?>
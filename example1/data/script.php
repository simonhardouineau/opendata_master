<?php
$url = 'http://data.bordeaux-metropole.fr/wfs?key=L41H8QG4KZ&service=wfs&exceptions=application/json&version=1.0.0&request=getFeature&typeName=CI_VCUB_P';

$xml = simplexml_load_file($url);

$stations = $xml->xpath("//gml:featureMember");
$tabStations = array();
$tabEtat = array();

$i=0;
foreach($stations as $station){
    $tabStations[]=array();
    $tabEtat[]=array();

    $tabStations[$i]["id"] = $station->xpath("//ms:GID")[$i]->__toString();
    $tabStations[$i]["nom"] = $station->xpath("//ms:NOM")[$i]->__toString();
    $coord = explode(" ", $station->xpath("//gml:coordinates")[$i]->__toString());
    $tabStations[$i]["coord"] = $coord[0];/*explode(",", $coord[0]);*/
    $tabStations[$i]["type"] = $station->xpath("//ms:TYPE")[$i]->__toString();


    $tabEtat[$i]["id"] = $station->xpath("//ms:GID")[$i]->__toString();
    $tabEtat[$i]["etat"] = $station->xpath("//ms:ETAT")[$i]->__toString();
    $tabEtat[$i]["places"] = $station->xpath("//ms:NBPLACES")[$i]->__toString();
    $tabEtat[$i]["velos"] = $station->xpath("//ms:NBVELOS")[$i]->__toString();
    $tabEtat[$i]["heure"] = $station->xpath("//ms:HEURE")[$i]->__toString();
    $i++;
}
//print_r($tabStations);
//print_r($tabEtat);


// DB CONNECTION
$dbconf = json_decode(file_get_contents(__DIR__.'/../_db/conf.json'),true);
$mysqli = new mysqli($dbconf["host"], $dbconf["username"], $dbconf["passwd"], $dbconf["dbname"]);
$mysqli->set_charset ( "utf8");

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}


// QUERY BUILDING

/*
 * AJOUTER LES STATIONS
 *
 * $query="INSERT INTO `dv_vcub`.`station` (`id`, `nom`, `coord`, `type`) VALUES";

foreach($tabStations as $key => $station){
    if($key > 0){
        $query .= ",";
    }
    $query .= " (".$station["id"].", '".addslashes($station["nom"])."', '".$station["coord"]."', '".addslashes($station["type"])."')";
}
$query .= ";";

echo $query;*/

$query="INSERT INTO `dv_vcub`.`state` (`id`, `station`, `etat`, `date`, `velos`, `places`) VALUES";

foreach($tabEtat as $key => $station){
    if($key > 0){
        $query .= ",";
    }
    $query .= " ( null, ".$station["id"].", '".addslashes($station["etat"])."', '".$station["heure"]."', '".$station["velos"]."', '".$station["places"]."')";
}
$query .= ";";

echo $query;

$mysqli->query($query);

$mysqli->close();

/*INSERT INTO `dv_vcub`.`state` (`id`, `station`, `status`, `date`, `cycle`, `space`) VALUES (NULL, '36', 'CONNECTEE', CURRENT_TIMESTAMP, '12', '9')
*/
?>


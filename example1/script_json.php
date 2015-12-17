<?php
$url = 'http://data.bordeaux-metropole.fr/wfs?key=L41H8QG4KZ&service=wfs&exceptions=application/json&version=1.0.0&request=getFeature&typeName=CI_VCUB_P';

$xml = simplexml_load_file($url);

$stations = $xml->xpath("//gml:featureMember");
$tabStations = array();
$tabEtat = array();

$tabCombi = array();

$i=0;
foreach($stations as $station){
    $tabStations[]=array();
    $tabEtat[]=array();

    $tabCombi[$i]["id"] = $tabStations[$i]["id"] = $station->xpath("//ms:GID")[$i]->__toString();
    $tabCombi[$i]["nom"] = $tabStations[$i]["nom"] = $station->xpath("//ms:NOM")[$i]->__toString();
    $coord = explode(" ", $station->xpath("//gml:coordinates")[$i]->__toString());
    $tabCombi[$i]["coord"] = $tabStations[$i]["coord"] = $coord[0];/*explode(",", $coord[0]);*/
    $tabCombi[$i]["type"] = $tabStations[$i]["type"] = $station->xpath("//ms:TYPE")[$i]->__toString();


    $tabEtat[$i]["id"] = $station->xpath("//ms:GID")[$i]->__toString();
    $tabCombi[$i]["etat"] = $tabEtat[$i]["etat"] = $station->xpath("//ms:ETAT")[$i]->__toString();
    $tabCombi[$i]["places"] = $tabEtat[$i]["places"] = $station->xpath("//ms:NBPLACES")[$i]->__toString();
    $tabCombi[$i]["velos"] = $tabEtat[$i]["velos"] = $station->xpath("//ms:NBVELOS")[$i]->__toString();
    $tabCombi[$i]["heure"] = $tabEtat[$i]["heure"] = $station->xpath("//ms:HEURE")[$i]->__toString();
    $i++;
}

header('Content-type: application/json');
echo json_encode($tabCombi);

?>


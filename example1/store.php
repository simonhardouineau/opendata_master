<?php
require __DIR__ . '/vendor/autoload.php';

class stations{

}

$dbconf = json_decode(file_get_contents(__DIR__.'/_db/conf.json'),true);
$mysqli = new mysqli($dbconf["host"], $dbconf["username"], $dbconf["passwd"], $dbconf["dbname"]);
$mysqli->set_charset ( "utf8");
$resultArray = [];

if ($mysqli->connect_errno) {
    printf("Échec de la connexion : %s\n", $mysqli->connect_error);
    exit();
}

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url = 'http://data.bordeaux-metropole.fr/wfs?key=F588CKHF4H&service=wfs&exceptions=application/json&version=1.0.0&request=getFeature&typeName=CI_VCUB_P';

$xml = file_get_contents($url, false, $context);

$stations = [];

$reader = new Sabre\Xml\Reader();
$reader->elementMap = [
    // handle a single station
    '{http://www.opengis.net/gml}featureMember' => function($reader) {
        $station = [];
        // Borrowing a parser from the KeyValue class.
        $row = Sabre\Xml\Element\KeyValue::xmlDeserialize($reader)["{http://mapserver.gis.umn.edu/mapserver}CI_VCUB_P"];


        if (isset($row[4]["value"])) {
            $station["type"] = $row[4]["value"];
        }
        if (isset($row[5]["value"])) {
            $station["name"] = $row[5]["value"];
        }
        if (isset($row[0]["value"][0]["value"][0]["value"])) {
            $station["coord"] = $row[0]["value"][0]["value"][0]["value"];
        }

        print_r( /*$stations[$row[2]["value"]]=*/$station);
    },
];
$reader->xml($xml);
$reader->parse()

//print_r($stations);

/*
$query="INSERT INTO `dv_vcub`.`station` (`id`, `name`, `coord`, `available`) VALUES";



foreach(json_decode($json, true) as $i => $row){
    if($i > 0){
        $query .= ",";
    }
    $query .= " (NULL, '".addslashes($row["name"])."', '".addslashes($row["fullName"])."', '".addslashes($row["price"])."', '".addslashes($row["category"])."')";
}
$query .= ";";

echo $query;

$mysqli->query($query);

$mysqli->close();*/

?>
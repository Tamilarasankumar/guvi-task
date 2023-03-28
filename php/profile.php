<?php
require_once __DIR__ . '/../vendor/autoload.php';


$redis=new Redis();
$redis->connect('127.0.0.1',6379);
$redis->set('ProfileInfo', json_encode(array('name' => $_POST['name'], 'age' => $_POST['age'], 'date' => $_POST['date'], 'contact' => $_POST['contact'] )));

global $name;
if(isset($_POST['name']))
$name= $_POST['name'];
global $age;
if(isset($_POST['age']))
$age= $_POST['age'];
global $date;
if(isset($_POST['date']))
$date= $_POST['date'];
global $contact;
if(isset($_POST['contact']))
$contact= $_POST['contact'];
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->guvi;
$collection = $db->userprofile;

$insertOneResult = $collection->insertOne([
   
    'name' => $name,
    'age' => $age,
    'date' => $date ,
    'contact' => $contact
]);

if ($insertOneResult->getInsertedCount() == 1) {
    header("Location: ../index.html");
} else {
    echo "Error storing data.";
}
?>

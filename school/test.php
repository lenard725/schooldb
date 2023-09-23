<?php

require '../vendor/autoload.php';

// connect to mongodb
$con = new MongoDB\Client("mongodb://localhost:27017");
echo "Connection to database successfully";
// select a database

$db = $con->SchoolDB;
echo "Database SchoolDB selected";

//select collection
$col = $db->AdminAccount;
echo "Collection StudentAccount Selected";



$document = array(
    "email" => "testadminaccount@gmail.com",
    "password" => "testpassword"
);

$col ->insertOne($document);



?>
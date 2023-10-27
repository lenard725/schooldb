<?php

require '../vendor/autoload.php';

// connect to mongodb
$con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
echo "Connection to database successfully";
// select a database

$db = $con->SchoolDB;
echo "Database SchoolDB selected";

//select collection
$col = $db->StudentAccount;
echo "Collection StudentAccount Selected";


if (isset($_POST['submit'])) {



    $updateResult = $col->updateOne(
        ['idnumber' => '0123-012345'],
        ['$set' => ['status' => 'not enrolled']]
    );
}




?>

<html>

<body>

    <form action="test.php " method='post'>
        <input type="submit" name="submit" value="update">
    </form>
</body>


</html>
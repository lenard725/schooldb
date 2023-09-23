<?php

session_start();

require '../vendor/autoload.php';

if (!isset($_SESSION["log1authentication"])) {
    header("Location: login.php");
    exit();
}

$con = new MongoDB\Client("mongodb://localhost:27017");
//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->StudentAccount;
//echo "Collection StudentAccount Selected";
$finduser = $col->find(array('email' => $_SESSION["thissessionemail"]));

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sidenav.css">
    <link rel="stylesheet" href="./css/clearance.css">
</head>

<body>
    <div class="sidenav">

        <div class="accountName">
            <div class="aimage" style="width: 35%; float: left; overflow: hidden; height: 100%;">

            </div>

            <div class="aName">
                <h3>Student Name</h3>
                <p>Grade Level - Section</p>
            </div>
        </div>

        <a href="./studentprofile.php">Profile</a>
        <a href="./classenrollment.php">Class Enrollment</a>
        <a href="./scheduleviewer.php">Schedule Viewer</a>
        <a href="./clearance.php" class="active">Clearance Information</a>
        <a href="./grades.php">Grades</a>

        <form action="studentprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>
    </div>

    </div>

    <div class="main">

        <div class="aNameex">

            <?php

            foreach ($finduser as $founduser) {
                $studentname = $founduser['name'];
                $idnumber = $founduser['idnumber'];

                echo "<h1 style='font-size: 30px; margin-left: 20px;'><b>Student Name:</b>&nbsp&nbsp&nbsp" . $studentname . "</h1>";
                echo "<p style='font-size: 20px; margin-left: 20px;'><b>Student ID:</b>&nbsp&nbsp&nbsp" . $idnumber . "</p>";


            }

            ?>

            <!-- <h1 style="font-size: 50px; margin-left: 20px;">Name</h1>
            <p style="font-size: 20px; margin-left: 20px;">Student No.</p> -->
        </div>

        <!-- display if have record -->
        <div class="balancerecord">
            <h3>Balance</h3>
        </div>

        <!-- display if not -->
        <!-- <div class="balancerecordclear">
            <h3>GOOD NEWS! You are cleared !</h3>

        </div> -->
    </div>

</body>

</html>
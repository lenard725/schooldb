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
    <link rel="stylesheet" href="./css/grades.css">
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
        <a href="./clearance.php">Clearance Information</a>
        <a href="./grades.php" class="active">Grades</a>

    </div>

    <div class="main">
        <div class="title">
            <h1>Grades</h1>
            <h3>Grade X</h3>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Subject</th>
                        <th scope="col">First Grading</th>
                        <th scope="col">Second Grading</th>
                        <th scope="col">Third Grading</th>
                        <th scope="col">Fourth Grading</th>
                    </tr>
                </thead>
                <tbody>

                <?php 
                
                foreach($finduser as $founduser){
                    echo "<tr> <th scope='row'>Math</th>";
                    echo "<td>" . $founduser['math']['first_grading'] . "</td>";
                    echo "<td>" . $founduser['math']['second_grading'] . "</td>";
                    echo "<td>" . $founduser['math']['third_grading'] . "</td>";
                    echo "<td>" . $founduser['math']['fourth_grading'] . "</td>";

                    echo "<tr> <th scope='row'>Science</th>";
                    echo "<td>" . $founduser['science']['first_grading'] . "</td>";
                    echo "<td>" . $founduser['science']['second_grading'] . "</td>";
                    echo "<td>" . $founduser['science']['third_grading'] . "</td>";
                    echo "<td>" . $founduser['science']['fourth_grading'] . "</td>";

                    echo "<tr> <th scope='row'>Filipino</th>";
                    echo "<td>" . $founduser['filipino']['first_grading'] . "</td>";
                    echo "<td>" . $founduser['filipino']['second_grading'] . "</td>";
                    echo "<td>" . $founduser['filipino']['third_grading'] . "</td>";
                    echo "<td>" . $founduser['filipino']['fourth_grading'] . "</td>";

                    echo "<tr> <th scope='row'>English</th>";
                    echo "<td>" . $founduser['english']['first_grading'] . "</td>";
                    echo "<td>" . $founduser['english']['second_grading'] . "</td>";
                    echo "<td>" . $founduser['english']['third_grading'] . "</td>";
                    echo "<td>" . $founduser['english']['fourth_grading'] . "</td>";
                }

                ?>

                    <!-- <tr>
                        <th scope="row">Math</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Science</th>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <th scope="row">Filipino</th>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr>
                    <tr>
                        <th scope="row">English</th>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                    </tr> -->
                </tbody>
            </table>
        </div>
    </div>


</body>

</html>
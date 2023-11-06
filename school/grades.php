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
$subjectcol = $db->schoolsubject;
$finduser = $col->find(array('email' => $_SESSION["thissessionemail"]));
$findsubject = $subjectcol->find(array('gradelevel' => $_SESSION['thissessiongradelevel']))->toArray();

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
                <?php echo "<h3>" . $_SESSION["thissessionname"] . "</h3>" ?>
                <?php echo "<p>" . $_SESSION['thissessiongradelevel'] . " - " . $_SESSION["thissessionsection"] . "</p>" ?>
            </div>
        </div>


        <a href="./studentprofile.php">Profile</a>
        <a href="./classenrollment.php">Class Enrollment</a>
        <a href="./scheduleviewer.php">Schedule Viewer</a>
        <a href="./clearance.php">Clearance Information</a>
        <a href="./grades.php" class="active">Grades</a>

        <form action="studentprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>
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

                    foreach ($finduser as $founduser) {

                        foreach ($findsubject as $thissubject) {

                            if (isset($founduser[$thissubject['subject']]['first_grading'])) {
                                echo "<tr> <th scope='row'>{$thissubject['subject']}</th>";
                                echo "<td>" . $founduser[$thissubject['subject']]['first_grading'] . "</td>";
                                echo "<td>" . $founduser[$thissubject['subject']]['second_grading'] . "</td>";
                                echo "<td>" . $founduser[$thissubject['subject']]['third_grading'] . "</td>";
                                echo "<td>" . $founduser[$thissubject['subject']]['fourth_grading'] . "</td>";
                                echo "</tr>";
                            } else {
                                $updatethis = $col->updateOne(

                                    ['idnumber' => $founduser['idnumber']],
                                    [
                                        '$set' => [
                                            $thissubject['subject'] => [
                                                'first_grading' => '',
                                                'second_grading' => '',
                                                'third_grading' => '',
                                                'fourth_grading' => '',
                                            ]
                                        ]
                                    ]

                                );
                            }
                        }
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
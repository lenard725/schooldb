<?php

session_start();

require '../../vendor/autoload.php';

if (!isset($_SESSION["log2authentication"])) {
    header("Location: ../login2.php");
    exit();
}

// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
$con = new MongoDB\Client("mongodb://localhost:27017/");

//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->ScheduleDB;
//echo "Collection ScheduleDB Selected";
$findschedule = $col->find([], ['sort' => ['section' => 1]]);

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css?<?php echo time() ?>">
    <link rel="stylesheet" href="./css/employeeaccount.css? <?php echo time() ?>">
</head>

<body>
    <div class="sidenav">

        <div class="accountName">
            <div class="aimage" style="width: 40%; float: left; overflow: hidden; height: 100%;">

            </div>

            <div class="aName">
                <h3>
                    <?php echo $_SESSION["thissessionname"]; ?>
                </h3>
                <p>Admin</p>
            </div>
        </div>

        <a href="./Employeeprofile.php">Profile</a>
        <a href="./employeeaccount.php">Accounts</a>
        <a href="./employeeenroll.php">Enroll Students</a>
        <a href="./employeesection.php">Sections</a>
        <a href="./employeeaddschedule.php" class="active">Class Schedules</a>
        <a href="./employeeforms.php">Forms</a>
        <a href="./employeerecords.php">Records</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <!-- <div class="mainselect">
            <select name="sections" id="section">
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>

            </select>
        </div> -->

        <div class="accountssheet">
            <div>
                <form action='employeeaddschedule.php' method='POST'>
                    <table class="table table-bordered">
                        <thead class="thead">
                            <tr>
                                <th></th>
                                <th id="x1strow" scope="col">Subject Name</th>
                                <th scope="col">Day</th>
                                <th scope="col">Time</th>
                                <th scope="col">Teacher</th>
                                <th scope="col">Section</th>
                            </tr>
                        </thead>
                        <!-- get expanded in php loop -->
                        <tbody>

                            <?php

                            foreach ($findschedule as $foundschedule) {
                                echo "<tr>";
                                echo "<th><input type='checkbox' name='schedulenumber[]' value='" . $foundschedule['scheduleuniquenumber'] . "'></th>";
                                echo "<th>" . $foundschedule['subject'] . "</td>";
                                echo "<td>" . $foundschedule['day'] . "</td>";
                                echo "<td>" . $foundschedule['timestart'] . " - " . $foundschedule['timeend'] . "</td>";
                                echo "<td>" . $foundschedule['teacher'] . "</td>";
                                echo "<td>" . $foundschedule['section'] . "</td>";
                            }

                            ?>

                        </tbody>
                    </table>
                    <input type="submit" id="deleteschedulebtn" name="deleteschedule" value="Delete Schedule">
                </form>

                <form action="employeeaddschedule.php" method="POST">
                    <input type="submit" id="addschedulebtn" name="addschedule" value="Add Schedule">
                </form>
            </div>
        </div>

    </div>
</body>

<?php

if (isset($_POST['addschedule'])) {
    echo "<script> window.location.href='addschedule.php';</script>";
}

if (isset($_POST['deleteschedule'])) {

    foreach ($_POST['schedulenumber'] as $listofschedule) {
        $deletethis = $col->deleteOne(
            ['scheduleuniquenumber' => $listofschedule]
        );
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

?>



</html>
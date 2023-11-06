<?php

session_start();

require '../vendor/autoload.php';

if (!isset($_SESSION["log1authentication"])) {
    header("Location: login.php");
    exit();
}

// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
$con = new MongoDB\Client("mongodb://localhost:27017/");

//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->ScheduleDB;
$subjectcol = $db->schoolsubject;
//echo "Collection ScheduleDB Selected";
$findschedule = $col->find(['section' => $_SESSION['thissessionsection']], ['sort' => ['timestart' => 1]])->toArray();
$findsubject = $subjectcol->find();



?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sidenav.css">
    <link rel="stylesheet" href="./css/scheduleviewer.css?<?php echo time() ?>">
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
        <a href="./scheduleviewer.php" class="active">Schedule Viewer</a>
        <a href="./clearance.php">Clearance Information</a>
        <a href="./grades.php">Grades</a>

        <form action="studentprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">
        <div class="row">
            <div class="col-sm-8">
                <h1>Student's schedule</h1>
            </div>

            <div class="col-sm-3">
                <div class="schoolyear">
                    <h2>
                        <?php echo $_SESSION['thissessiongradelevel'] ?>
                    </h2>
                </div>
            </div>
        </div>

        <div class="schedulepanel">

            <table class="table table-bordered">
                <thead class="thead">
                    <tr>
                        <th id="x1strow" scope="col">Subject Name</th>
                        <th scope="col">Day and Time</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($findsubject as $x => $foundsubject) {

                        $subjectfind = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection']));

                        $mondayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Monday"));
                        $mondayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Monday"))->toArray();
                        $tuesdaychedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Tuesday"));
                        $tuesdaychedule2 = $col->find(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Tuesday"))->toArray();
                        $wednesdayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Wednesday"));
                        $wednesdayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Wednesday"))->toArray();
                        $thursdayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Thursday"));
                        $thursdayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Thursday"))->toArray();
                        $fridayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Friday"));
                        $fridayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'section' => $_SESSION['thissessionsection'], 'day' => "Friday"))->toArray();

                        if ($subjectfind != 0) {
                            echo "<tr>";
                            echo "<th>" . $foundsubject['subject'] . "</th>";
                            echo "<td>";


                            if ($mondayschedule == 1) {

                                foreach ($mondayschedule2 as $time) {
                                    echo "<b>Monday</b>({$time['timestart']} - {$time['timeend']})";
                                }

                                if ($tuesdaychedule == 1) {
                                    echo " <b>Tuesday</b>({$time['timestart']} - {$time['timeend']})";
                                }

                                if ($wednesdayschedule == 1) {
                                    echo " <br><b>Wednesday</b>({$time['timestart']} - {$time['timeend']})";
                                }
                                if ($thursdayschedule == 1) {
                                    echo " <b>Thursday</b>({$time['timestart']} - {$time['timeend']})";
                                }
                                if ($fridayschedule == 1) {
                                    echo " <b>Friday</b>({$time['timestart']} - {$time['timeend']})";
                                }

                                echo "</td>";
                            }
                        }
                    }

                    ?>




                </tbody>

            </table>



        </div>
    </div>

</body>

</html>
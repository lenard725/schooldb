<?php

session_start();

require '../../vendor/autoload.php';

if (!$_SESSION["log2authentication"]) {
    header("Location: ../login2.php");
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
$findschedule = $col->find(['teacher' => $_SESSION['thissessionname']], ['sort' => ['timestart' => 1]])->toArray();
$findsubject = $subjectcol->find();

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="./css/teachersidenav.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/teacherschedule.css">
</head>

<body>
    <div class="sidenav">

        <div class="accountName">
            <div class="aimage" style="width: 40%; float: left; overflow: hidden; height: 100%;">

            </div>

            <div class="aName">
                <h2>Name</h2>
                <p>Department Name</p>
            </div>
        </div>

        <a href="./teacherprofile.php">Profile</a>
        <a href="./teacherclass.php">Class</a>
        <a href="./teacherschedule.php" class="active">Schedule Viewer</a>
        <a href="./teacherform.php">Forms</a>
        <a href="./teacherencode.php">Encode Grade</a>

        <form action="teacherprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">
        <div class="row">
            <div class="col-sm-8">
                <h1>Teacher's schedule</h1>
            </div>

            <div class="col-sm-3">
                <div class="schoolyear">
                    <p>SY 2022-2023</p>
                    <p>Grade X</p>
                </div>
            </div>
        </div>

        <div class="schedulepanel">


            <table class="table table-bordered">
                <thead class="thead">
                    <tr>
                        <th id="x1strow" scope="col">Subject Name</th>
                        <th scope="col">[Day(Time) - Section]</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    foreach ($findsubject as $x => $foundsubject) {

                        $subjectfind = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname']));

                        $mondayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Monday"));
                        $mondayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Monday"))->toArray();
                        $tuesdayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Tuesday"));
                        $tuesdayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Tuesday"))->toArray();
                        $wednesdayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Wednesday"));
                        $wednesdayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Wednesday"))->toArray();
                        $thursdayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Thursday"));
                        $thursdayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Thursday"))->toArray();
                        $fridayschedule = $col->countDocuments(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Friday"));
                        $fridayschedule2 = $col->find(array('subject' => $foundsubject['subject'], 'teacher' => $_SESSION['thissessionname'], 'day' => "Friday"))->toArray();

                        if ($subjectfind != 0) {
                            echo "<tr>";
                            echo "<th><br>" . $foundsubject['subject'] . "</th>";
                            echo "<td>";


                            if ($mondayschedule != 0) {

                                foreach ($mondayschedule2 as $time) {
                                    echo "<br>[<b>Monday</b>({$time['timestart']} - {$time['timeend']}) - <b>{$time['section']}</b> ]";
                                }
                            }

                            if ($tuesdayschedule != 0) {
                                foreach ($tuesdayschedule2 as $time) {
                                    echo "<br>[<b>Tuesday</b>({$time['timestart']} - {$time['timeend']}) - <b>{$time['section']}</b> ]";
                                }
                            }

                            if ($wednesdayschedule != 0) {
                                foreach ($wednesdayschedule2 as $time) {
                                    echo "<br>[<b>Wednesday</b>({$time['timestart']} - {$time['timeend']}) - <b>{$time['section']}</b> ]";
                                }
                            }
                            if ($thursdayschedule != 0) {
                                foreach ($thursdayschedule2 as $time) {
                                    echo "<br>[<b>Thursday</b>({$time['timestart']} - {$time['timeend']}) - <b>{$time['section']}</b> ]";
                                }
                            }
                            if ($fridayschedule != 0) {
                                foreach ($fridayschedule2 as $time) {
                                    echo "<br>[<b>Friday</b>({$time['timestart']} - {$time['timeend']}) - <b>{$time['section']}</b> ]";
                                }
                            }

                            echo "</td>";
                        }
                    }


                    ?>

                </tbody>
            </table>

        </div>
    </div>

</body>

</html>
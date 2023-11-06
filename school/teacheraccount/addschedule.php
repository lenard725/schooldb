<?php

require '../../vendor/autoload.php';

session_start();


if (!isset($_SESSION["log2authentication"])) {
    header("Location: ../login2.php");
    exit();
}

// connect to mongodb
$con = new MongoDB\Client("mongodb://localhost:27017/");
// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
// echo "Connection to database successfully";

// select a database
$db = $con->SchoolDB;
// echo "Database SchoolDB selected";

//select collection
$col = $db->Enrollcol;
// echo "Collection Enrollcol Selected";
$studentcol = $db->StudentAccount;
// echo "Collection Enrollcol Selected";
$subjectcol = $db->schoolsubject;
$teachercol = $db->TeacherAccount;
$sectioncol = $db->SectionDB;
$schedulecol = $db->ScheduleDB;

$findsubject = $subjectcol->find();
$findteacher = $teachercol->find([], ['sort' => ['name' => 1]]);
$findsection = $sectioncol->find([], ['sort' => ['gradelevel' => 1]]);

$schedulecolcount = $schedulecol->countDocuments(array());

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css?<?php echo time() ?>">
    <link rel="stylesheet" href="./css/addschedule.css?<?php echo time() ?>">
</head>

<body>
    <div class="sidenav">

        <div class="accountName">
            <div class="aimage" style="width: 40%; float: left; overflow: hidden; height: 100%;">

            </div>

            <div class="aName">
                <h1>Name</h1>
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

        <div id="element" class="hero-body-schedule">
            <h2>
                <font color="black">Add Schedule List</font>
            </h2>
            <a class="btn btn-primary" href="schedule.php"> <i class="icon-arrow-left icon-large"></i>&nbsp;Back</a>
            <hr>
            <form id="save_voter" class="form-horizontal" method="POST" action="addschedule.php">
                <fieldset>
                    </br>
                    <div class="hai_naku">
                        <ul class="thumbnails_new_voter">
                            <li class="span3">
                                <div class="thumbnail_new_voter">

                                    <div class="control-group">
                                        <label class="control-label" for="input01">Day:</label>

                                        <div class="controls">
                                            <div class="radio_day">
                                                <label for=""> Monday: </label>
                                                <input type="checkbox" value="Monday" name=day[] id="day">
                                                <br>
                                                <label for=""> Tuesday: </label>
                                                <input type="checkbox" value="Tuesday" name=day[] id="day">
                                                <br>
                                                <label for=""> Wednesday: </label>
                                                <input type="checkbox" value="Wednesday" name=day[] id="day">
                                                <br>
                                                <label for=""> Thursday: </label>
                                                <input type="checkbox" value="Thursday" name=day[] id="day">
                                                <br>
                                                <label for=""> Friday: </label>
                                                <input type="checkbox" value="Friday" name=day[] id="day">
                                                <br>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input01">Time Start:</label>
                                        <div class="controls">
                                            <select name="time_start" class="span3333" id="time_start">
                                                <option>--Select--</option>
                                                <?php
                                                $start = "07:00"; //you can write here 00:00:00 but not need to it
                                                $end = "18:00";

                                                $tStart = strtotime($start);
                                                $tEnd = strtotime($end);
                                                $tNow = $tStart;
                                                while ($tNow <= $tEnd) {
                                                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                                                    $tNow = strtotime('+30 minutes', $tNow);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="input01">Time End:</label>
                                        <div class="controls">
                                            <select name="time_end" id="time_end" class="span3333">
                                                <option>--Select--</option>
                                                <?php
                                                $start = "07:00"; //you can write here 00:00:00 but not need to it
                                                $end = "18:00";

                                                $tStart = strtotime($start);
                                                $tEnd = strtotime($end);
                                                $tNow = $tStart;
                                                while ($tNow <= $tEnd) {
                                                    echo '<option value="' . date("H:i", $tNow) . '">' . date("H:i", $tNow) . '</option>';
                                                    $tNow = strtotime('+30 minutes', $tNow);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <label class="control-label" for="input01">Section:</label>
                                        <div class="controls">
                                            <select name="section" class="span3333" id="CYS">
                                                <option>--Select--</option>
                                                <?php
                                                foreach ($findsection as $foundsection) { ?>
                                                    <option value='<?php echo $foundsection['sectionname']; ?>'>
                                                        <?php echo $foundsection['gradelevel'] . "-" . $foundsection['sectionname'] ?>
                                                    </option>
                                                <?php } ?>

                                            </select>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <label class="control-label" for="input01">Subject:</label>
                                        <div class="controls">
                                            <select name="subject" class="span333" id="subject">
                                                <option>--Select--</option>
                                                <?php
                                                foreach ($findsubject as $foundsubject) { ?>
                                                    <option value='<?php echo $foundsubject['subject']; ?>'>
                                                        <?php echo $foundsubject['subject'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="control-group">
                                        <label class="control-label" for="input01">Teacher:</label>
                                        <div class="controls">
                                            <select name="teacher" class="span333" id="teacher">
                                                <option>--Select--</option>
                                                <?php
                                                foreach ($findteacher as $foundteacher) { ?>
                                                    <option value='<?php echo $foundteacher['name']; ?>'>
                                                        <?php echo $foundteacher['name'] ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <div class="controls">
                                        <input type='submit' id="save_voter" class="btn btn-primary" name="save"
                                            value='Save'>
                                    </div>
                                </div>

                                <?php

                                if (isset($_POST['save'])) {

                                    foreach ($_POST['day'] as $x => $daycollection) {

                                        $schedulecolchecker = $schedulecol->find(array('day' => $daycollection, 'timestart' => $_POST['time_start'], 'timeend' => $_POST['time_end'], 'section' => $_POST['section']));
                                        $thisschedulecheck = $schedulecol->countDocuments(array('day' => $daycollection, 'timestart' => $_POST['time_start'], 'timeend' => $_POST['time_end'], 'section' => $_POST['section']));
                                        $thisteachercheck = $schedulecol->countDocuments(array('day' => $daycollection, 'timestart' => $_POST['time_start'], 'timeend' => $_POST['time_end'], 'teacher' => $_POST['teacher']));
                                        $sectiongetter = $schedulecol->find(array('section' => $_POST['section']));
                                        $sectiongettercount = $schedulecol->countDocuments(array('section' => $_POST['section']));


                                        if ($schedulecolcount == 0 || $sectiongettercount == 0) {
                                            $document = array(


                                                'scheduleuniquenumber' => $daycollection . "-" . date("Y/m/d") . "-" . time(),
                                                'day' => $daycollection,
                                                'timestart' => $_POST['time_start'],
                                                'timeend' => $_POST['time_end'],
                                                'subject' => $_POST['subject'],
                                                'teacher' => $_POST['teacher'],
                                                'section' => $_POST['section']

                                            );

                                            $schedulecol->insertOne($document);
                                        } else {

                                            foreach ($sectiongetter as $key => $gotsection) {
                                                $time1 = DateTime::createFromFormat('h:i a', $_POST['time_start']);
                                                $time2 = DateTime::createFromFormat('h:i a', $gotsection['timestart']);
                                                $time3 = DateTime::createFromFormat('h:i a', $gotsection['timeend']);
                                                if (($time1 > $time2 && $time1 < $time3) && $daycollection == $gotsection['day']) {
                                                    echo "<script>alert('Section Time Schedule Overlap')</script>";
                                                    echo "<script> window.location.href='employeeaddschedule.php';</script>";
                                                } else {
                                                    if ($thisschedulecheck == 1) {
                                                        echo "<script>alert('Section Schedule Overlap')</script>";
                                                        echo "<script> window.location.href='employeeaddschedule.php';</script>";
                                                        break;
                                                    } elseif ($thisteachercheck == 1) {
                                                        echo "<script>alert('Teacher Schedule Overlap')</script>";
                                                        echo "<script> window.location.href='employeeaddschedule.php';</script>";
                                                        break;
                                                    } else {
                                                        $document = array(

                                                            'scheduleuniquenumber' => $daycollection . "-" . date("Y/m/d") . "-" . time(),
                                                            'day' => $daycollection,
                                                            'timestart' => $_POST['time_start'],
                                                            'timeend' => $_POST['time_end'],
                                                            'subject' => $_POST['subject'],
                                                            'teacher' => $_POST['teacher'],
                                                            'section' => $_POST['section']

                                                        );

                                                        $schedulecol->insertOne($document);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }

                                ?>


                </fieldset>
            </form>

        </div>


    </div>
</body>




</html>
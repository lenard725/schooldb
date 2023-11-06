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
$col = $db->TeacherAccount;
//echo "Collection TeacherAccount Selected";
$schedulecol = $db->ScheduleDB;
$sectioncol = $db->SectionDB;
$studentcol = $db->StudentAccount;
$subjectcol = $db->schoolsubject;


$finduser = $col->find(array('email' => $_SESSION["thissessionemail"]));

$findschedule = $schedulecol->find(['teacher' => $_SESSION['thissessionname']], ['sort' => ['timestart' => 1]])->toArray();

$findsection = $sectioncol->find()->toArray();
$findsubject = $subjectcol->find()->toArray();
$thisissubject = '';

if (isset($_POST['savegrade'])) {
    echo "<script>alert('success')</script>";
    if (isset($_POST['targetstudent'])) {
        foreach ($_POST['targetstudent'] as $x => $thisstudent) {

            echo "<script>alert({$_POST['targetsubject'][$x]})</script>";

            $updatethis = $studentcol->updateOne(

                ['idnumber' => $thisstudent],
                [
                    '$set' => [
                        $_POST['targetsubject'][$x] => [
                            'first_grading' => $_POST['firstgradingfill'][$x],
                            'second_grading' => $_POST['secondgradingfill'][$x],
                            'third_grading' => $_POST['thirdgradingfill'][$x],
                            'fourth_grading' => $_POST['fourthgradingfill'][$x],
                        ]
                    ]
                ]

            );

        }
    } else {
        echo "<script>alert('asdsadasd')</script>";
    }
}

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/teachersidenav.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/teacherencode.css?<?php echo time(); ?>">
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
        <a href="./teacherschedule.php">Schedule Viewer</a>
        <a href="./teacherform.php">Forms</a>
        <a href="./teacherencode.php" class="active">Encode Grade</a>

        <form action="teacherprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">
        <form action="teacherencode.php" method="POST">
            <div class="mainselect">
                <select name="sections" id="section" onchange="this.form.submit()">
                    <option value=''>Select Section</option>
                    <?php
                    foreach ($findsection as $foundsection) {

                        foreach ($findsubject as $foundsubject) {
                            $findschedule = $schedulecol->countDocuments(array('teacher' => $_SESSION['thissessionname'], 'section' => $foundsection['section']), array('limit' => 1));
                            $findschedule2 = $schedulecol->find(array('teacher' => $_SESSION['thissessionname'], 'section' => $foundsection['sectionname'], 'subject' => $foundsubject['subject']), array('limit' => 1));

                            foreach ($findschedule2 as $foundschedule) {
                                echo "<option value='" . $foundschedule['section'] . "|" . $foundschedule['subject'] . "'>" . $foundschedule['section'] . " - [" . $foundschedule['subject'] . "]</option>";
                            }
                        }
                    }


                    ?>


                </select>
            </div>
            <div class="encodehere">
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th id="x1strow" scope="col">Name</th>
                                <th scope="col">1st Grading</th>
                                <th scope="col">2nd Grading</th>
                                <th scope="col">3rd Grading</th>
                                <th scope="col">4th Grading</th>
                            </tr>
                        </thead>
                        <!-- get expanded in php loop -->
                        <tbody>

                            <?php
                            foreach ($findsection as $foundsection) {

                                $thisissection = "";
                                $section = strval($foundsection['sectionname']);
                                $pattern = "/" . $section . "/";

                                if (isset($_POST['sections'])) {

                                    $sectionchecker = $_POST['sections'];

                                    if (preg_match($pattern, strval($sectionchecker))) {
                                        $thisissection = $foundsection['sectionname'];
                                        // echo $thisissection;
                                    }


                                }

                                //    $findschedule = $schedulecol->countDocuments(array('teacher' => $_SESSION['thissessionname'], 'section' => $foundsection['section']), array('limit' => 1));
                                $findschedule2 = $schedulecol->find(array('teacher' => $_SESSION['thissessionname'], 'section' => $foundsection['sectionname']), array('limit' => 1));

                                if (isset($_POST['sections'])) {
                                    foreach ($findschedule2 as $foundschedule) {

                                        $findstudent = $studentcol->find(array('section' => $thisissection));

                                        foreach ($findsubject as $foundsubject) {
                                            $subject = strval($foundsubject['subject']);
                                            $pattern = "/" . $subject . "/";

                                            if (isset($_POST['sections'])) {

                                                $sectionchecker = $_POST['sections'];

                                                if (preg_match($pattern, strval($sectionchecker))) {
                                                    $thisissubject = $foundsubject['subject'];
                                                    // echo $thisissubject;
                                                }
                                            }
                                        }

                                        foreach ($findstudent as $foundstudent) {

                                            echo "<tr>";
                                            echo "<th scope='row'>{$foundstudent['name']} - {$thisissubject}</th>";
                                            echo "<td><input type='number' id='gradefill' name='firstgradingfill[]' value='";
                                            if (isset($foundstudent[$thisissubject]['first_grading'])) {
                                                echo "{$foundstudent[$thisissubject]['first_grading']}";
                                            }
                                            echo "'min='0' max='100'></td>";
                                            echo "<td><input type='number' id='gradefill' name='secondgradingfill[]' value='";

                                            if (isset($foundstudent[$thisissubject]['second_grading'])) {
                                                echo "{$foundstudent[$thisissubject]['second_grading']}";
                                            }
                                            echo "'min='0' max='100'></td>";
                                            echo "<td><input type='number' id='gradefill' name='thirdgradingfill[]' value='";
                                            if (isset($foundstudent[$thisissubject]['third_grading'])) {
                                                echo "{$foundstudent[$thisissubject]['third_grading']}";
                                            }
                                            echo "'min='0' max='100'></td>";
                                            echo "<td><input type='number' id='gradefill' name='fourthgradingfill[]' value='";

                                            if (isset($foundstudent[$thisissubject]['fourth_grading'])) {
                                                echo "{$foundstudent[$thisissubject]['fourth_grading']}";


                                            }
                                            echo "'min='0' max='100'></td>";

                                            echo "<input type='hidden' name='targetsubject[]' value='{$thisissubject}'> ";
                                            echo "<input type='hidden' name='targetstudent[]' value='{$foundstudent['idnumber']}'> ";

                                            echo "</tr>";
                                        }
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<th scope='row'>Please Select Section</th>";
                                    echo "<td><input type='number' id='gradefill' name='firstgradingfill' disabled></td>";
                                    echo "<td><input type='number' id='gradefill' name='secondgradingfill' disabled></td>";
                                    echo "<td><input type='number' id='gradefill' name='thirdgradingfill' disabled></td>";
                                    echo "<td><input type='number' id='gradefill' name='fourthgradingfill' disabled></td>";
                                    echo "</tr>";
                                    break;
                                }

                            }

                            ?>
                            <!-- <tr>
                            <th scope="row">Student Name</th>
                            <td><input type='number' id='gradefill' name='sectionname[]'></td>
                            <td><input type='number' id='gradefill' name='sectionname[]'></td>
                            <td><input type='number' id='gradefill' name='sectionname[]'></td>
                            <td><input type='number' id='gradefill' name='sectionname[]'></td>
                        </tr> -->

                        </tbody>
                    </table>
                </div>
                <input type="submit" name="savegrade" value="save">
            </div>
        </form>
    </div>

</body>

<?php




?>

</html>
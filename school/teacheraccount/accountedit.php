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
$col = $db->StudentAccount;
//echo "Collection StudentAccount Selected";
$col2 = $db->TeacherAccount;
$col3 = $db->AdminAccount;

$finduser = $col->find();
$finduser3 = $col2->find()->toArray();
$finduser4 = $col3->find()->toArray();

$finduser2 = array_merge($finduser3, $finduser4);

$gradelevelselection = array('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12');
$departmentselection = array('Sta Juliana HS', 'Sta Juliana SHS');


?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css?<?php echo time() ?>">
    <link rel="stylesheet" href="./css/accountedit.css?<?php echo time() ?>">
</head>

<body>
    <div class="sidenav">

        <div class="accountName">
            <div class="aimage" style="width: 40%; float: left; overflow: hidden; height: 100%;">

            </div>

            <div class="aName">
            <h3><?php echo $_SESSION["thissessionname"]; ?></h3>
                <p>Admin</p>
            </div>
        </div>

        <a href="./Employeeprofile.php">Profile</a>
        <a href="./employeeaccount.php" class="active">Accounts</a>
        <a href="./employeeenroll.php">Enroll Students</a>
        <a href="./employeesection.php">Sections</a>
        <a href="./employeeaddschedule.php">Class Schedules</a>
        <a href="./employeeforms.php">Forms</a>
        <a href="./employeerecords.php">Records</a>


        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <h1>Edit Profile</h1>
        <?php
        if (isset($_GET['lrn'])) {
            foreach ($finduser as $founduser) {

                if ($founduser['idnumber'] == $_GET['lrn']) {

                    $_SESSION['edittinglrn'] = $_GET['lrn'];

                    ?>

                    <form action='accountedit.php?lrn=<?php echo $_SESSION['edittinglrn'] ?>' method="POST">
                        <div class="edithere">
                            <div class="accountdetailsedit">

                                <div class="row">

                                    <div class="col-md-6">
                                        <h2>Information</h2>
                                        <label for="">Name</label><br>
                                        <input type="text" id="" name="name" value='<?php echo $founduser['name'] ?>'><br>
                                        <label for="">Address</label><br>
                                        <input type="text" id="" name="address" value='<?php echo $founduser['Address'] ?>'><br>
                                        <label for="">Email</label><br>
                                        <input type="email" id="" name="email" value='<?php echo $founduser['email'] ?>'><br>
                                        <label for="">Age</label><br>
                                        <input type="text" id="" name="age" value='<?php echo $founduser['age'] ?>'><br>
                                        <label for="">Sex</label><br>
                                        <select name="sex">
                                            <option value="Male" <?php if ($founduser['sex'] == 'Male')
                                                echo "selected"; ?>>Male
                                            </option>
                                            <option value="Female" <?php if ($founduser['sex'] == 'Female')
                                                echo "selected"; ?>>Female
                                            </option>
                                        </select>
                                        <label for="">Grade Level</label><br>

                                        <?php
                                        echo "<select name='gradelevel'>";
                                        foreach ($gradelevelselection as $gradelevel) {
                                            echo "<option value='" . $gradelevel . "'";
                                            if ($founduser['gradelevel'] == $gradelevel) {
                                                echo "selected";
                                            }
                                            echo ">" . $gradelevel . "</option>";
                                        }
                                        echo "</select>";
                                        ?>

                                        <label for="">LRN</label><br>
                                        <input type="text" id="" name="lrn" value='<?php echo $founduser['idnumber'] ?>'><br>
                                        <label for="">Password</label><br>
                                        <input type="text" id="" name="password" value='<?php echo $founduser['password'] ?>'><br>

                                    </div>
                                    <div class="col-md-6">
                                        <h2>Emergency Contact</h2>
                                        <label for="">Guardian's Name</label><br>
                                        <input type="text" id="" name="guardianname"
                                            value='<?php echo $founduser['guardianname'] ?>'><br>
                                        <label for="">Email</label><br>
                                        <input type="text" id="" name="guardianemail"
                                            value='<?php echo $founduser['guardianemail'] ?>'><br>
                                        <label for="">Contact Number</label><br>
                                        <input type="text" id="" name="Telephone/Cellphone"
                                            value='<?php echo $founduser['Telephone/Cellphone'] ?>'><br>
                                        <label for="">Occupation</label><br>
                                        <input type="text" id="" name="occupation"
                                            value='<?php echo $founduser['occupation'] ?>'><br>
                                        <label for="">Relationship</label><br>
                                        <input type="text" id="" name="relationship"
                                            value='<?php echo $founduser['relationship'] ?>'><br>
                                        <br>
                                        <br>
                                        <input type="checkbox" name="4PS" value="" <?php echo $founduser['4PS'] ?>>
                                        <label for=""> 4P's</label><br>
                                        <input type="checkbox" name="IPS" value="" <?php echo $founduser['IPS'] ?>>
                                        <label for=""> IP's</label><br>
                                        <input type="checkbox" id="" name="" value="" <?php echo $founduser['MTCC'] ?>>
                                        <label for=""> ??</label><br><br>
                                    </div>

                                </div>


                            </div>

                            <div class="row">

                                <div class="col">
                                    <input type="submit" name="save" value="Save">
                                </div>
                                <div class="col">
                                    <input type="submit" name="delete" value="Delete Account">
                                </div>
                            </div>
                        </div>
                    </form>

                <?php }
            }
        } else {
            foreach ($finduser2 as $founduser) {

                if ($founduser['enumber'] == $_GET['enumber']) {

                    $_SESSION['edittingenumber'] = $_GET['enumber'];

                    ?>


                    <form action='accountedit.php?enumber=<?php echo $_SESSION['edittingenumber'] ?>' method="POST">
                        <div class="edithere">
                            <div class="accountdetailsedit">

                                <div class="row">
                                    <div class="col-md-6">
                                        <h2>Information</h2>


                                        <label for="">Name</label><br>
                                        <input type="text" id="" name="name" value='<?php echo $founduser['name'] ?>'><br>
                                        <label for="">Address</label><br>
                                        <input type="text" id="" name="address" value='<?php echo $founduser['Address'] ?>'><br>
                                        <label for="">Email</label><br>
                                        <input type="email" id="" name="email" value='<?php echo $founduser['email'] ?>'><br>
                                        <label for="">Age</label><br>
                                        <input type="text" id="" name="age" value='<?php echo $founduser['age'] ?>'><br>
                                        <label for="">Sex</label><br>
                                        <select name="sex">
                                            <option value="Male" <?php if ($founduser['sex'] == 'Male')
                                                echo "selected"; ?>>Male
                                            </option>
                                            <option value="Female" <?php if ($founduser['sex'] == 'Female')
                                                echo "selected"; ?>>Female
                                            </option>
                                        </select>

                                        <label for="">Password</label><br>
                                        <input type="text" id="" name="password" value='<?php echo $founduser['password'] ?>'><br>
                                        <label for="">Department</label><br>

                                        <?php
                                        echo "<select name='department'";
                                        if ($founduser['position'] == "admin") {
                                            echo "disabled='true'";
                                        }
                                        echo ">";


                                        ;
                                        foreach ($departmentselection as $department) {
                                            echo "<option value='" . $department . "'";

                                            if ($founduser['department'] == $department) {
                                                echo "selected";
                                            }

                                            echo ">" . $department . "</option>";
                                        }

                                        if ($founduser['position'] == "admin") {
                                            echo "<option value='ITRO'";
                                            if ($founduser['department'] == "ITRO") {
                                                echo "selected";
                                            }
                                            echo ">ITRO</option>";
                                        }

                                        echo "</select>";
                                        ?>

                                        <label for="">Employee Number</label><br>
                                        <input type="text" id="" name="enumber" value='<?php echo $founduser['enumber'] ?>'><br>

                                        <label for="">Position</label><br>
                                        <input type="text" id="" name="position" value=<?php echo "'" . $founduser['position'] . "'";
                                        if ($founduser['position'] == "admin") {
                                            echo "readonly";
                                        } ?>><br>

                                    </div>
                                    <div class="col-md-6">

                                        <h2>Emergency Contact</h2>
                                        <label for="">Guardian' s Name</label><br>
                                        <input type="text" id="" name="guardianname"
                                            value='<?php echo $founduser['guardianname'] ?>'><br>
                                        <label for="">Email</label><br>
                                        <input type="text" id="" name="guardianemail"
                                            value='<?php echo $founduser['guardianemail'] ?>'><br>
                                        <label for="">Contact Number</label><br>
                                        <input type="text" id="" name="Telephone/Cellphone"
                                            value='<?php echo $founduser['Telephone/Cellphone'] ?>'><br>
                                        <label for="">Occupation</label><br>
                                        <input type="text" id="" name="occupation"
                                            value='<?php echo $founduser['occupation'] ?>'><br>
                                        <label for="">Relationship</label><br>
                                        <input type="text" id="" name="relationship"
                                            value='<?php echo $founduser['relationship'] ?>'><br>


                                    </div>
                                </div>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <input type="submit" name="save2" value="Save">
                            </div>
                            <div class="col">
                                <input type="submit" name="delete" value="Delete Account">
                            </div>
                        </div>
                    </form>

                    <?php
                }
            }
        } ?>
    </div>



    <?php

    if (isset($_POST['cancel'])) {
        echo "<script> window.location.href='employeeaccount.php';</script>";
    }



    if (isset($_POST['save'])) {

        if (isset($_POST['4PS'])) {
            $fourPs = "checked";
        } else {
            $fourPs = "none";
        }

        if (isset($_POST['IPS'])) {
            $IPs = "checked";
        } else {
            $IPs = "none";
        }

        if (isset($_POST['MTCC'])) {
            $MTCC = "checked";
        } else {
            $MTCC = "none";
        }



        $updatethis = $col->updateOne(

            ['idnumber' => $_GET['lrn']],
            [
                '$set' => [

                    "name" => $_POST['name'],
                    'Address' => $_POST['address'],
                    'email' => $_POST['email'],
                    'age' => $_POST['age'],
                    'sex' => $_POST['sex'],
                    'gradelevel' => $_POST['gradelevel'],
                    'idnumber' => $_POST['lrn'],
                    'guardianname' => $_POST['guardianname'],
                    'Telephone/Cellphone' => $_POST['Telephone/Cellphone'],
                    'occupation' => $_POST['occupation'],
                    'relationship' => $_POST['relationship'],
                    'password' => $_POST['password'],
                    '4PS' => $fourPs,
                    'IPS' => $IPs,
                    'MTCC' => $MTCC,


                ]
            ]

        );

        echo "<script>alert('success')</script>";
        echo "<script> window.location.href='employeeaccount.php';</script>";

    }

    if (isset($_POST['save2'])) {





        $updatethis = $col->updateOne(

            ['idnumber' => $_GET['enumber']],
            [
                '$set' => [

                    "name" => $_POST['name'],
                    'Address' => $_POST['address'],
                    'email' => $_POST['email'],
                    'age' => $_POST['age'],
                    'sex' => $_POST['sex'],
                    'password' => $_POST['password'],
                    'department' => $_POST['department'],
                    'enumber' => $_POST['enumber'],
                    'position' => $_POST['position'],
                    'guardianname' => $_POST['guardianname'],
                    'guardianemail' => $_POST['guardianemail'],
                    'Telephone/Cellphone' => $_POST['Telephone/Cellphone'],
                    'occupation' => $_POST['occupation'],
                    'relationship' => $_POST['relationship'],


                ]
            ]

        );

        echo "<script>alert('success')</script>";
        echo "<script> window.location.href='employeeaccount.php';</script>";

    }

    ?>


</body>


</html>
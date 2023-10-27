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

$gradelevelselection = array('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12');
$departmentselection = array('Sta Juliana HS', 'Sta Juliana SHS');

$bucket = $db->selectGridFSBucket();



?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css">
    <link rel="stylesheet" href="./css/accountedit.css?<?php echo time() ?>">
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
        <a href="./employeeaccount.php" class="active">Accounts</a>
        <a href="./employeeenroll.php">Enroll Students</a>
        <a href="./employeerecords.php">Records</a>
        <a href="">Forms</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>


    <form method="post">
        <select name="roleselection" id="roleselection" onchange="this.form.submit()">
            <option value="student" <?php if (isset($_POST['roleselection'])) if ($_POST['roleselection'] == "student") { ?> selected <?php } ?>>Student</option>
            <option value="teacher" <?php if (isset($_POST['roleselection'])) if ($_POST['roleselection'] == "teacher") { ?> selected <?php } ?>>Teacher</option>

        </select>
    </form>

    <div class="main">

        <h1>Edit Profile</h1>

        <div>

            <?php if (isset($_POST['roleselection']) && $_POST['roleselection'] == "teacher") { ?>
                <form action='addaccount.php' method="POST" enctype="multipart/form-data">

                    <div class="edithere">
                        <div class="accountdetailsedit">

                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Information</h2>


                                    <label for="">Name</label><br>
                                    <input type="text" id="" name="name"><br>
                                    <label for="">Address</label><br>
                                    <input type="text" id="" name="address"><br>
                                    <label for="">Email</label><br>
                                    <input type="email" id="" name="email"><br>
                                    <label for="">Age</label><br>
                                    <input type="text" id="" name="age"><br>
                                    <label for="">Sex</label><br>
                                    <select name="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>


                                    <label for="">Password</label><br>
                                    <input type="password" id="" name="password"><br>
                                    <label for="">Department</label><br>

                                    <?php
                                    echo "<select name='department'>";
                                    foreach ($departmentselection as $department) {
                                        echo "<option value='" . $department . "'";
                                        echo ">" . $department . "</option>";
                                    }
                                    echo "</select>";
                                    ?>

                                    <label for="">Employee Number</label><br>
                                    <input type="text" id="" name="enumber"><br>

                                    <label for="">Position</label><br>
                                    <input type="text" id="" name="position"><br>

                                </div>
                                <div class="col-md-6">

                                    <h2>Emergency Contact</h2>
                                    <label for="">Guardian's Name</label><br>
                                    <input type="text" id="" name="guardianname"><br>
                                    <label for="">Email</label><br>
                                    <input type="text" id="" name="guardianemail"><br>
                                    <label for="">Contact Number</label><br>
                                    <input type="text" id="" name="Telephone/Cellphone"><br>
                                    <label for="">Occupation</label><br>
                                    <input type="text" id="" name="occupation"><br>
                                    <label for="">Relationship</label><br>
                                    <input type="text" id="" name="relationship"><br>


                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <input type="submit" name="cancel" value="Cancel">
                        </div>
                        <div class="col">
                            <input type="submit" name="enroll2" value="Enroll">
                        </div>
                    </div>
                </form>


            <?php } else { ?>
                <form action='addaccount.php' method="POST" enctype="multipart/form-data">

                    <div class="edithere">
                        <div class="accountdetailsedit">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>Information</h2>

                                    <select name="studenttype">
                                        <option value="New Student">New Student</option>
                                        <option value="Old Student">Old Student</option>
                                    </select>


                                    <label for="">Name</label><br>
                                    <input type="text" id="" name="name"><br>
                                    <label for="">Address</label><br>
                                    <input type="text" id="" name="address"><br>
                                    <label for="">Email</label><br>
                                    <input type="email" id="" name="email"><br>
                                    <label for="">Age</label><br>
                                    <input type="text" id="" name="age"><br>
                                    <label for="">Sex</label><br>
                                    <select name="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <label for="">Grade Level</label><br>

                                    <?php
                                    echo "<select name='gradelevel'>";
                                    foreach ($gradelevelselection as $gradelevel) {
                                        echo "<option value='" . $gradelevel . "'";
                                        echo ">" . $gradelevel . "</option>";
                                    }
                                    echo "</select>";
                                    ?>

                                    <label for="">LRN</label><br>
                                    <input type="text" id="" name="lrn"><br>
                                    <label for="">Password</label><br>
                                    <input type="password" id="" name="password"><br>

                                </div>
                                <div class="col-md-6">

                                    <h2>Emergency Contact</h2>
                                    <label for="">Guardian's Name</label><br>
                                    <input type="text" id="" name="guardianname"><br>
                                    <label for="">Email</label><br>
                                    <input type="text" id="" name="guardianemail"><br>
                                    <label for="">Contact Number</label><br>
                                    <input type="text" id="" name="Telephone/Cellphone"><br>
                                    <label for="">Occupation</label><br>
                                    <input type="text" id="" name="occupation"><br>
                                    <label for="">Relationship</label><br>
                                    <input type="text" id="" name="relationship"><br>
                                    <br>
                                    <br>
                                    <input type="checkbox" name="4PS" value="">
                                    <label for=""> 4P's</label><br>
                                    <input type="checkbox" name="IPS" value="">
                                    <label for=""> IP's</label><br>
                                    <input type="checkbox" id="" name="MTCC" value="">
                                    <label for=""> MTCC</label><br><br>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="">Attach Good Moral</label>
                                        <input type="file" class="form-control" id="goodmoral" name="goodmoral" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="">Attach Form 138</label>
                                        <input type="file" class="form-control" id="form138" name="form138" required>
                                    </div>

                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="">Birth Certificate</label>
                                        <input type="file" class="form-control" id="bCertificate" name="bcertificate"
                                            required>
                                    </div>



                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="row">

                        <div class="col">
                            <input type="submit" name="cancel" value="Cancel">
                        </div>
                        <div class="col">
                            <input type="submit" name="enroll" value="Enroll">
                        </div>
                    </div>
                </form>


            <?php } ?>
        </div>



        <?php





        if (isset($_POST['enroll'])) {

            $goodmoralname = $_POST['lrn'] . "-goodmoral-" . time();
            $extension = pathinfo($_FILES["goodmoral"]["name"], PATHINFO_EXTENSION);
            $goodmoralnewname = $goodmoralname . "." . $extension;

            $form138name = $_POST['lrn'] . "-form138-" . time();
            $extension = pathinfo($_FILES["form138"]["name"], PATHINFO_EXTENSION);
            $form138newname = $form138name . "." . $extension;

            $bcertificatename = $_POST['lrn'] . "-birthcertificate-" . time();
            $extension = pathinfo($_FILES["bcertificate"]["name"], PATHINFO_EXTENSION);
            $bcertificatenewname = $bcertificatename . "." . $extension;

            $source1 = $_FILES["goodmoral"]["tmp_name"];
            $source2 = $_FILES["form138"]["tmp_name"];
            $source3 = $_FILES["bcertificate"]["tmp_name"];
            $targetDir1 = "../fileupload/{$goodmoralnewname}";
            $targetDir2 = "../fileupload/{$form138newname}";
            $targetDir3 = "../fileupload/{$bcertificatenewname}";

            move_uploaded_file($source1, $targetDir1);
            move_uploaded_file($source2, $targetDir2);
            move_uploaded_file($source3, $targetDir3);

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

            $document = array(

                'studenttype' => $_POST['studenttype'],
                "name" => $_POST['name'],
                'Address' => $_POST['address'],
                'email' => $_POST['email'],
                'age' => $_POST['age'],
                'sex' => $_POST['sex'],
                'gradelevel' => $_POST['gradelevel'],
                'idnumber' => $_POST['lrn'],
                'guardianname' => $_POST['guardianname'],
                'guardianemail' => $_POST['guardianemail'],
                'Telephone/Cellphone' => $_POST['Telephone/Cellphone'],
                'occupation' => $_POST['occupation'],
                'relationship' => $_POST['relationship'],
                'goodmoral' => $goodmoralnewname,
                'form138' => $form138newname,
                'bcertificate' => $bcertificatenewname,
                '4PS' => $fourPs,
                'IPS' => $IPs,
                'MTCC' => $MTCC,
                'role' => "student",
                'status' => 'Enrolled',
                'password' => $_POST['password']
            );

            $col->insertOne($document);


            $goodmoralholder = $bucket->openUploadStream($goodmoralnewname);
            $goodmoralcontents = file_get_contents($targetDir1);
            fwrite($goodmoralholder, $goodmoralcontents);
            fclose($goodmoralholder);


            $form138holder = $bucket->openUploadStream($form138newname);
            $form138contents = file_get_contents($targetDir2);
            fwrite($form138holder, $form138contents);
            fclose($form138holder);


            $bcertificateholder = $bucket->openUploadStream($bcertificatenewname);
            $bcertificatecontents = file_get_contents($targetDir3);
            fwrite($bcertificateholder, $bcertificatecontents);
            fclose($bcertificateholder);



            echo "<script>alert('success')</script>";
            echo "<script> window.location.href='employeeaccount.php';</script>";

        }

        if (isset($_POST['enroll2'])) {

            $document = array(
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
                'role' => "teacher",
                'status' => "Employed"
            );

            $col2->insertOne($document);

            echo "<script>alert('success')</script>";
            echo "<script> window.location.href='employeeaccount.php';</script>";

        }



        ?>


</body>


</html>
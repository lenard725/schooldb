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
$col = $db->Enrollcol;
//echo "Collection StudentAccount Selected";

$studentcol = $db->StudentAccount;

$bucket = $db->selectGridFSBucket();

$finduser = $studentcol->find(array('email' => $_SESSION["thissessionemail"]));

$gradelevelselection = array('Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11', 'Grade 12', );

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/sidenav.css">
    <link rel="stylesheet" href="./css/classenrollment.css?<?php echo time(); ?>">
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
        <a href="./classenrollment.php" class="active">Class Enrollment</a>
        <a href="./scheduleviewer.php">Schedule Viewer</a>
        <a href="./clearance.php">Clearance Information</a>
        <a href="./grades.php">Grades</a>

        <form action="studentprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>



    <div class="main">
        <div class="col">

            <?php foreach ($finduser as $founduser) {
                if ($founduser['status'] == "not enrolled") {

                    ?>
                    <div class="theform">
                        <form action="classenrollment.php" method="POST" enctype="multipart/form-data">
                            <label for="name">Student Name</label><br>
                            <input type="text" id="" name="name" value='<?php echo $_SESSION["thissessionname"]; ?>'
                                readonly><br>

                            <label for="idnumber">ID Number</label><br>
                            <input type="text" id="" name="idnumber" value='<?php echo $_SESSION['thissessionidnumber']; ?>'
                                readonly><br>

                            <label for="">Grade Level</label><br>

                            <?php
                            echo "<select name='gradelevel'>";
                            foreach ($gradelevelselection as $gradelevel) {
                                echo "<option value='" . $gradelevel . "'";
                                echo ">" . $gradelevel . "</option>";
                            }
                            echo "</select>";
                            ?>



                            <div class="input-group mb-3">
                                <label class="input-group-text" for="">Attach Form 138</label>
                                <input type="file" class="form-control" id="form138" name="form138">
                            </div>

                            <input type="submit" id="btnenroll" name="enroll" value="Enroll">
                    </div>


                    </form>

                </div>
            <?php } else { ?>
                <div class="onProcess">
                    <p>Thank you for enrolling at our school,<br><br>

                        your enrollment is currently being reviewed and we will confirm it as soon as possible<br><br>

                        Thank you for your patience.</p>
                </div>
            <?php }
            } ?>
    </div>
    </div>

    <?php
    if (isset($_POST['enroll'])) {


        $form138name = $_POST['idnumber'] . "form138-" . time();
        $extension = pathinfo($_FILES["form138"]["name"], PATHINFO_EXTENSION);
        $newname = $form138name . "." . $extension;

        $source = $_FILES["form138"]["tmp_name"];
        $targetDir = "./fileupload/{$newname}";

        move_uploaded_file($source, $targetDir);




        $document = array(
            "name" => $_SESSION["thissessionname"],
            "idnumber" => $_SESSION["thissessionidnumber"],
            "gradelevel" => $_POST['gradelevel'],
            "form138" => $newname
        );

         $col->insertOne($document);
    

        $form138holder = $bucket->openUploadStream($newname);
        $form138contents = file_get_contents($targetDir);
        fwrite($form138holder, $form138contents);
        fclose($form138holder);
    }


    ?>


</body>

</html>
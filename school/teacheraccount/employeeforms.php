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
$col = $db->FormCollection;
//echo "Collection FormsDB Selected";

$findforms = $col->find();
$bucket = $db->selectGridFSBucket();

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css?<?php echo time() ?>"
        rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/employeeform.css?<?php echo time(); ?>">
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
        <a href="./employeeaddschedule.php">Class Schedules</a>
        <a href="./employeeforms.php" class="active">Forms</a>
        <a href="./employeerecords.php">Records</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">
        <?php

        foreach ($findforms as $foundforms) {
            echo "

        <div class='fulllist'>
            <div class='row row-cols-5'>
                <div class='col'>
                    <div class='fillerdiv'>
                    <a href='teacherform.php?recordsearch=" . $foundforms['fillerform'] . " '><h2>Filler Form Download</h2></a> 
                    </div>
                </div>
                <div class='col'>
                    <div class='servicerecordform'>
                    <a href='teacherform.php?recordsearch=" . $foundforms['servicerecordform'] . " '><h2>Service Record Form Download</h2></a>
                    </div>
                </div>
                <div class='col'>
                    <div class='travelform'>
                    <a href='teacherform.php?recordsearch=" . $foundforms['travelform'] . " '><h2>Authority To Travel Form Download</h2></a> 
                    </div>
                </div>
            </div>

            <div class='row row-cols-5'>
                <div class='col'>
                    <div class='enrollsurveyform'>
                        <a href='teacherform.php?recordsearch=" . $foundforms['learnerenrollmentsurveyform'] . " '>
                            <h2>Learner Enrollment And Survey Form Download</h2>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>";

        } ?>


</body>

<?php

if (isset($_GET['recordsearch'])) {

    if (!empty($_GET['recordsearch'])) {
        $stream = $bucket->openDownloadStreamByName($_GET['recordsearch'], ['revision' => 0]);
        $contents = stream_get_contents($stream);
        $pdf = fopen($_GET['recordsearch'], 'w');
        fwrite($pdf, $contents);
        fclose($pdf);

        $file = $_GET['recordsearch'];

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        header("Location: teacherform.php");
        exit;


    }

}



?>

</html>
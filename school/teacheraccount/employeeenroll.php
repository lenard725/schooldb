<?php

session_start();

require '../../vendor/autoload.php';

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

$sectioncol = $db->SectionDB;

$findsection = $sectioncol->find();

if (isset($_POST['sections']))
    $findteachersection = $sectioncol->find(array('sectionname' => $_POST['sections']));

$bucket = $db->selectGridFSBucket();

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
        header("Location: employeeenroll.php");
        exit;


    }

}




?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css?<?php echo time() ?>">
    <link rel="stylesheet" href="./css/employeeenroll.css">
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
        <a href="./employeeenroll.php" class="active">Enroll Students</a>
        <a href="./employeesection.php">Sections</a>
        <a href="./employeeaddschedule.php">Class Schedules</a>
        <a href="./employeeforms.php">Forms</a>
        <a href="./employeerecords.php">Records</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <div class="mainselect">
            <select name="" id="section">
                <option value="">Section 1</option>
                <option value="">Section 1</option>

            </select>
        </div>

        <div class="accountssheet">

            <form action="employeeenroll.php" method="POST">
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th scope="col">Students Name</th>
                                <th scope="col">Grade Level</th>
                                <th scope="col">Section</th>
                                <th scope="col">Form 138</th>
                            </tr>
                        </thead>
                        <!-- get expanded in php loop -->

                        <?php
                        $findenroll = $col->find();

                        foreach ($findenroll as $foundenrolllist) {
                            echo "<tbody>
                        <th><input type='checkbox' name='studentidnumber[]' value='" . $foundenrolllist['idnumber'] . "'></th>
                                <th scope='row'>" . $foundenrolllist['name'] . "</th>
                                <td>" . $foundenrolllist['gradelevel'] . "</td>";


                            echo "</td>";
                            echo "<td>";

                            echo "<select name='getsections[]' id='section'>";

                            foreach ($findsection as $foundsection) {
                                if ($foundsection['gradelevel'] == $foundenrolllist['gradelevel']) {
                                    echo "<option value='" . $foundsection['sectionname'] . "'";
                                    echo ">" . $foundsection['sectionname'] . "</option>";
                                }
                            }
                            echo "</select>";

                            echo "</td>
                                <td><a href='employeeenroll.php?recordsearch=" . $foundenrolllist['form138'] . " '>view</a></td>";

                        }


                        ?>

                        </tbody>
                    </table>
                </div>
                <input type="submit" name="enroll" id="enrollbutton" value="Enroll">
            </form>
        </div>



    </div>
</body>

<?php

if (isset($_POST['enroll'])) {
    if (!empty($_POST['studentidnumber'])) {



        echo "<script>alert('success')</script>";
        foreach ($_POST['studentidnumber'] as $x => $listofidnumber) {

            $updateResult = $studentcol->updateOne(
                ['idnumber' => $listofidnumber],
                [
                    '$set' => [
                        'status' => 'Enrolled',
                        'section' => $_POST['getsections'][$x],

                    ]
                ]

            );

            $deletethis = $col->deleteOne(
                ['idnumber' => $listofidnumber]
            );

        }
    }
}
?>


</html>
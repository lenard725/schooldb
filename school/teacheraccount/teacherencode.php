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
$finduser = $col->find(array('email' => $_SESSION["thissessionemail"]));

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/teacherencode.css">
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

        <a href="./teacherprofile.html">Profile</a>
        <a href="./teacherclass.html">Class</a>
        <a href="./teacherschedule.html">Schedule Viewer</a>
        <a href="./teacherform.html">Forms</a>
        <a href="./teacherencode.html" class="active">Encode Grade</a>

        <form action="teacherprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <div class="mainselect">
            <select name="sections" id="section">
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>
                <option value="">Section 1</option>

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
                        <tr>
                            <th scope="row">1</th>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>
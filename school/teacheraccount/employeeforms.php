<?php

session_start();

require '../../vendor/autoload.php';

if (!$_SESSION["log2authentication"]) {
    header("Location: ../login2.php");
    exit();
}

$con = new MongoDB\Client("mongodb://localhost:27017");
//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->FormsDB;
//echo "Collection TeacherAccount Selected";


?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css">
    <link rel="stylesheet" href="./css/employeeforms.css">

    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }
            else {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "employeeforms.php?q=" + "teacher", true);
            xmlhttp.send();
        }

    </script>

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
        <a href="./employeeaccount.html">Accounts</a>
        <a href="./employeeenroll.html">Enroll Students</a>
        <a href="./employeerecords.html">Records</a>
        <a href="./employeeforms.php" class="active">Forms</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <div class="mainselect">
            <form method="post">
                <select name="role" id="role" onchange="this.form.submit()">
                    <option value="all">All </option>
                    <option value="teacher" <?php if (isset($_POST['role'])) if ($_POST['role'] == "teacher") { ?>
                                selected <?php } ?>>Teacher</option>
                    <option value="student" <?php if (isset($_POST['role'])) if ($_POST['role'] == "student") { ?>
                                selected <?php } ?>>Student
                    </option>

                </select>
            </form>
        </div>

        <?php

        $findform = $col->find();


        foreach ($findform as $foundform) {
            $storedrole = $foundform['role'];

            if (isset($_POST['role']) && $_POST['role'] != "all") {
                if ($storedrole == $_POST['role']) {
                    echo "<div class='requestbar'>
                    <p>[" . $foundform['name'] . "] " . $foundform['type'] . "</p> 
                    </div>";

                }
            } else {
                echo "<div class='requestbar'>
                    <p>[" . $foundform['name'] . "] " . $foundform['type'] . " - " . $foundform['role'] . "</p> 
                    </div>";
            }
        }
        ?>



        <!-- <div class="requestbar">
            <p>[Insert name] Requests for Form 137</p>
        </div> -->
    </div>
</body>

</html>
<?php

session_start();

require '../../vendor/autoload.php';

if (!$_SESSION["log2authentication"]) {
    header("Location: ../login2.php");
    exit();
}

$con = new MongoDB\Client("mongodb://localhost:27017/");
// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
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
    <link rel="stylesheet" href="./css/employeeforms.css?<?php echo time() ?>">

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
                <select name="type" id="role" onchange="this.form.submit()">
                    <option value="all">All </option>
                    <option value="Form 137" <?php if (isset($_POST['type'])) if ($_POST['type'] == "Form 137") { ?>
                                selected <?php } ?>>Form 137</option>
                    <option value="Good Moral" <?php if (isset($_POST['type'])) if ($_POST['type'] == "Good Moral") { ?>
                                selected <?php } ?>>Good Moral</option>

                </select>
            </form>
        </div>

        <?php

        $findform = $col->find();


        foreach ($findform as $foundform) {
            $storedrole = $foundform['type'];

            if (isset($_POST['type']) && $_POST['type'] != "all") {
                if ($storedrole == $_POST['type']) {

                    ?>
                    <form action="employeeforms.php" method="POST">
                        <?php


                        echo "<div class='requestbar'>
                        <p>[" . $foundform['name'] . "] " . $foundform['type'] . "</p>";

                        ?>
                        <input type="submit" id="approvebtn" name="approve" value="approve">
                        <input type="submit" id="declinebtn" name="decline" value="decline">
                        <?php
                        echo "</div>";
                        echo "</form>";



                }
            } else {
                echo "<form action='employeeforms.php?tempid={$foundform['name']}' method='POST'>";
                echo "<div class='requestbar'>
                    <p>[" . $foundform['name'] . "] " . $foundform['type'] . "</p>";

                //echo "<input type='hidden' name='tempid' value='" . $foundform['_id'] . "'>";

                ?>
                    <input type="submit" id="approvebtn" name="approve" value="approve">
                    <input type="submit" id="declinebtn" name="decline" value="decline">
                    <?php
                    echo "</div>";
                    echo "</form>";
            }
        }
        ?>



            <!-- <div class="requestbar">
            <p>[Insert name] Requests for Form 137</p>
        </div> -->
    </div>
</body>

<?php

if (isset($_POST['approve'])) {
    $col->deleteOne(
        ['name' => $_GET['tempid']]
    );
}

?>




</html>
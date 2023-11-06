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
  <link rel="stylesheet" href="./css/teachersidenav.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="./css/teacherprofile.css">
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

    <a href="./teacherprofile.php" class="active">Profile</a>
    <a href="./teacherclass.php">Class</a>
    <a href="./teacherschedule.php">Schedule Viewer</a>
    <a href="./teacherform.php">Forms</a>
    <a href="./teacherencode.php">Encode Grade</a>

    <form action="teacherprofile.php" method="post">
      <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
    </form>

  </div>


  <div class="main">
    <div class="mainleft">
      <h1 style="font-size: 50px; margin-left: 20px;">Teacher's Profile</h1>

      <div class="teacherinfo">

        <?php
        foreach ($finduser as $founduser) {

          if ($_SESSION["thissessionemail"] == $founduser['email']) {

            echo "<h1 id='teachername'>" . $founduser['name'] . "</h1>";
            echo "<p><b>Employee Number:</b> " . $founduser['enumber'] . "</p>";
            echo "<p>Email: " . $_SESSION["thissessionemail"] . "</p>";

            echo "<h2>Emergency Contact: </h2>";

            echo "<h3>" . $founduser['guardianname'] . "</h3>";
            echo "<p><b>Relationship:</b> " . $founduser['relationship'] . "</p>";
            echo "<p><b>Occupation:</b> " . $founduser['occupation'] . "</p>";
            echo "<p><b>Address:</b> " . $founduser['Address'] . "</p>";
            echo "<p><b>Telephone/Mobile Number:</b> " . $founduser['Telephone/Cellphone'] . "</p>";
            echo "<p><b>Email:</b> " . $founduser['guardianemail'] . "</p>";
          }

        }
        ?>


      </div>
    </div>



  </div>

  <?php
  if (isset($_POST['logout'])) {

    session_destroy();

    header("Location: ../login2.php");
    exit();
  }
  ?>

</body>


</html>
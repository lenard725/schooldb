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
$col = $db->AdminAccount;
//echo "Collection AdminAccount Selected";
$finduser = $col->find(array('email' => $_SESSION["thissessionemail"]));

?> <!-- initial code for current login info -->


<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TBD</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/sidenav.css?<?php echo time(); ?>">
  <link rel="stylesheet" href="./css/employeeprofile.css">
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

    <a href="./Employeeprofile.php" class="active">Profile</a>
    <a href="./employeeaccount.php">Accounts</a>
    <a href="./employeeenroll.php">Enroll Students</a>
    <a href="./employeerecords.php">Records</a>
    <a href="./employeeforms.php">Forms</a>

    <form action="Employeeprofile.php" method="post">
      <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
    </form>

  </div>


  <div class="main">
    <div class="mainleft">
      <h1 style="font-size: 50px; margin-left: 20px;">Admin's Profile</h1>

      <div class="admininfo">

        <?php
        foreach ($finduser as $founduser) {

          if ($_SESSION["thissessionemail"] == $founduser['email']) {

            echo "<h1 id='adminname'>" . $founduser['name'] . "</h1>";
            echo "<p>Grade Level: " . $founduser['gradelevel'] . "</p>";
            echo "<p>ID Number: " . $founduser['idnumber'] . "</p>";
            echo "<p>Section: " . $founduser['section'] . "</p>";
            echo "<p>Email: " . $_SESSION["thissessionemail"] . "</p>";

            echo "<h2>Emergency Contact: </h2>";

            echo "<h3>" . $founduser['guardianname'] . "</h3>";
            echo "<p>Relationship: " . $founduser['relationship'] . "</p>";
            echo "<p>Occupation: " . $founduser['occupation'] . "</p>";
            echo "<p>Address: " . $founduser['Address'] . "</p>";
            echo "<p>Telephone/Mobile Number: " . $founduser['Telephone/Cellphone'] . "</p>";
            echo "<p>Email: " . $founduser['guardianemail'] . "</p>";
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
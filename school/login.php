<?php
session_start();
global $con;

include_once '../vendor/sonata-project/google-authenticator/src/FixedBitNotation.php';
include_once '../vendor/sonata-project/google-authenticator/src/GoogleAuthenticatorInterface.php';
include_once '../vendor/sonata-project/google-authenticator/src/GoogleAuthenticator.php';
include_once '../vendor/sonata-project/google-authenticator/src/GoogleQrUrl.php';

require '../vendor/autoload.php';

if (isset($_SESSION["log1authentication"])) {
    header("Location: studentprofile.php");
    exit();
}

if (isset($_SESSION['loginerror'])) {

    echo "<script>alert('Invalid Credential')</script>";
    session_destroy();
    // header("Location: login.php");
}


if (isset($_POST['submit'])) {
    // $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
    $con = new MongoDB\Client("mongodb://localhost:27017/");
    //echo "Connection to database successfully";
    $db = $con->SchoolDB;
    //echo "Database SchoolDB selected";
    $col = $db->StudentAccount;
    //echo "Collection StudentAccount Selected";

    $postedemail = $_POST['email'];
    $postedpassword = $_POST['password'];
    $finduser = $col->find(array('email' => $postedemail));

    foreach ($finduser as $founduser) {
        $storedemail = $founduser['email'];
        $storedpassword = $founduser['password'];

        if ($postedemail == $storedemail && $postedpassword == $storedpassword) {


            $_SESSION["thissessionname"] = $founduser['name'];
            $_SESSION["thissessionidnumber"] = $founduser['idnumber'];
            $_SESSION["thissessiongradelevel"] = $founduser['gradelevel'];
            $_SESSION["thissessionsection"] = $founduser['section'];
            $_SESSION["thissessionemail"] = $postedemail;
            $_SESSION["log1authentication"] = 1;

            $g = new \Google\Authenticator\GoogleAuthenticator();
            $secret = $g->generateSecret();

            echo '<img src="' . $g->getURL($_POST['email'], 'localhost', $secret) . '" />';

            header("Location: studentprofile.php");
            exit();
        }

    }
    $_SESSION['loginerror'] = 1;
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link rel="stylesheet" href="./css/login.css">
</head>



<body>

    <div class="bg">
        <div class="formdiv">


            <h1>Student Login</h1>
            <h3>Login to your student portal</h3>

            <div class="sample">


                <form action="login.php" method="POST">


                    <label for="email">Email</label><br>
                    <input type="email" id="email" name="email" placeholder="Enter your Email"><br>

                    <label for="password">Password</label><br>
                    <input type="password" id="password" name="password" placeholder="Enter Password"><br>



                    <input type="submit" name="submit" value="Login">
                </form>
            </div>

        </div>
    </div>





</body>




</html>
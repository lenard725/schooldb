<?php
session_start();

function debug_to_console($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link rel="stylesheet" href="./css/login2.css">
</head>

<body>

    <div>

        <div class="bg">


        </div>

        <div class="loginform">


            <img src="./img/logo.jpg" id="logo" alt="Logo" height="100px" width="100px">


            <div class="formdiv">


                <h1>Welcome Back!</h1>
                <h3>Enter your login details to proceed</h3>

                <div class="sample">
                    <form action="login2.php" method="POST">

                        <label for="accounttype">I am a:</label><br>
                        <select name="accounttype" id="accounttype">
                            <option value="teacher">Teacher</option>
                            <option value="Admin">Admin</option>
                        </select><br>

                        <label for="email">Email</label><br>
                        <input type="email" id="email" name="email" placeholder="Enter your Email"><br>

                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password" placeholder="Enter Password"><br>



                        <input type="submit" name="submit" value="Login">
                    </form>
                </div>

            </div>


        </div>

        <?php

        require '../vendor/autoload.php';

        if (isset($_SESSION["log2authentication"])) {
            if ($_SESSION["sessionaccounttype"] == "teacher") {
                header("Location: teacheraccount/teacherprofile.php");
                exit();
            } else {
                header("Location: teacheraccount/employeeprofile.php");
                exit();
            }
        }


        if (isset($_POST['submit'])) {
            $con = new MongoDB\Client("mongodb://localhost:27017");
            echo "Connection to database successfully";
            $db = $con->SchoolDB;
            echo "Database SchoolDB selected";

            if ($_POST['accounttype'] == "teacher") {
                $col = $db->TeacherAccount;
                echo "teacher account Selected";
            } else {
                $col = $db->AdminAccount;
            }

            $postedemail = $_POST['email'];
            $postedpassword = $_POST['password'];
            $finduser = $col->find(array('email' => $postedemail));



            foreach ($finduser as $founduser) {
                $storedemail = $founduser['email'];
                $storedpassword = $founduser['password'];

                if ($postedemail == $storedemail && $postedpassword == $storedpassword) {

                    $_SESSION["thissessionemail"] = $postedemail;
                    $_SESSION["sessionaccounttype"] = $_POST['accounttype'];
                    $_SESSION["log2authentication"] = 1;

                    if ($_POST['accounttype'] == "teacher") {
                        header("Location: teacheraccount/teacherprofile.php");
                        exit();
                    } else {
                        header("Location: teacheraccount/employeeprofile.php");
                        exit();
                    }


                } else {
                    echo "xdd";
                }

            }

        }
        ?>



</body>

</html>
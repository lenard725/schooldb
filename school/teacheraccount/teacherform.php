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
$col = $db->FormsDB;
//echo "Collection FormsDB Selected";

?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/teachersidenav.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="./css/teacherform.css">
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

        <a href="./teacherprofile.php">Profile</a>
        <a href="./teacherclass.html">Class</a>
        <a href="./teacherschedule.html">Schedule Viewer</a>
        <a href="./teacherform.php" class="active">Forms</a>
        <a href="./teacherencode.html">Encode Grade</a>

        <form action="teacherprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>


    </div>

    <div class="main">
        <form action="teacherform.php" method="post">
            <div class="col">
                <select name="formtype" id="section">
                    <option value="Leave Form">Leave Form</option>
                    <option value="">X</option>
                    <option value="">X</option>
                    <option value="">X</option>
                    <option value="">X</option>



                </select>
            </div>

            <div class="forms">
                <div class="col">

                    <div class="row">
                        <label for="Name">Name</label><br>
                        <input type="text" id="name" name="name" placeholder="Enter Your Name"><br>
                    </div>

                    <div class="row">
                        <label for="">Reason</label><br>
                        <input type="text" id="reason" name="reason" placeholder=""><br>
                    </div>

                    <div class="row row-cols-2">

                        <div class="col">
                            <label for="">Date Start</label><br>
                            <input type="date" id="datestart" name="datestart" placeholder=""><br>
                        </div>

                        <div class="col">
                            <label for="">Date Ends</label><br>
                            <input type="date" id="dateend" name="dateend" placeholder=""><br>
                        </div>

                    </div>
                    <input type="submit" name="submit" value="REQUEST">


                </div>

            </div>
        </form>


    </div>

    <?php

    if (isset($_POST['submit'])) {
        $document = array(
            "type" => $_POST['formtype'],
            "name" => $_POST['name'],
            "reason" => $_POST['reason'],
            "datestart" => $_POST['datestart'],
            "dateend" => $_POST['dateend'],
            "role" => $_SESSION["sessionaccounttype"]
        );

        $col->insertOne($document);
    }



    ?>

</body>

</html>
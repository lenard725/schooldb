<?php

session_start();

require './../vendor/autoload.php';

$con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
// $con = new MongoDB\Client("mongodb://localhost:27017/");
//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->FormsDB;
//echo "Collection FormsDB Selected";

?> <!-- initial code for current login info -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/forms.css">

    <link rel="stylesheet" href="./css/footerhere.css">
</head>


<body>
    <header>
        <div class="logo">
            <a href="../index.html"><img src="./img/a/school logo png.png" alt="Logo" height="86px" width="86px"></a>
        </div>
        <div class="MainNav">
            <ul class="Nav">
                <li style="background-color: yellow;"><a href="./login2.php">Login</a></li>
                <li><a href="./contacts.php">Contact us</a></li>
                <li><a href="./forms.php">Form Request</a></li>
                <li><a href="./offices.html">Offices</a></li>
                <li><a href="./about.html">About</a></li>
                <li><a href="./home.html">Home</a></li>
            </ul>
        </div>
    </header>

    <div>
        <div class="title">
            <p class="text">Form Request </p>

        </div>

        <div class="formdiv">

            <h2>Request for Form137</h2>
            <form action="forms.php" method="POST">
                <label for="Name">LRN</label><br>
                <input type="text" id="Name" name="lrn" placeholder="Enter Your LRN"><br>
                <label for="Name">Name</label><br>
                <input type="text" id="Name" name="name" placeholder="Enter Your Name"><br>

                <label for="address">Adresss</label><br>
                <input type="text" id="address" name="address" placeholder="Enter Address"><br>

                <input type="submit" name="submit" value="Submit">
            </form>
        </div>

        <div class="formdiv">
            <h2>Request for Good Moral</h2>
            <form action="forms.php" method="POST">
                <label for="Name">LRN</label><br>
                <input type="text" id="Name" name="lrn" placeholder="Enter Your LRN"><br>
                <label for="Name">Name</label><br>
                <input type="text" id="Name" name="name" placeholder="Enter Your Name"><br>

                <label for="address">Adresss</label><br>
                <input type="text" id="address" name="address" placeholder="Enter Address"><br>



                <input type="submit" name="submit2" value="Submit">
            </form>
        </div>
    </div>


    <!-- BEYOND HERE IS FOOTER -->

    <footer>

        <div class="schoolNameLogo">
            <div class="schoolLogo">
                <img src="./img/logo2.png" alt="Logo" height="100px" width="100px">
            </div>
            <div class="schoolName">
                <h1>Sta. Juliana High School</h1>
                <p>Sta. Juliana, Capas, Tarlac</p>
            </div>

        </div>

        <div class="contactList">
            <ul style="list-style-type:none;">
                <li>
                    <img src="./img/fblogo.png" alt="Logo" height="30px" width="30px">
                    <p>Sta. Juliana High School</p>
                </li>
                <li>
                    <img src="./img/maillogo.png" alt="Logo" height="30px" width="30px">
                    <p>sta.juliana@school.edu</p>
                </li>
                <li>
                    <img src="./img/phonelogo.png" alt="Logo" height="30px" width="30px">
                    <p>09612844757</p>
                </li>
            </ul>

        </div>

        <div class="footercopyright">
            <h4>Copyright © 2023 Sta. Juliana High School. All rights reserved.</h4>
        </div>


    </footer>
</body>


<?php

if (isset($_POST['submit'])) {
    $document = array(
        'uniquedescription' => "Form137-" . $_POST['lrn'] . "-" . date("Y/m/d") . "-" . time(),
        "type" => "Form 137",
        "lrn" => $_POST['lrn'],
        "name" => $_POST['name'],
        "address" => $_POST['address'],
    );
    $col->insertOne($document);

    echo "<script>alert('success')</script>";
}

if (isset($_POST['submit2'])) {
    $document = array(
        'uniquedescription' => "GoodMoral-" . $_POST['lrn'] . "-" . date("Y/m/d") . "-" . time(),
        "type" => "Good Moral",
        "lrn" => $_POST['lrn'],
        "name" => $_POST['name'],
        "address" => $_POST['address'],
    );
    $col->insertOne($document);

    echo "<script>alert('success')</script>";
}


?>



</html>
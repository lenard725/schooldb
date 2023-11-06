<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/contacts.css">

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
                <li><a href="./contacts.html">Contact us</a></li>
                <li><a href="./forms.php">Form Request</a></li>
                <li><a href="./offices.html">Offices</a></li>
                <li><a href="./about.html">About</a></li>
                <li><a href="./home.html">Home</a></li>
            </ul>
        </div>
    </header>


    <div class="contacts">
        <br>

        <h1>Contact</h1>
        <p>Send an Email</p>


        <div>
            <h2>Directory</h2>

            <p>
                Our mail address and general contact information is: <br><br>
                <b>Sta Juliana High School</b> <br>
                Sta Juliana High School Capas, Tarlac <br>
                <b>Telephone Number:</b> 09612844757 <br>
                <b>Website:</b> www.stajulianahighschool.edu.ph
            </p>
        </div>

        <div>
            <h2>Admissions</h2>
            <p>
                For inquiries regarding admissions, you may contact the School's Admission Office at:<br>
                Admissions Office: 123-456-789<br>
                <b>Email: </b>
            </p>
        </div>

        <div>
            <h2>Other Useful Telephone Numbers:</h2>

            <p>
                <b>Records Office:</b> nikki.gutierrez01@deped.gov.ph<br>
                <b>Principal's Office:</b> liezl.sanchez001@deped.gov.ph<br>
                <b>SSG(Supreme School Government)</b> reynarose.cayabyab@deped.gov.ph<br>
                <b>Guidance Office:</b> Arnold.reyes@deped.gov.ph<br>

            </p>
        </div>

        <div>
            <h2>School Map</h2>
            <p>Sta. Juliana High School Capas, Tarlac</p>
            <br>
            <br>

            <div style="width: 80%;" class="map">
                <img src="./img/a/School Map.png" alt="Logo" height="500px" width="100%">
            </div>

        </div>

        <div class="formdiv">
            <form action='contacts.php' method='POST'>
                <label for="Name">Name</label><br>
                <input type="text" id="Name" name="Fname" placeholder="First Name">
                <input type="text" id="Name" name="Lname" placeholder="Last Name"><br>

                <label for="Email">Email</label><br>

                <input type="text" id="Email" name="sender" placeholder="Enter Email">


                <label for="inquiry">Inquiry</label><br>
                <textarea id="inquiry" name="inquiry" rows="4" cols="50"></textarea>



                <input type="submit" name='submit' value="Submit">
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

    $to = "jeraziahm@gmail.com";

    $subject = "Website Inquiry";

    $messagehere = $_POST['inquiry'];

    $headers = "From: {$_POST['sender']}";

    mail($to, $subject, $messagehere, $headers);
}
?>

</html>
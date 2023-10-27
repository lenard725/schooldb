<?php

session_start();

require '../../vendor/autoload.php';

if (!isset($_SESSION["log2authentication"])) {
    header("Location: ../login2.php");
    exit();
}

// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
$con = new MongoDB\Client("mongodb://localhost:27017/");

//echo "Connection to database successfully";
$db = $con->SchoolDB;
//echo "Database SchoolDB selected";
$col = $db->StudentAccount;
//echo "Collection StudentAccount Selected";
$col2 = $db->TeacherAccount;
//echo "Collection TeacherAccount Selected";
$col3 = $db->AdminAccount;
//echo "Collection AdminAccount Selected";

$finduser1 = $col->find()->toArray();
$finduser2 = $col2->find()->toArray();
$finduser3 = $col3->find()->toArray();

$merge1 = array_merge($finduser1, $finduser2);
$finduser = array_merge($merge1, $finduser3);


?> <!-- initial code for current login info -->

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css">
    <link rel="stylesheet" href="./css/employeeaccount.css? <?php echo time() ?>">
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
        <a href="./employeeaccount.php" class="active">Accounts</a>
        <a href="./employeeenroll.php">Enroll Students</a>
        <a href="./employeerecords.php">Records</a>
        <a href="./employeeforms.php">Forms</a>

        <form action="Employeeprofile.php" method="post">
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

            </select>
        </div>

        <div class="accountssheet">
            <div>
                <table class="table table-bordered">
                    <thead class="thead">
                        <tr>
                            <th id="x1strow" scope="col">Name</th>
                            <th scope="col">Role</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <!-- get expanded in php loop -->
                    <tbody>

                        <?php

                        foreach ($finduser as $founduser) {
                            echo "<tr>";
                            if ($founduser['role'] == "student") {
                                echo "<th scope='row'><a href='./accountedit.php?lrn=" . $founduser['idnumber'] . "' id='hyperlinkoff'>" . $founduser['name'] . "</th>";
                            } else {
                                echo "<th scope='row'><a href='./accountedit.php?enumber=" . $founduser['enumber'] . "' id='hyperlinkoff'>" . $founduser['name'] . "</th>";
                            }
                            echo "<td>" . $founduser['role'] . "</td>";
                            echo "<td>" . $founduser['email'] . "</td>";
                            echo "<td>" . $founduser['status'] . "</td>";
                        }

                        ?>


                        <!-- <tr>
                            <th scope="row"><a href="./accountedit.html"
                                    style="text-decoration: none; color:black;">Sample Name</a></th>
                            <td>x</td>
                            <td>x</td>
                            <td>x</td>
                        </tr> -->

                    </tbody>
                </table>
                <form action="employeeaccount.php" method="POST">
                    <input type="submit" id="addAccount" name="addaccount" value="Add Account">
                </form>
            </div>
        </div>

    </div>
</body>

<?php

if (isset($_POST['addaccount'])) {

    $_SESSION['addaccountstudentpage'] = 1;
    echo "<script> window.location.href='addaccount.php';</script>";
}

?>



</html>
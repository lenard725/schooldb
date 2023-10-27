<?php

require '../../vendor/autoload.php';

// connect to mongodb
$con = new MongoDB\Client("mongodb://localhost:27017/");
// $con = new MongoDB\Client("mongodb+srv://jeraziahm725:lenard725@cluster0.cgnztuo.mongodb.net/");
// echo "Connection to database successfully";

// select a database
$db = $con->SchoolDB;
// echo "Database SchoolDB selected";

//select collection
// echo "Collection Enrollcol Selected";
$col = $db->SectionDB;
// echo "Collection Enrollcol Selected";

$findsections = $col->find();

$sectionscount = $col->countDocuments();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TBD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/sidenav.css">
    <link rel="stylesheet" href="./css/employeesection.css?<?php echo time() ?>">
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
        <a href="./employeeaccount.php">Accounts</a>
        <a href="./employeeenroll.php">Enroll Students</a>
        <a href="./employeerecords.html">Records</a>
        <a href="./employeeforms.html">Forms</a>

        <form action="Employeeprofile.php" method="post">
            <input id="logoutbutton" type="submit" name="logout" value="Logout Account">
        </form>

    </div>

    <div class="main">

        <?php
        ?>




        <div class="mainset">
            <form action="employeesection.php" method="POST">
                <div class="mainselect">
                    <select name="gradelevel" id="gradelevel" onchange="this.form.submit()">
                        <option value="All">All</option>
                        <option value="Grade 7"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 7") { ?>
                                selected <?php } ?>>Grade 7</option>
                        <option value="Grade 8"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 8") { ?>
                                selected <?php } ?>>Grade 8</option>
                        <option value="Grade 9"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 9") { ?>
                                selected <?php } ?>>Grade 9</option>
                        <option value="Grade 10"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 10") { ?>
                                selected <?php } ?>>Grade 10</option>
                        <option value="Grade 11"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 11") { ?>
                                selected <?php } ?>>Grade 11</option>
                        <option value="Grade 12"<?php if (isset($_POST['gradelevel'])) if ($_POST['gradelevel'] == "Grade 12") { ?>
                                selected <?php } ?>>Grade 12</option>

                    </select>
                </div>

                <table class="table table-bordered" id="tableset">
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="col">Section Name</th>
                            <th scope="col">Grade Level</th>
                            <th scope="col">Adviser</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php

                        foreach ($findsections as $section) {
                            if (isset($section['gradelevel'])) {
                                if (isset($_POST['gradelevel']) && $_POST['gradelevel'] != "All") {
                                    if ($section['gradelevel'] == $_POST['gradelevel']) {
                                        echo "<tr>";
                                        echo "<th></th>";
                                        echo "<th scope='row'><input type='text' name='sectionname[]' value='{$section['sectionname']}'></th>";
                                        echo "<td>{$section['gradelevel']}</td>";
                                        echo "<td><input type='text' name='adviser[]' value='{$section['adviser']}'></td>";
                                        echo "</tr>";

                                        echo "<input type='hidden' name='sectionnumber[]' value='{$section['sectionnumber']}'>";
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<th></th>";
                                    echo "<th scope='row'><input type='text' name='sectionname[]' value='{$section['sectionname']}'></th>";
                                    echo "<td>{$section['gradelevel']}</td>";
                                    echo "<td><input type='text' name='adviser[]' value='{$section['adviser']}'></td>";
                                    echo "</tr>";

                                    echo "<input type='hidden' name='sectionnumber[]' value='{$section['sectionnumber']}'>";
                                }

                            } else {
                                echo "<th>There's no Section yet</th>
                            <td>There's no Section yet</td>
                            <td>There's no Section yet</td>";
                            }
                        }




                        ?>
                        <!-- <th><input type="text" name="email" placeholder=""> </th>
                    <td>Grade 7 </td>
                    <td><input type="text" name="email" placeholder=""> </td> -->
                    </tbody>
                </table>

                <div class="btnset">
                    <input type="submit" name="addsection" id="addsectionbtn" value="Add Section">
                    <input type="submit" name="savetable" id="savebtn" value="Save">
                </div>
            </form>
        </div>
    </div>

</body>

<?php

if (isset($_POST['addsection'])) {
    if ($_POST['gradelevel'] != "All") {

        $document = array(
            "sectionnumber" => $sectionscount + 1,
            "sectionname" => "",
            "gradelevel" => $_POST['gradelevel'],
            "adviser" => ""
        );

        $col->insertOne($document);
        echo "<script> window.location.href='employeesection.php';</script>";
    } else {
        echo "<script>alert('Please Pick Grade Level Before Adding Section')</script>";
    }

}


if (isset($_POST['savetable'])) {

    $sectionnumber = $_POST['sectionnumber'];
    $sectionname = $_POST['sectionname'];
    $adviser = $_POST['adviser'];

    foreach ($_POST['sectionnumber'] as $x => $number) {

        $updatethis = $col->updateOne(
            ['sectionnumber' => (int) $number],
            [
                '$set' => [
                    "sectionname" => $sectionname[$x],
                    "adviser" => $adviser[$x]
                ]
            ]


        );
    }

    echo "<meta http-equiv='refresh' content='0'>";
}




?>

</html>
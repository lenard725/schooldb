<?php

require '../vendor/autoload.php';

// connect to mongodb
$con = new MongoDB\Client("mongodb://localhost:27017/");
echo "Connection to database successfully";
// select a database

$db = $con->SchoolDB;
echo "Database SchoolDB selected";

//select collection
$col = $db->StudentAccount;
echo "Collection StudentAccount Selected";

$studentcol = $db->StudentAccount;
// echo "Collection Enrollcol Selected";
$subjectcol = $db->schoolsubject;
$teachercol = $db->TeacherAccount;
$sectioncol = $db->SectionDB;
$schedulecol = $db->ScheduleDB;

$findsubject = $subjectcol->find();
$findteacher = $teachercol->find([], ['sort' => ['name' => 1]]);
$findsection = $sectioncol->find([], ['sort' => ['gradelevel' => 1]]);
$findstudent = $studentcol->find(array('idnumber' => '0123-012345'));

$formcol = $db->FormCollection;

$bucket = $db->selectGridFSBucket();




if (isset($_POST['submit'])) {

    $form138name = 'learnerenrollmentsurveyform';
    $extension = pathinfo($_FILES["form138"]["name"], PATHINFO_EXTENSION);
    $newname = $form138name . "." . $extension;

    $source = $_FILES["form138"]["tmp_name"];
    $targetDir = "./fileupload/{$newname}";

    move_uploaded_file($source, $targetDir);


    // $document = array(
    //     'unique' => '123',
    //     "fillerform" => $newname
    // );

    // $formcol->insertOne($document);

    // $updateResult = $studentcol->updateOne(
    //     ['unique' => '123'],
    //     ['$set' => ['servicerecordform' => $newname]]

    // );

    $form138holder = $bucket->openUploadStream($newname);
    $form138contents = file_get_contents($targetDir);
    fwrite($form138holder, $form138contents);
    fclose($form138holder);

}











?>

<html>

<body>



    <form action="test.php " method='post' enctype="multipart/form-data">
        <div class="input-group mb-3">
            <label class="input-group-text" for="">Attach Form 138</label>
            <input type="file" class="form-control" id="form138" name="form138">
        </div>
        <input type="submit" name="submit" value="update">
    </form>
</body>


</html>
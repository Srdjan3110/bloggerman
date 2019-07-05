<?php
session_start();
include('config/config.php');

$conn = new mysqli(SERVER, USER, PASS, DB); 
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

$postBody='';
$privateStatus='';
$userId='';
$username='';
if($_SESSION['userId']){
	$userId = $_SESSION["userId"];
	$username = $_SESSION['username'];
};

/********************ADD PHOTO TO FOLDER ******************/
if (isset($_POST['submitPost'])) {

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = ['jpg', 'jpeg', 'png', 'bmp'];

    if(!empty($fileName)){
    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) {
			   $fileNameNew = $fileName;
                $fileDestination = 'uploaded/'.$fileNameNew; // folder to where to upload new images
                move_uploaded_file($fileTmpName,$fileDestination);
               // header("Location: dashboard.php?uploadsuccess");                        mozda ce ovo da treba
            } else {
                $imgmsg = "Izabrani fajl je prevelike velicine, molimo izaberite manji fajl!";
            }
        } else {
            $imgmsg = "Ups, desila se greška tokom postavljanja tvog fajla.";
        }
    } else {
        $imgmsg = "Nažalost, ne možete postaviti fajl ovog tipa, izaberite drugi tip.";
    }
}
}
/*******************************************************/

if(!empty($_POST["submitPost"])){
$blogTitle = $_POST['blogTitle'];
$blogBody = $_POST["blogBody"];
if(!empty($_FILES['file']['name'])){
	$image = $_FILES['file']['name'];
	}
$date = date("d.m.Y");
// IVAN - store path for uploaded images
if(!empty($_FILES['file']['name'])){
	$target_dir = "uploaded/";
	$target_file = $target_dir . basename($image);
	}
	// IVAN - END path for uploaded images

$sqlInsert = "INSERT INTO articles (postId, userId, username, title, article, mainImg, date) VALUES (null,'".$userId."','".$username."','".$blogTitle."','".$blogBody."','".$fileNameNew."','".$date."')";
$resultInsert = $conn->query($sqlInsert);
if($resultInsert === true){
	$postSuccessMessage = "Vas status je upesno unet.";
}else{
	$postSuccessMessage = "Imate gresku u konekciji.".$conn->error;
}
};
header('Location: index.php');
//end of insert post code
?>
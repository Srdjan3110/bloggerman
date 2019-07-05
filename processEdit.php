<?php
session_start();
include("config/config.php");

// Create connection
$conn = new mysqli(SERVER, USER, PASS, DB); 
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
/********************ADD PHOTO TO FOLDER ******************/
if (isset($_POST['editPost'])) {

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


if(!empty($_POST["editPost"])){
    $postId = $_POST['postId'];
    $blogTitle = $_POST['blogTitle'];
    $blogBody = $_POST['blogBody'];
    $username = $_SESSION['username'];
    $date = date("d.m.Y");
	if($fileNameNew==''){
	$fileNameNew=$_POST['mainImg'];	
	}
	if(!empty($_FILES['file']['name'])){
	$image = $_FILES['file']['name'];
	} 
	if(!empty($_FILES['file']['name'])){
	$target_dir = "uploaded/";
	$target_file = $target_dir . basename($image);
	}


    $sqlInsert =  "UPDATE articles SET articles.title= '$blogTitle', articles.article='$blogBody', articles.username='$username', articles.mainImg='$fileNameNew', articles.date = '$date' WHERE articles.postId = $postId";
    $resultInsert = $conn->query($sqlInsert);

    
}
header('Location: article.php?postId='.$postId.'');

$conn->close();

?>
<?php
session_start();
include('config/config.php');
$username= $_SESSION['username'];
$conn = new mysqli(SERVER, USER, PASS, DB); 

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
$postId = $_GET['postId'];

$sql = "DELETE FROM articles WHERE articles.postId = $postId"; 

$result = $conn->query($sql);

header('Location: userArticles.php?username='.$username);
$conn->close();
?>
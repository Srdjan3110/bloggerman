<?php
session_start();
include("config/config.php");

$conn = new mysqli(SERVER, USER, PASS, DB); 

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}

if(!empty($_GET["postId"])) {
$postId =$_GET["postId"];
} else {
    $postId = '';
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({selector:'textarea'});</script>
	<link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>
	<header>
		<a href="index.php"><h3>Bloggerman</h3></a>
		<div id="links">
			<a href="index.php"><p>All Articles</p></a>
			<a href="create.php"><p>Create Article</p></a>
			<?php
			if (empty($_SESSION['username'])) {
			echo '<a href="login.php"><p>Login</p></a>
					<a href="register.php"><p>Register</p></a>';
			}
			else
			echo '<a href="login.php"><p>Logout</p></a>';
			?>
			
			<?php
			if (!empty($_SESSION['username'])) {
				$username=$_SESSION['username'];
				echo '<a href="userArticles.php?username='.$username.'"><p>'.$username.'</p></a>';
			}
			?>
		</div>
	</header>
<?php
$sql = "SELECT postId, userId, username, title, article, mainImg, date FROM articles WHERE postId = $postId";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {


			    while($row = $result->fetch_assoc()) {
			    	$blogTitle = $row['title'];
			    	$blogBody = $row['article'];
			    	$username = $row['username'];
			    	if ($row['mainImg']==''){
			    	$row['mainImg']= 'noimage.jpg';
			    }
			    	$mainImg = $row['mainImg'];
			    }


if (!empty($_SESSION['username'])) {
echo
<<<HTML
	<main id="createArticle">
		<form id="createArticle2" action="processEdit.php" method="post" enctype="multipart/form-data">
			<h1>Create Your Article</h1>
			<img id="blogImg" src="uploaded/$mainImg">
			<input type="hidden" name="postId" value="$postId">
			<input type="hidden" name="mainImg" value="$mainImg">
			<input type="text" name="blogTitle" placeholder="Title" id="naslov" value="$blogTitle">
			<br>
			<input type="file" name="file" id="image" value="dodaj sliku">
			<br>
			<textarea name="blogBody" rows="30" cols="100">$blogBody</textarea>
			<br>
			<input type="submit" name="editPost" value="submit">
		<form>
	</main>
HTML;
}
else {
echo '<h2>Please login to create article</h2>';
};
};
?>
</body>
</html>
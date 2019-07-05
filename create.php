<?php
session_start();
include('config/config.php');
$username='';
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
if (!empty($_SESSION['username'])) {
echo
<<<HTML
	<main id="createArticle">
		<form id="createArticle2" action="processCreate.php" method="post" enctype="multipart/form-data">
			<h1>Create Your Article</h1>
			<input type="text" name="blogTitle" placeholder="Title" id="naslov">
			<br>
			<input type="file" name="file" id="image" value="dodaj sliku">
			<br>
			<textarea name="blogBody" rows="30" cols="100"></textarea>
			<br>
			<input type="submit" name="submitPost" value="submit">
		<form>
	</main>
HTML;
}
else {
echo 

<<<HTML
<main id="createArticle">
<h2>Please login to create article</h2>
</main>
HTML;
}
?>
</body>
</html>
<?php
session_start();
include('config/config.php');
if (!empty($_SESSION['username'])) {
	session_destroy();
	header('location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>login</title>
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
	<form id="form1" action="processLogin.php" method="post">
			<input type="text" name="username" placeholder="Username">
			<input type="password" name="password" placeholder="Password">
			<input type="submit" name="login" value="login" id="button">
	</form>
	<?php

	?>
</body>
</html>
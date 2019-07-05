<?php
session_start();
include('config/config.php');
if (empty($_GET['registerMessage'])) {
$registerMessage='';
}else{
$registerMessage=$_GET['registerMessage'];
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
	<div id="registracija">
			<h3>Registracija</h3>
			<form id="form2" action="processregister.php" method="post">				
				<input type="email" name="email" placeholder="Unesite vasu email adresu" required="">
				<input type="text" name="username" placeholder="Unesite vase korisnicko ime" required="">
				<input type="password" name="password" placeholder="Unesite vasu lozinku" required="">
				<input type="submit" name="registersubmit" value="Pošalji" id="button">
				<?php echo $registerMessage;?>
			</form>
		</div>
	<?php

	?>
</body>
</html>
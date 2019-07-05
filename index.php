<?php
session_start();
include('config/config.php');
$username='';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Bloggerman</title>
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
	<main id="allArticles">
		<?php
$conn = new mysqli(SERVER, USER, PASS, DB); 
// Check connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
};

$sql = "SELECT postId, userId, username, title, article, mainImg, date FROM articles";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row

			    while($row = $result->fetch_assoc()) {
			    	if ($row['mainImg']==''){
			    	$row['mainImg']= 'noimage.jpg';
			    }
			    	echo "<a href='article.php?postId=".$row["postId"]."'><div class='oneArticle'>";
			        echo '<h2>'.$row["title"].'</h2><br>';
			        echo "<div class='thumbnails'><img src='uploaded/".$row['mainImg']."'></div></a><br>";
			        echo "<p>Author: <a href='userArticles.php?username=".$row["username"]."'>".$row["username"]."</a></p>";
			        echo "<p>Date: ".$row["date"]."</p></div></div>";
			    }
			} else {
			    echo "<div class='oneArticle'><h2>No articles available.</h2></div>";
			}
			$conn->close();


?>
	</main>
</body>
</html>
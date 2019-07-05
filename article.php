<?php
session_start();
include('config/config.php');
$postId = $_GET['postId'];
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

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
};

$sql = "SELECT postId, userId, username, title, article, mainImg, date FROM articles WHERE postId = $postId";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
			    

			    while($row = $result->fetch_assoc()) {
			    	if ($row['mainImg']==''){
			    	$row['mainImg']= 'noimage.jpg';
			    }
			    	echo '<h1>'.$row['title'].'</h1>';
			    	echo "<img id='blogImg' src='uploaded/".$row['mainImg']."'>";
			    	echo "<p>".$row['article']."</p>";
			    	if ($_SESSION['userId']==$row['userId']) {
			        echo "<a href='edit.php?postId=".$row['postId']."'>Edit post</a><br>";
			        echo "<a href='delete.php?postId=".$row['postId']."'>Delete post</a>";
			        }
			    }
			} else {
			    echo "<div class='oneArticle'><h2>No articles available.</h2></div>";
			}
			$conn->close();


?>
	</main>
</body>
</html>
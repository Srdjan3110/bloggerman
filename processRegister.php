<?php include("config/config.php");?>
<?php
$registerMessage = false;
if(!empty($_POST["registersubmit"])){
	$ok = true;
	if(empty($_POST['username'])){
		$ok = false;
	}
	if(empty($_POST['email'])){
		$ok = false;
	}
	if(empty($_POST['password'])){
		$ok = false;
	}
	if(strlen($_POST['password'])<4){
		$ok = false;
		$registerMessage = "Lozinka mora biti duza od pet karaktera";
        header('Location: index.php?registerMessage='.$registerMessage);
	}


	if($ok == true){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];

		$hash = password_hash($password, PASSWORD_DEFAULT);

		$conn = mysqli_connect(SERVER, USER, PASS, DB);

		$escapeUsername = mysqli_real_escape_string($conn, $username);
		$escapeEmail = mysqli_real_escape_string($conn, $email);
		$escapeHash = mysqli_real_escape_string($conn, $hash);

		$sqlSelect= "SELECT * FROM users WHERE username='".$escapeUsername."'";
		$resultSelect = $conn->query($sqlSelect);
		if($resultSelect->num_rows > 0){
		$ok = false;
	}

		if($ok == true){
		$sql = "INSERT INTO users (email, username, password) VALUES ('".$escapeEmail."',
       '".$escapeUsername."',
       '".$escapeHash."')";

		$registerUser = mysqli_query($conn, $sql);

		if($registerUser === true){
			$registerMessage = "User ".$username." added to db.";;
		}else{
			$registerMessage ="Error description: " . mysqli_error($conn);
			
		}
		header('Location: index.php?registerMessage='.$registerMessage);
	}else{

		$registerMessage = "Username is taken. Please, choose another username.";
		header('Location: register.php?registerMessage='.$registerMessage);
	}
		mysqli_close($conn);
	}
	}	


?>
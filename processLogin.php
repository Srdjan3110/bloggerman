<?php
session_start();
include('config/config.php');
//definisemo varijable
$username = !empty($_POST['username']);
$password = !empty($_POST['password']);
$hashUnos = password_hash($password, PASSWORD_DEFAULT);
//provera da li su prazne
if($username && $password) {
	$db = mysqli_connect(SERVER, USER, PASS, DB);
	//promenimo enkodiranje na utf8
	mysqli_set_charset($db, "utf8");

	//ubacimo sigurni username unutar sql
	$sql = sprintf("SELECT * FROM users WHERE username='%s'", mysqli_real_escape_string($db, $_POST['username'])
);

	$result = mysqli_query($db, $sql);
	$row = mysqli_fetch_assoc($result);
	if($row) {
		$hash = $row['password'];

if (password_verify($_POST['password'], $hash)){
	$message = 'Login successful.';

	$_SESSION['username'] = $row['username'];
	$_SESSION['userId'] = $row['userId'];
	$_SESSION['email'] = $row['email'];

	header('Location: index.php');
} else {
	
  		setcookie("poruka", "Pogresna lozinka", time() + (86400), "/");
        //header ('Location: index.php');
        echo 'lozinka nije dobra';
        echo '<br/>'.$hash.'<br/>';
        echo $hashUnos;
}
	}else {
        setcookie("poruka", "Pogresni podaci", time() + (86400), "/");
        //header ('Location: index.php');
        echo 'podaci ne valjaju';
    }
    mysqli_close($db);
} else {
    setcookie("poruka", "Niste popunili sva polja", time() + (86400), "/");
    //header ('Location: index.php');
    echo 'Niste popunili sva polja';
}



?>
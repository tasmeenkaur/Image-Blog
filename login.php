<html>
<body>
<h1>Login</H1><br>
<form action= "" enctype="multipart/form-data" method="post">
    Enter Username:  <input type="text" name = "username" value="username">
    Enter Password:   <input type="password" name = "password" value="password">
    
    <input type="submit" value="Send">
</form>


<?php


echo "User Authentication";

$db = new pdo('mysql:unix_socket=/cloudsql/project2-972:assgn2;dbname=scale',
  'root',  // username
  'tas'       // password
  );
if ($_SERVER["REQUEST_METHOD"] == "POST"){

$user=$_POST['username'];
$pass=$_POST['password'];



$stmt=$db->prepare("select username, password from Register where username='$user' and password='$pass'");

$stmt->execute();
$row = $stmt->fetch();
echo $row['username'];

if($row>0)
{
	session_start();
	$_SESSION['user'] = $user;
	

    header("Location: upload.php");
    echo '<meta http-equiv="refresh" content="0; URL=http://project2-972.appspot.com/upload.php">';
}

}
?>

</body>
</html>
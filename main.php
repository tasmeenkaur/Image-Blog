<html>
<body>
<h1>REGISTER</H1><br>
<form action= "main.php" enctype="multipart/form-data" method="post">
    Set Username:  <input type="text" name = "username" value="username">
    Set Password:   <input type="password" name = "password" value="password">
    
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
$table= "Register";
$columns = "username varchar(150) PRIMARY KEY, password varchar(120) " ;
$createTable = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$table ($columns)");
$createTable->execute();

$tab= "image";
$col = "username varchar(200), filename varchar(200),filesize varchar(200),fileurl varchar(200),comments varchar(200)" ;
$createTab = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$tab($col)");
$createTab->execute();

$tab1= "comments";
$col1 = "fileurl varchar(20) , comments varchar(500)" ;
$createTab1 = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$tab1($col1)");
$createTab1->execute();

$insert_stm = $db->prepare("insert into Register values('$user','$pass')");
$insert_stm->execute();
$stmt=$db->prepare("select username, password from Register where username='$user' and password='$pass'");

$stmt->execute();
$row = $stmt->fetch();

if($row>0)
{
	
    header("Location: login.php");
    echo '<meta http-equiv="refresh" content="0; URL=http://project2-972.appspot.com/login.php">';
}

}
?>

</body>
</html>
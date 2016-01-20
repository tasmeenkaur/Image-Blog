<?php
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

$fileName = 'gs://summ/'.$_FILES['userfile']['name'];
echo $fileName."<br>";

$options = array('gs'=>array('acl'=>'public-read','Content-Type' => $_FILES['userfile']['type']));
$ctx = stream_context_create($options);

if (false == rename($_FILES['userfile']['tmp_name'], $fileName, $ctx)) {
  die('Could not rename.');
}

$object_public_url = CloudStorageTools::getPublicUrl($fileName, true);
echo $object_public_url."<br>";
//header('Location:' .$objectPublicUrl); // redirects the user to the public uploaded file, comment any previous output (echo's).
$filename = $_FILES['userfile']['name'];
echo $filename."<br>";
$size = $_FILES['userfile']['size'];
echo $size."<br>";

$db = new pdo('mysql:unix_socket=/cloudsql/project2-972:assgn2;dbname=scale',
  'root',  // username
  'tas'       // password
  );

$username = $_SESSION['user'];
echo $username;
$val = $db->prepare("insert into image (username,filename,filesize,fileurl) values('$username','$filename','$size','$object_public_url')");
$val->execute();
$stm = $db->prepare("select * from image");
$stm->execute();
//$show = $stm->fetch();
//echo $show;

// Displaying all the uploaded files in a web page.

echo "<table border='2'>";
echo '<tr>';

echo '<th>FileName:</th>';
echo '<th>Image:</th>';
echo '<th>FileSize:</th>';
echo '<th>FileURL:</th>';
echo '<th>FileURL:</th>';
echo '</tr>';


while($row = $stm->fetch()) {
	
    $filename = $row['filename'];

    $filesize = $row['filesize'];

    $fileurl = $row['fileurl'];
	$commentss = $row['comments'];
    echo '<tr>';
	
    echo '<td>'.$filename.'</td>';
    echo '<td>'.$filesize.'</td>';
	echo '<td>';
    echo "<img src='" . $fileurl . "'></img><form action = 'comments.php' method='POST' ><input type = 'text' name ='comm' /><input type = 'submit' name = 'com' value='submit' /></form>";
  if(isset($_POST['com']))
  {
    $comment = $_POST['comm'];
    $ins=$db->prepare("insert into comments  value('$fileurl','$comment')");
    $ins->execute();
    
  }
    echo '<td>'.$commentss.'</td>';
	
	
	echo '</td>';
	echo '<td>'.$fileurl.'</td>';
	
	
    echo '</tr>';

    }

echo '</table>';

?>
<html>
<body>
<form action= "upload.php" enctype="multipart/form-data" method="post">
    <input type="submit" value="go back">
       
    </form>

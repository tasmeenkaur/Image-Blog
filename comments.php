<?
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
 

 $db = new pdo('mysql:unix_socket=/cloudsql/project2-972:assgn2;dbname=scale',
  'root',  // username
  'tas'       // password
  );
  $data = $db->prepare("select * from image");
  $data->execute();
  echo "<table border='2'>";
echo '<tr>';

echo '<th>FileName:</th>';
echo '<th>Image:</th>';
echo '<th>FileSize:</th>';
echo '<th>FileURL:</th>';
echo '<th>comments:</th>';
echo '</tr>';


while($row = $data->fetch()) {
	
    $filename = $row['filename'];

    $filesize = $row['filesize'];

    $fileurl = $row['fileurl'];
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
   
	
    echo '</td>';
	echo '<td>'.$fileurl.'</td>';
	echo '<td>'.$comment.'</td>';
	
	
    echo '</tr>';

    }

echo '</table>';

  
?>

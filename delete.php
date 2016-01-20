<?
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
 $username = $_SESSION['user'];
 echo $username;
 $db = new pdo('mysql:unix_socket=/cloudsql/project2-972:assgn2;dbname=scale',
  'root',  // username
  'tas'       // password
  );
  $data = $db->prepare("select * from image where username = '$username' ");
  $data->execute();
  echo "<table border='2'>";
echo '<tr>';

echo '<th>FileName:</th>';
echo '<th>Image:</th>';
echo '<th>FileSize:</th>';
echo '<th>FileURL:</th>';
echo '</tr>';


while($row = $data->fetch()) {
	
    $filename = $row['filename'];

    $filesize = $row['filesize'];

    $fileurl = $row['fileurl'];
    echo '<tr>';
	
    echo '<td>'.$filename.'</td>';
    echo '<td>'.$filesize.'</td>';
	echo '<td>';
    echo "<img src='" . $fileurl . "'></img><form action = 'delete.php' method='POST' ><input type='submit' name= 'submit' value='delete'></form>";
	if(isset($_POST['submit']))
	{
		$del->exec("delete from image where fileurl='$fileurl' ");
		
	}
	
    echo '</td>';
	echo '<td>'.$fileurl.'</td>';
	
    echo '</tr>';

    }

echo '</table>';

  
?>

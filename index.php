<?php
session_start();
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors','on');

require 'vendor/autoload.php';
use Aws\DynamoDb\DynamoDbClient;

include('image_check.php');
$msg='';
if($_SERVER['REQUEST_METHOD'] == "POST")
{

$name = $_FILES['file']['name'];
$size = $_FILES['file']['size'];
$tmp = $_FILES['file']['tmp_name'];
$ext = getExtension($name);
echo $name;
echo $size;
echo $tmp;
echo $ext;
if(strlen($name) > 0)
{

if(in_array($ext,$valid_formats))
{
 
if($size<(1024*1024))
{
include('s3_config.php');
//Rename image name. 
$actual_image_name = time().".".$ext;
echo $actual_image_name;
if($s3->putObjectFile($tmp, $bucket , $actual_image_name, S3::ACL_PUBLIC_READ) )
{
$msg = "S3 Upload Successful.";	
$s3file='http://'.$bucket.'.s3.amazonaws.com/'.$actual_image_name;
echo "<img src='$s3file' style='max-width:400px'/><br/>";
echo '<b>S3 File URL:</b>'.$s3file;

//put to database

       
$des=$_POST['Description'];
       $cats=$_POST['category'];
       $usrnme=$_SESSION['userId'];
echo $usrnme;
$itemid=rand();       
try
       {
          $client = DynamoDbClient::factory(array(
               'key' => 'AKIAJBNLIKJSXIO7STNQ',
               'secret'=>'qSgNqrhK/vQ0rtNqrqDnuqZ0SgEroP1bJrW0gK6a',
               'region' => 'us-west-2'  // replace with your desired region
          ));
          $response = $client->putItem(array(
          "TableName" => 'itemstosell1',
          "Item" => $client->formatAttributes(array(
                           "itemid" => $itemid,//primary key
                           "username" => $usrnme,
                           "description"  => $des,
                           "category"  => $cats,
                           "image" => "<img src='$s3file' height='300' width='300'/><br/>")
                )
          ));
         echo $response["item"];
header('Location: posts.php');       
}
       catch (PDOException $e)
       {
           print "Error!: " . $e->POSTMessage() . "<br/>";
           die();
       }



}
else
$msg = "S3 Upload Fail.";


}
else
$msg = "Image size Max 1 MB";

}
else
$msg = "Invalid file, please upload image file.";

}
else
$msg = "Please select image file.";

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload Files to Amazon S3 PHP</title>
</head>

<body bgcolor="#d8dfea">
<form action="" method='post' enctype="multipart/form-data" id="main">

<h3>Upload image file here</h3><br/>
<div style='margin:10px'><input type='file' name='file'/> <input type='submit' value='UploadImage'/></div>
Enter The Category of your item <input type="text" name="category" >
</form>
<textarea rows="4" cols="50" name="Description" form="main">
Enter the item escription here...</textarea>
<>
<?php 
echo $msg.'<br/>'; 
?>
		

</body>
</html>

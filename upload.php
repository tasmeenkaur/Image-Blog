<?
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
$options = [ 'gs_bucket_name' => 'summ' ];
$upload_url = CloudStorageTools::createUploadUrl('/upload_handler.php', $options);

?>
<form action="<?php echo $upload_url?>" enctype="multipart/form-data" method="post">
    Files to upload: <br>
   <input type="file" name="userfile" size="40">
   <input type="submit" value="Send">
</form>    
<form action="delete.php" enctype="multipart/form-data" method="post">
	<input type="submit" value="delete">
</form>
<form action="comments.php" enctype="multipart/form-data" method="post">
	<input type="submit" value="comments">
</form>

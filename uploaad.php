<?

require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';

use google\appengine\api\cloud_storage\CloudStorageTools;

$options = [ 'gs_bucket_name' => 'summ' ];

$upload_url = CloudStorageTools::createUploadUrl('/upload_handler.php', $options);

?>

<form action="<?php echo $upload_url?>" enctype="multipart/form-data" method="post">

    Files to upload: <br>

    <input type="file" name="uploaded_files" size="40">

    <input type="hidden" name="upload" value="1"/>

    <input type="submit" value="Send">

</form>
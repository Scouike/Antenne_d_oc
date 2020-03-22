<?php
// Upload directory
$target_dir = "uploads/";

// Upload file
$target_file = $target_dir . basename($_FILES["file"]["name"]);

$msg = "";
if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
  $msg = "Successfully uploaded";
}else{ 
  $msg = "Error while uploading";
}
echo $msg;
exit;
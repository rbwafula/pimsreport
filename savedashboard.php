<?php 

// Requires php5 
define('UPLOAD_DIR', 'assets/images/'); 
$img = $_POST['imgBase64']; 
$img = str_replace('data:image/png;base64,', '', $img); 
$img = str_replace(' ', '+', $img); 
$data = base64_decode($img);
$filename = strtolower(str_replace(' ', '_', $_POST['entity']));
//$file = UPLOAD_DIR . uniqid() . '.png'; 
$file = UPLOAD_DIR . $filename . '.png'; 
$success = file_put_contents($file, $data); 
print $success ? $file : 'Unable to save the file.'; 

?> 
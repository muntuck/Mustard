<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/Mustard/Utility/define.php";
require(MODEL."/Client.php");

$clientID = $_POST['clientID'];
$lastName = $_POST['lastName'];
$img = $_POST['base64image'];

$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);

$fileName = $lastName . $clientID . ".jpg"; 
$filePath = PHOTOS .  $fileName;

$success = file_put_contents($filePath, $data);
print $success ? $filePath : 'Unable to save the file.';

$client = new Client();
$client->addPhoto($clientID, $fileName);
?>

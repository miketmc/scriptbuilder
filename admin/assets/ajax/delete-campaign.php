<?php 
$campaign = $_REQUEST['campid'];
include('../../includes/init.php');

$delcamp = $db->prepare("DELETE from campaigns where ID = '$campaign'");
$delcamp->execute();

?>
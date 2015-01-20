<?php 
$campid = $_REQUEST['campid'];
include('../../includes/init.php');

$stmt = $db->prepare("SELECT * FROM campaigns WHERE ID = '$campid'");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($row);
?>
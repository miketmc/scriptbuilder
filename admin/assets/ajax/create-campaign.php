<?php 
$campname = $_REQUEST['cname'];
include('../../includes/init.php');

/* check for dupe */

$checkdupe = $db->prepare("SELECT * from campaigns where CampName = '$campname'");
$checkdupe->execute();

if ($checkdupe->rowCount()) {

$status =  array(	'error' => "A Campaign Named '".$campname."' Already Exists. Campaign Not Created.",
					'lastid' => 0
 );

echo json_encode($status);
die();

}

$stmt = $db->prepare('INSERT INTO campaigns (CampName) VALUES(:campname)');
$stmt->execute(array(
    ':campname' => $campname
));
$lastId = $db->lastInsertId();
$status =  array(	'error' => "Campaign '".$campname."' Created.",
					'lastid' => $lastId
 );

echo json_encode($status);

?>
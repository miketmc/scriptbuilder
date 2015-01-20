<?php 
include('../../includes/init.php');

$stmt = $db->prepare('SELECT * FROM campaigns ORDER BY ID DESC');
$stmt->execute();
$campaigns = "";

while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     
    $campaigns = $campaigns . '<tr>';
	$campaigns = $campaigns . '<td>' . $row['ID'] . '</td>';
	$campaigns = $campaigns . '<td>' . $row['CampName'] . '</td>';
	$campaigns = $campaigns . '<td><img src="./assets/images/edit.png" class="edit" data-id="'.$row['ID'].'"></td>';
	$campaigns = $campaigns . '<td><img src="./assets/images/trash.gif" class="trash" data-id="'.$row['ID'].'"></td>';
	$campaigns = $campaigns . '</tr>';
  
    }

    echo $campaigns;

?>
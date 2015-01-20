<?php
try {
	$db = new PDO('mysql:host=172.16.80.10;dbname=scriptbuilder','root','PrusW8gu');
} catch (PDOException $e) {
	error_log($e->getMessage());	
}
/*
$sql = "SELECT * FROM campaigns";

    $stmt = $db->prepare('SELECT * FROM campaigns');
    $stmt->execute();
 
  while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        print_r($row);
    }
    echo "done";
*/
?>
<?php
try {
	$db = new PDO('mysql:host=172.16.80.10;dbname=scriptbuilder','root','PrusW8gu');
} catch (PDOException $e) {
	error_log($e->getMessage());	
}

/*
*
* Initialize Tabs
*
*/

	$sql = "SELECT * FROM tabs WHERE CampID ='$campid'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $tab_titles = explode(",", $row['TabNames']);
    $tab_content = explode(",", $row['TabContent']);

/*
*
* Initialize Content
*
*/

    $sql = "SELECT * FROM content WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     
        $content[$row['ID']] = array('title' => $row['Title'], 'copy' => $row['Copy'] );
    
    }

/*
*
* Initialize Forms
*
*/

    $sql = "SELECT * FROM forms WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
     
        $forms[$row['ID']] = array('title' => $row['FormName'], 'code' => $row['FormCode'] );
    
    }

?>
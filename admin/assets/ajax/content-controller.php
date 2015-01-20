<?php 
include('../../includes/init.php');
$mode = $_REQUEST['mode'];
$campid = $_REQUEST['campid'];
$err ="";
switch ($mode) {

    case 'pop';

    $sql = "SELECT * FROM content WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $err = $err . "<tr>";
        $err = $err . "<td>".$row['Title']."</td>";
        $err = $err . '<td width="16"><img src="./assets/images/edit.png" class="c-edit" data-conid="'.$row['ID'].'"></td>';
        $err = $err . '<td width="16"><img src="./assets/images/trash.gif" class="c-trash" data-conid="'.$row['ID'].'"></td>';
        $err = $err . "</tr>";
    }

    break;

    case 'getlist';

    $sql = "SELECT * FROM content WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $err = $err . '<option value="'.$row['ID'].'">'.$row['Title'].'</option>';
    }
    
    break;    

	case 'edit':

    $sql = "SELECT * FROM content WHERE ID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $err = json_encode($stmt->fetch(PDO::FETCH_ASSOC));

	break;

	case 'delete':

    $delcon = $db->prepare("DELETE from content where ID = '$campid'");
    $delcon->execute();
    $err = "Content Deleted";

	break;

	case 'save':
	$title = $_REQUEST['title'];
	$content = $_REQUEST['copy'];
   
 	    $sql = "SELECT * FROM content WHERE CampID ='$campid' AND Title = '$title'";
	    $stmt = $db->prepare($sql);
	    $stmt->execute();

    if ($stmt->rowCount()) { 

    	$sql = "UPDATE content SET Copy=".$db->quote($content)." WHERE Title='$title' AND CampID='$campid'";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Content Updated";

    } else {

    	$sql = "INSERT INTO content (Title, Copy, CampID) VALUES('$title','$content','$campid')";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Content Saved";

    }
	/* check if content already exists */
	break;
}

echo $err;


?>
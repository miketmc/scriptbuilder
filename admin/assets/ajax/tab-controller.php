<?php include('../../includes/init.php');
$mode = $_REQUEST['mode'];
$campid = $_REQUEST['campid'];
$err ="";
switch ($mode) {

	case 'save';

	$titles=$_REQUEST['names'];
	$content = $_REQUEST['content'];

 	    $sql = "SELECT * FROM tabs WHERE CampID ='$campid'";
	    $stmt = $db->prepare($sql);
	    $stmt->execute();

    if ($stmt->rowCount()) { 

    	$sql = "UPDATE tabs SET TabNames='".$titles."', TabContent='".$content."' WHERE CampID='$campid'";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Tabs Updated";

    } else {

    	$sql = "INSERT INTO tabs (TabNames, TabContent, CampID) VALUES('$titles','$content','$campid')";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Tabs Saved";

    }

	break;

	case 'pop';

	$sql = "SELECT * FROM tabs WHERE CampID ='$campid'";
	$stmt = $db->prepare($sql);
	$stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $titles = explode(",", $row['TabNames']);
    $content = explode(",", $row['TabContent']);

    $options = array();
    $sql = "SELECT * FROM content WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $ctr = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $selections = $row['Title'];
       $id = $row['ID'];
       $options[] = array('id' => $id, 'selection' => $selections );
    }
    $html ="";
    $ctr = 0;

    foreach ($titles as $key => $title) {

	  $html = $html . '<tr>';
	  $html = $html . '<td width="250"><input name="tab-title" class="tab-title" value="'.$title.'"></td>';
	  $html = $html . '<td width="250"><select name="content-selection" class="content-selection">';


		  foreach ($options as $option) {
			  if ($option['id'] == $content[$key]) {
		          	$html = $html . '<option value="'.$option['id'].'" selected="selected">'.$option['selection'].'</option>';
				  } else {
				  	$html = $html . '<option value="'.$option['id'].'">'.$option['selection'].'</option>';
				  }
				$ctr++;
		  }
	  $html = $html . '</select></td>';
	  $html = $html . '<td width="16" class="t-trash"><img src="./assets/images/trash.gif" ></td>';
	  $html = $html . '</tr>';    

    }
    $err = $html;

	break;

}

echo $err;

?>
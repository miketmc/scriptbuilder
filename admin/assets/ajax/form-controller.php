<?php include('../../includes/init.php');
$mode = $_REQUEST['mode'];
$campid = $_REQUEST['campid'];
$err ="";
switch ($mode) {

	case 'pop';

    $sql = "SELECT * FROM forms WHERE CampID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $err = $err . "<tr>";
        $err = $err . "<td width='8'>".$row['ID']."</td>";
        $err = $err . "<td width='155'>".$row['FormName']."</td>";
        $err = $err . '<td width="16"><img src="./assets/images/edit.png" class="f-edit" data-formid="'.$row['ID'].'"></td>';
        $err = $err . '<td width="16"><img src="./assets/images/trash.gif" class="f-trash" data-formid="'.$row['ID'].'"></td>';
        $err = $err . "</tr>";
    }

    break;

	case 'save';

	$title = $_REQUEST['title'];
	$content = $_REQUEST['copy'];
   
 	    $sql = "SELECT * FROM forms WHERE CampID ='$campid' AND FormName = '$title'";
	    $stmt = $db->prepare($sql);
	    $stmt->execute();

    if ($stmt->rowCount()) { 

    	$sql = "UPDATE forms SET FormCode=".$db->quote($content)." WHERE FormName='$title' AND CampID='$campid'";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Form Updated";

    } else {

    	$sql = "INSERT INTO forms (FormName, FormCode, CampID) VALUES('$title','$content','$campid')";
    	$stmt = $db->prepare($sql);
    	$stmt->execute();
    	$err = "Form Saved";
    }

	break;

	case 'delete';

	$delcon = $db->prepare("DELETE from forms where ID = '$campid'");
    $delcon->execute();
    $err = "Form Deleted";

	break;

	case 'edit';

    $sql = "SELECT * FROM forms WHERE ID ='$campid'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $form = $stmt->fetch(PDO::FETCH_ASSOC);
    $forms = json_decode($form['FormCode']);
    $name = $form['FormName'];
    $ctr=0;
    $html = "";

    foreach ($forms as $form) {

    	switch ($form[0]) {

    	case 'text';

    	$html = $html . '<li data-type="text" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		$html = $html . 'Text Input: <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		$html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		$html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		$html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		$html = $html . '<h4 id="title-'.$ctr.'">Input Label</h4>';
		$html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
		$html = $html . '<h4>Variable Name</h4>';
		$html = $html . '<input type="text" id="form-bind-'.$ctr.'" value="'.$form[2].'">';
		$html = $html . '</div></li>';

    	break;

    	case 'divider';

    	$html = $html . '<li data-type="divider" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		$html = $html . 'Divider: <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		$html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		$html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		$html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		$html = $html . '<h4 id="title-'.$ctr.'">Divider Label</h4>';
		$html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
		$html = $html . '</div></li>';

    	break;

    	case 'states';

    	$html = $html . '<li data-type="states" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		$html = $html . 'States: <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		$html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		$html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		$html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		$html = $html . '<h4 id="title-'.$ctr.'">States Label</h4>';
		$html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
		$html = $html . '<h4>Variable Name</h4>';
		$html = $html . '<input type="text" id="form-bind-'.$ctr.'" value="'.$form[2].'">';
		$html = $html . '</div></li>';

    	break;

    	case 'drop';

    	  $html = $html . '<li data-type="drop" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		  $html = $html . 'Drop Down: <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		  $html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		  $html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		  $html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		  $html = $html . '<h4 id="title-'.$ctr.'">Drop Down Label</h4>';
		  $html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
		  $html = $html . '<h4>Options</h4>';
		  $html = $html . '<div class="options-container">';
		  $html = $html . '<ul id="drop-dop-coptions" class="option-con-'.$ctr.'">';
		  $options = explode(",", $form[3]);
          $dd = 0;
		  foreach ($options as $option) {
		  	if ($dd == 0) { 
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="add-option" data-dropdown="'.$ctr.'">+</span></li>';
		  	} else {
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="remove-option" data-dropdown="'.$ctr.'">-</span></li>';
		  	}
		   	$dd++;
		  } 
		  $html = $html . '</ul>';
		  $html = $html . '</div>';
		  $html = $html . '<h4>Variable Name</h4>';
		  $html = $html . '<input type="text" id="form-bind-'.$ctr.'" value="'.$form[2].'">';
		  $html = $html . '</div></li>';

    	break;

    	case 'check';

    	  $html = $html . '<li data-type="check" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		  $html = $html . 'Check Box(s): <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		  $html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		  $html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		  $html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		  $html = $html . '<h4 id="title-'.$ctr.'">Check Box(s) Label</h4>';
		  $html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
	  	  $html = $html . '<h4>Options</h4>';
		  $html = $html . '<div class="options-container">';
		  $html = $html . '<ul id="drop-dop-coptions" class="option-con-'.$ctr.'">';
		  $options = explode(",", $form[3]);
          $dd = 0;
		  foreach ($options as $option) {
		  	if ($dd == 0) { 
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="add-option" data-dropdown="'.$ctr.'">+</span></li>';
		  	} else {
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="remove-option" data-dropdown="'.$ctr.'">-</span></li>';
		  	}
		   	$dd++;
		  } 
		  $html = $html . '</ul>';
		  $html = $html . '</div>';
		  $html = $html . '<h4>Variable Name</h4>';
		  $html = $html . '<input type="text" id="form-bind-'.$ctr.'" value="'.$form[2].'">';
		  $html = $html . '</div></li>';

    	break;

    	case 'radio';

	      $html = $html . '<li data-type="radio" id="form-element-'.$ctr.'" data-formel="'.$ctr.'">';
		  $html = $html . 'Radio: <span class="label-title" id="elheader-'.$ctr.'">'.$form[1].'</span>';
		  $html = $html . '<img src="./assets/images/trash.gif" class="trash" data-element="'.$ctr.'">';
		  $html = $html . '<img src="./assets/images/edit.png" class="properties" data-element="'.$ctr.'">';
		  $html = $html . '<div class="edit-properties-'.$ctr.' hidden props">';
		  $html = $html . '<h4 id="title-'.$ctr.'">Radio Label</h4>';
		  $html = $html . '<input type="text" id="form-title-'.$ctr.'" class="form-label" data-label="'.$ctr.'" value="'.$form[1].'">';
		  $html = $html . '<h4>Options</h4>';
		  $html = $html . '<div class="options-container">';
		  $html = $html . '<ul id="drop-dop-coptions" class="option-con-'.$ctr.'">';
		  $options = explode(",", $form[3]);
          $dd = 0;
		  foreach ($options as $option) {
		  	if ($dd == 0) { 
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="add-option" data-dropdown="'.$ctr.'">+</span></li>';
		  	} else {
		  		$html = $html . '<li class="option"><input type="text" value="'.$option.'"><span class="remove-option" data-dropdown="'.$ctr.'">-</span></li>';
		  	}
		   	$dd++;
		  } 
		  $html = $html . '</ul>';
		  $html = $html . '</div>';
		  $html = $html . '<h4>Variable Name</h4>';
		  $html = $html . '<input type="text" id="form-bind-'.$ctr.'" value="'.$form[2].'">';
		  $html = $html . '</div></li>';

    	break;


    	}

     $ctr++;	
    
    }

    $err = json_encode(array('eles' => $ctr, 'formname'=> $name, 'html' => $html ));

	break;

}

echo $err;

?>
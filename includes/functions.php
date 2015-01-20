<?php

/*
*
* Display Tabs in Navigation
*
*/


function generate_tabs($tab_titles) {

	foreach ($tab_titles as $title) {
		echo "<li>".$title."</li>" . PHP_EOL;
	}
}

/*
*
* Display Tabs
*
*/

function generate_tabcontent($tab_content, $content) {

	$ctr = 0;
	foreach ($tab_content as $tab) {

		if ($ctr === 0) { $class=""; } else { $class="hidden"; }
			echo '<div class="tab '.$class.'">' . PHP_EOL;
			echo '<h2>'.$content[$tab]['title'].'</h2>' .PHP_EOL;
			echo filter_content($content[$tab]['copy']) .PHP_EOL;
			echo '</div>' . PHP_EOL;
			$ctr++;
		}	
}

function filter_content($content) {

	$content = str_replace('[agentName]', '<span class="insertedVariable">'.$GLOBALS["agentname"].'</span>', $content);

		while (strpos($content, '[form id="')) {
			$start = strpos($content, '[form id="')+10;
			$end = strpos($content, '"', $start);
			$id = substr($content, $start, ($end-$start));
			$form = build_form($id);
			$content = str_replace('[form id="'.$id.'"]', $form, $content);
		}

	return $content;

}

function build_form($id) {

	global $forms;

	$form = '<div class="form">' . PHP_EOL;

	$form = $form . '<form><input type="hidden" value="'.$forms[$id]['title'].'">';

	$formarray = json_decode($forms[$id]['code']);
     
	foreach ($formarray as $element) {

			if($element[0] !='divider') { $form = $form . '<p><label for="'.$element[2].'">'.$element[1].'</label>' . PHP_EOL; } else { $form =$form . '<p>'; }
	
		switch ($element[0]) {
			case 'text':

				$form = $form . '<input type="text" id="'.$element[2].'" name="'.$element[2].'">' . PHP_EOL;
				
				break;
			
			case 'drop':

				$form = $form . '<select name="'.$element[2].'" id="'.$element[2].'">' . PHP_EOL;

				$options = explode(",", $element[3]);
				foreach ($options as $option) {
					
					$form = $form . '<option>' . $option . '</option>';
				}

				$form = $form . '</select>' . PHP_EOL;

				break;

			case 'check':

				$options = explode(",", $element[3]);

				$form = $form . '<div class="checkboxes">';

				foreach ($options as $option) {
					
				$form = $form . '<input type="checkbox" name="'.$option.'" id="'.$option.'" value="'.$option.'" class="checkbox"><label class="checkbox-label">'.$option.'</label>' . PHP_EOL;
					
				}

				$form = $form . '</div>';

				break;

			case 'radio':


				$options = explode(",", $element[3]);

				$form = $form . '<div class="checkboxes">';

				foreach ($options as $option) {
					
				$form = $form . '<input type="radio" name="'.$element[2].'" id="'.$option.'" value="'.$option.'" class="checkbox"><label class="checkbox-label">'.$option.'</label>' . PHP_EOL;
					
				}

				$form = $form . '</div>';

				break;

			case 'divider':

				$form = $form . '<h4>' . $element[1].'</h4>';

				break;

			case 'states':

				$form = $form . '
					<select name="'.$element[2].'">
						<option value="AL">Alabama</option>
						<option value="AK">Alaska</option>
						<option value="AZ">Arizona</option>
						<option value="AR">Arkansas</option>
						<option value="CA">California</option>
						<option value="CO">Colorado</option>
						<option value="CT">Connecticut</option>
						<option value="DE">Delaware</option>
						<option value="DC">District Of Columbia</option>
						<option value="FL">Florida</option>
						<option value="GA">Georgia</option>
						<option value="HI">Hawaii</option>
						<option value="ID">Idaho</option>
						<option value="IL">Illinois</option>
						<option value="IN">Indiana</option>
						<option value="IA">Iowa</option>
						<option value="KS">Kansas</option>
						<option value="KY">Kentucky</option>
						<option value="LA">Louisiana</option>
						<option value="ME">Maine</option>
						<option value="MD">Maryland</option>
						<option value="MA">Massachusetts</option>
						<option value="MI">Michigan</option>
						<option value="MN">Minnesota</option>
						<option value="MS">Mississippi</option>
						<option value="MO">Missouri</option>
						<option value="MT">Montana</option>
						<option value="NE">Nebraska</option>
						<option value="NV">Nevada</option>
						<option value="NH">New Hampshire</option>
						<option value="NJ">New Jersey</option>
						<option value="NM">New Mexico</option>
						<option value="NY">New York</option>
						<option value="NC">North Carolina</option>
						<option value="ND">North Dakota</option>
						<option value="OH">Ohio</option>
						<option value="OK">Oklahoma</option>
						<option value="OR">Oregon</option>
						<option value="PA">Pennsylvania</option>
						<option value="RI">Rhode Island</option>
						<option value="SC">South Carolina</option>
						<option value="SD">South Dakota</option>
						<option value="TN">Tennessee</option>
						<option value="TX">Texas</option>
						<option value="UT">Utah</option>
						<option value="VT">Vermont</option>
						<option value="VA">Virginia</option>
						<option value="WA">Washington</option>
						<option value="WV">West Virginia</option>
						<option value="WI">Wisconsin</option>
						<option value="WY">Wyoming</option>
					</select>';	


		}
      $form = $form . "</p>" . PHP_EOL;
	}

	$form = $form . '</form></div>' . PHP_EOL;

    return $form;


}



?>
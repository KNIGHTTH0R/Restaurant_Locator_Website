<?php
//dynamicly generate check box group
$choices =array('FastFood', 'Western', 'Chinese', 'Buffet', 'Expensive', 'Cheap');// array of 7 types keywords
foreach ($choices as $key) {
	if (isset($_POST[$key])){// if is posted, means fail the validation, create box, and check it 
	echo '<input type="checkbox" id="'.strtolower($key).'" name="'.$key.'" value="'.$key.'" checked/>';
	}else{// create box
		echo '<input type="checkbox" id="'.strtolower($key).'" name="'.$key.'" value="'.$key.'" />';
	}
	echo '<label for="'.strtolower($key).'">'.$key.'</label>';// make label
	if ($key =='Buffet'){
		echo '<br/>';//separate line
	}
}

?>
<?php
	
	// Grabbing the variable being sent from the home page
	$getpage = $_POST['page'];

	$result = array(

		'home' => 'Welcome to Petshop demo home page',
		'details' => 'We live in the city of Adelaide',
		'shop' => 'Dogs = $100<br>Cats = $35<br>Brids = $15'

		);

	$color = array(

		'home' => 'yellow', 
		'details' => 'red', 
		'shop' => 'green'

		);
 

// checking if document was requesting through POST function
if($_POST){
	
	
	if($getpage == 'home'){
		
		echo json_encode(array('content' => $result['home'], 'color' => $color['home'] ));
		
	}elseif($getpage == 'details'){
		
		echo json_encode(array('content' => $result['details'], 'color' => $color['details'] ));
		
	}elseif($getpage == 'shop'){
		
		echo json_encode(array('content' => $result['shop'], 'color' => $color['shop'] ));
		
	};
	
};


?>
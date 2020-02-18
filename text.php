<?php

$set = empty( $me ) ? $me : '';

if( empty( $me ) ) {
	$set = $me;

} else{
	$set = '';
}

$action = 'edit';

switch($action) {
	case 'edit' :
		break;
	case 'delete' :
		break;
	case 'add' :
		break;
}

class Query() {
	$public $name='';
	__construct() {
		this->name = 'Bryan';
	}
	public function change_name( $name ) {
		this->name = $name;
	}
	private function my_private() {
		this->my_private();	
	}
}
$name = new Query(  );
echo $name;

$new_name = $name->change_name( 'emy' );
echo $name;

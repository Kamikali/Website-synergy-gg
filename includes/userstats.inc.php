<?php

//SELECTS THE COLOR FOR THE USERICONS
function selectColour($role){
 switch ($role) {
case 'Newfag':
	return "#ff00ea";
	break;

case 'Synner':
	return "#35b5ff";
	break;

case 'Administrator':
	return "#ccff00";
	break;

case 'Moderator':
	return "#45db00";
	break;

case 'Yasuo Player':
	return "#ad5a06";
	break;

case 'banned':
	return "#414141";
	break;
	
default:
	return "#ff2100";
	break;
	}
}
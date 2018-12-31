<?php 
/**
 * @DateOfCreation         23 August 2018
 * @ShortDescription       Return the Html according to the status provided from view
 * @return                 Response
 */
function showStatus($status)
{	
	$val = '';
	switch ($status) {
		case '1':
		$val = "<p style='color:green'>Active</p>";
		break;
		case '0':
		$val = "<p style='color:red'>Inactive</p>";
		break;	
	}
	return $val;
}
?>
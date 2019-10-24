<?php
session_start();
include('InfoSystem.php');

$iC = $_POST['iC'];
$arg1 = $_POST['arg1'];
$arg2 = $_POST['arg2'];
$arg3 = $_POST['arg3'];
$arg4 = $_POST['arg4'];


$objInfoSystem = new InfoSystem();
switch($iC)
{
	case 1:
        $strR = $objInfoSystem->setGroupPeopleById($arg1,$arg2, $arg3, $arg4);
    	echo($strR);
        break;
    case 2:
        $strR = $objInfoSystem->getGroupPeopleById($arg1);
    	echo($strR);
        break;
	case 3:
        $strR = $objInfoSystem->getPeopleById($arg1);
    	echo($strR);
        break;
	case 4:
        $strR = $objInfoSystem->updateGroupPeopleById($arg1,$arg2, $arg3, $arg4);
    	echo($strR);
        break;
	case 5:
		$strR = $objInfoSystem->setGroupPeopleMatrixById($arg1,$arg2, $arg3, $arg4);
		echo($strR);
        break;
	case 6:
		$strR = $objInfoSystem->getPeopleMatrixById($arg1);
		echo($strR);
        break;
	
    default:
        break;
}
?>
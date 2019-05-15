<?php


function unique_string($length = 16) 
{
	$x = '1234567890qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    $y =  substr(str_shuffle(str_repeat($x, ceil($length/strlen($x)) )),1,$length);
    $z = time();
    return $z.'-'.$y;
}


function penaltyCalculator($due, $return, $rate)
{

	// convert the due to time
	$x = date('Y-m-d', $due);
	$x = stringToTime($x);

	// convert the return to time
	$y = date('Y-m-d', $return+86400);
	$y = stringToTime($y);

	$z = $y - $x;

	$a = $z / 86400;


	return $b = "P ".round($a * $rate);

}

function unique_int($length = 5)
{
	$x = '1234567890';
    $y =  substr(str_shuffle(str_repeat($x, ceil($length/strlen($x)) )),1,$length);
    return $y;
}

function mustReturn($days, $start)
{
	$x = (int)$days * 86400;
    $y = (int)$start + $x;

    return date('F d, Y', $y);
}



function stringToTime($date)
{

    $real = explode('-', $date);

    $real2 = $real[2]."-".$real[1]."-".$real[0];

    return strtotime($real2);
}

function getDays($claimed, $must)
{
	$x = date('Y-m-d', $claimed);
	$y = stringToTime($x);

	$y = (int)$must - (int)$y;

	return $z = round($y / 86400);
}

function statusDecoder($int)
{
	switch ($int) {
		case 0:
			$status = '<span class="badge badge-secondary">Cancelled</span>';
		break;

		case 1:
			$status = '<span class="badge badge-primary">Pending</span>';
		break;

		case 2:
			$status = '<span class="badge badge-success">Approved</span>';
		break;

		case 3:
			$status = '<span class="badge badge-info">Borrowed</span>';
		break;

		case 4:
			$status = '<span class="badge badge-success">Returned</span>';
		break;

		case 5:
			$status = 'Penalty started';
		break;

		case 6:
			$status = '<span class="badge badge-dark">Disapproved</span>';
		break;

		case 7:
			$status = '<span class="badge badge-warning">Cancelled by librarian</span>';
		break;

		case 8:
			$status = '<span class="badge badge-danger">Book lost</span>';
		break;
		
		default:
			$status = '<span class="badge badge-dark">Undefined</span>';
		break;
	}

	return $status;
}


?>
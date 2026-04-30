<?
#####################################################################
// ¼îÇÎÄ«Æ®ÀÇ ÇÊµå°¡ 4°³
// fields1 : code , f2 : °¹¼ö
$fields_num=10;

// Summmary FielsÁöÁ¤  Sf1Àº °¹¼öÇÕ°è Sf2´Â ´Ü°¡*°¹¼ö ÇÑ ÃÑ±Ý¾×
$Sf1=2;
$Sf2=3;
// ¼îÇÎÇ°¸ñ °¹¼ö
function totCount1()
{
	global $fields_num;
	global $session_cart1;

	if($session_cart1!="") {
		$tmpArray=split(";",$session_cart1);
		return count($tmpArray);
	} else return 0;
}
function getCart1($index,&$result)
{
	global $fields_num;
	global $session_cart1;
	global $Sf1;
	global $Sf2;

	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]="";
	$tmpArray=split(";",$session_cart1);
	$tmpArr=split(",",$tmpArray[$index-1]);
	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]=$tmpArr[$ci];
	$result[$ci]=Intval($tmpArr[$Sf1])*Intval($tmpArr[$Sf2]);
}


?>

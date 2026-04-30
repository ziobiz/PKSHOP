<?
#####################################################################
// 쇼핑카트의 필드가 4개
// fields1 : code , f2 : 갯수
$fields_num=10;

// Summmary Fiels지정  Sf1은 갯수합계 Sf2는 단가*갯수 한 총금액
$Sf1=2;
$Sf2=3;
// 쇼핑품목 갯수

function totCount()
{
	global $fields_num;
	global $session_cart;

	if($session_cart!="") {
		$tmpArray=split(";",$session_cart);
		return count($tmpArray);
	} else return 0;
}

// 선택된 쇼핑품목 갯수
function totCount_selected()
{
	global $fields_num;
	global $session_cart;
	global $session_cart_selected;

	if($session_cart_selected!="") {
		$tmpArray=split(";",$session_cart_selected);
		return count($tmpArray);
	} else return 0;
}


// 품목 추가
// input 값은 array로 해당필드 순서대로 넘겨줘야함
// getCart하여 기존데이타로 체운후 변경필드만 반영 넘겨줌
function addCart($cartval)
{
	global $fields_num;
	global $session_cart;
	

	$tmpStr="";

	$tmp_chk = substr_count("$session_cart","$cartval[0]");

	//if ($tmp_chk<1) {
		for($ci=0;$ci<$fields_num;$ci++) {
			$tmpStr .= $cartval[$ci];
			if($ci != ($fields_num-1)) $tmpStr .= ",";
		}

		if(!$session_cart) {
			if(!$session_cart)
				echo "세션등록에 실패하였습니다.<br>";
		}
		if($session_cart=="") $session_cart = $tmpStr;
		else $session_cart .= ";". $tmpStr;
	//}	
}

// 품목이 있는지 확인
function comfirmCart($key)
{
	global $fields_num;
	global $session_cart;
	$tmp_chk = substr_count("$session_cart","$key");
	if ($tmp_chk<1) {
		return("Y");
	}

}

// 첫번째 필드에서 해당 값으로 찾음
function getCartByName($name,&$result)
{
	global $fields_num;
	global $session_cart;
	

	$tmpArray=split(";",$session_cart);

	for($ci=0;$ci<count($tmpArray);$ci++) {
		$tmpArr=split(",",$tmpArray[$ci]);
		if($tmpArr[0]==$name) {
			for($cj=0;$cj<$fields_num;$cj++) 
				$result[$cj]=$tmpArr[$cj];
			break;
		}
	}
}
// n번째 품목을 가져옴 
// 해당번째 자료를 result array에 넣어줌
// 필드정의 순서대로 result[0~x]로 넣어주고 마지막에 추가로 
// result[x+1]에 해당품목 신청갯수*단가 한 금액을 넣어줌
function getCart($index,&$result)
{
	global $fields_num;
	global $session_cart;
	global $Sf1;
	global $Sf2;

	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]="";
	$tmpArray=split(";",$session_cart);
	$tmpArr=split(",",$tmpArray[$index]);
	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]=$tmpArr[$ci];
	$result[$ci]=Intval($tmpArr[$Sf1])*Intval($tmpArr[$Sf2]);
}


// n번째 품목을 가져옴 
// 해당번째 자료를 result array에 넣어줌
// 필드정의 순서대로 result[0~x]로 넣어주고 마지막에 추가로 
// result[x+1]에 해당품목 신청갯수*단가 한 금액을 넣어줌
function getCart_selected($index,&$result)
{
	global $fields_num;
	global $session_cart;
	global $session_cart_selected;
	global $Sf1;
	global $Sf2;

	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]="";
	$tmpArray=split(";",$session_cart_selected);
	$tmpArr=split(",",$tmpArray[$index]);
	for($ci=0;$ci<$fields_num;$ci++)
		$result[$ci]=$tmpArr[$ci];
	$result[$ci]=Intval($tmpArr[$Sf1])*Intval($tmpArr[$Sf2]);
}


// n번째 품목을 변경
function modCart($index,$result)
{
	global $fields_num;
	global $session_cart;

	$tmpArray=split(";",$session_cart);
	$session_cart="";
	$tmpCnt=count($tmpArray);
	for($ci=0;$ci<$tmpCnt;$ci++) {
		if($ci==$index) {
			for($cj=0;$cj<$fields_num;$cj++) {
				$tmpStr .= $result[$cj];
				if($cj != ($fields_num-1)) $tmpStr .= ",";
			}
			$session_cart .= $tmpStr;
			if($ci != ($tmpCnt-1)) $session_cart .= ";";
		} else {
			$session_cart .= $tmpArray[$ci];
			if($ci != ($tmpCnt-1)) $session_cart .= ";";
		}
	}
}
function modifyCart($index,$amount,$size,$color,$back,$option1,$option2,$option3,$option4,$option5)
{
	global $fields_num;
	global $session_cart;

	$tmpArray=split(";",$session_cart);
	$session_cart="";
	$tmpCnt=count($tmpArray);

	for($ci=0;$ci<$tmpCnt;$ci++) {
		if($ci==$index) {
			$tmp_modify = $tmpArray[$ci];
			$tmp_modify=split(",",$tmp_modify);
			$tmpStr .= $tmp_modify[0].",".$amount.",".$size.",".$color.",".$back.",".$option1.",".$option2.",".$option3.",".$option4.",".$option5;
			$session_cart .= $tmpStr;
			if($ci != ($tmpCnt-1)) $session_cart .= ";";
		} else {
			$session_cart .= $tmpArray[$ci];
			if($ci != ($tmpCnt-1)) $session_cart .= ";";
		}
	}
}
// n번째 품목을 제거
function delCart($index)
{
	global $fields_num;
	global $session_cart;


	$tmpArray=split(";",$session_cart);

	$session_cart="";
	$tmpCnt=count($tmpArray);
	
	for($ci=0;$ci<$tmpCnt;$ci++) {
		if($ci!=$index) {
			$session_cart .= $tmpArray[$ci] . ";";
		}

	}
	$session_cart=substr($session_cart,0,strlen($session_cart)-1);
}


// n번째 품목을 제거후 $session_cart_selected에 저장
function delCart_selected($index)
{
	global $fields_num;
	global $session_cart;
	global $session_cart_selected;

	$tmpArray=explode(";",$session_cart);

	$tmpCnt=count($tmpArray);
	for($ci=0;$ci<$tmpCnt;$ci++) {
		if($ci==$index) {
			$session_cart_selected .= $tmpArray[$ci] . ";";
		}
	}
}


// 합산 총 2개 필드만 합산가능 $Sf1, $Sf2로 지정
// 결과값은 result array로 result[0]는 총신청갯수 result[1]은 총액수 
function sumCart(&$result)
{
	global $fields_num;
	global $session_cart;
	global $Sf1;
	global $Sf2;

	$tmpArray=split(";",$session_cart);
	$tmpCnt=count($tmpArray);
	$ret=0;
	$result[0]=0;
	$result[1]=0;
	for($ci=0;$ci<$tmpCnt;$ci++) {
		$tmpArr=split(",",$tmpArray[$ci]);	
		$result[0] += Intval($tmpArr[$Sf1]);
		$result[1] += ( Intval($tmpArr[$Sf1]) * Intval($tmpArr[$Sf2]) );
	}
}
function sortCart($ord)
{
	global $fields_num;
	global $session_cart;

	$tmpArray=split(";",$session_cart);
	if($ord=="1") sort($tmpArray);
	else rsort($tmpArray);
	$tmpNew = "";
	$tmpCnt=count($tmpArray);
	for($ci=0;$ci<$tmpCnt;$ci++) {
		$tmpNew .= $tmpArray[$ci].";";
	}
	$session_cart=substr($tmpNew,0,strlen($session_cart)-1);
}
?>

<?
	function phpStringCut($str,$scut,$yes)
	{
		if($yes == ""){$yes = 0;}
		$length=1;
		$i=0;
		$str_result = "";
		while($str)
		{
			preg_match('/^([\xa1-\xfe]{2}|.){'.$length.'}/s', $str, $cstr);
			$str = substr($str,strlen($cstr[0]));
			$str_array[$i] = $cstr[0];
			$i++;
		}
		if($i <= $scut)
		{
			for($j=0;$j<$i;$j++)
			{
				$str_result .= $str_array[$j];
			}
			return $str_result;
		}
		else
		{
			if($yes == 1)
			{
				for($j=0;$j<$scut;$j++)
				{
					$str_result .= $str_array[$j];
				}
				return $str_result;		
			}
			else
			{
				for($j=0;$j<$scut;$j++)
				{
					$str_result .= $str_array[$j];
				}
				return $str_result."..";
			}
		}
	}
	function stringCut($str,$len)
	{
		preg_match('/([\x00-\x7e]|..)*/', substr($str, 0, $len), $rtn); 
		if ( $len < strlen($str) ) $rtn[0].="..."; 
		return $rtn[0]; 
	}
	/* 엔터및 기타 특수문자제거 */
/*	function phpDbToHtml($str)
	{
		$str = str_replace("\r\n","<br>",$str);
		$str = str_replace("&#09;","&nbsp;",$str);
		//$str = htmlspecialchars($str);
		return $str;
	}*/
	function addSlashDelHtml($str)
	{
		$str = htmlspecialchars(addslashes($str));
		$str = str_replace("\r\n","&nbsp;",$str);
		$str = str_replace("&#09;","&nbsp;",$str);
		return $str;
	}
	function addSlash($str)
	{
		$str = addslashes($str);
		return $str;
	}
	function delSlash($str)
	{
		$str = stripslashes($str);
		return $str;
	}
	/* 자바스크립트시 공백 문자열 제거 */
	function phpWhiteSpaceCut($str)
	{
		if(!$str == "")
		{
			$strTrim = trim($str);
			$str1 = explode(" ",$strTrim);
			$strExplode = "";
			if(count($str1) <= 1)
			{
				return $strExplode = $str1[0];
			}
			else
			{
				for($i=0;$i<count($str1);$i++)
				{
					$strExplode .= $str1[$i];
				}
				return $strExplode; 
			}
		}
	}
	//메세지 띄울시
	function msg($msg)
	{
		$msg = addslashes($msg);
		print "<script language='javascript'>alert(\"$msg\")</script>";
	}
	function msg_js($msg,$js)
	{
		msg($msg);js($js);
	}
	//자바스크립트 쓸때
	function js($js)
	{
		print "<script language='javascript'>$js</script>";
	}
	//해당문자부터 끝까지 자르기//
	//$str : 문자열;
	//$string : 찾을 문자열
	function phpSubStr($str,$string)
	{
		$strChar = strrchr($str,$string);
		return substr($strChar,1,strlen($strChar)-1);
	}
	//쿼리 성공시나 페이지 이동시
	function jumpUrl($url)
	{
		print "<script language='javascript'>location.replace('$url')</script>";
	}
	//리플레시
	function reFresh($url)
	{
		print "<meta http-equiv='Refresh' content='0; URL=$url'>";
	}
	//창닫기
	function winClose()
	{
		print "<script language='javascript'>window.close()</script>";
	}
	function pointCut($value,$size)
	{
		//$cut 는 100요렇게해서 곱할려고
		$cut = "1";
		for($i = 1;$i <= $size;$i++)
		{
			$cut.="0";
		}
		$value = floor($value);
		return $value = floor($value * (1/$cut)) * $cut;
	}

	//3자리마다 "," 찍기
	function threeComma($value)
	{
		$vlen = strlen($value);
		$vstr = "";
		$num = $vlen;
		for($i = 1;$i <= $vlen;$i++)
		{
			if($num%3 == 0)
			{
				$vstr .= ",".substr($value,$i-1,1);
			}
			else
			{
				$vstr .= substr($value,$i-1,1);
			}
			$num--;
		}
		if(substr($vstr,0,1) == ",")
		{
			$newlen = strlen($vstr);
			return substr($vstr,1,$newlen);
		}
		else
		{
			return $vstr;
		}
	}
//해당자리수마다 해당하는 기호 넣기 $value:값;$cnum:몇자리수마다;$sign:어떤기호인가
	function timesSign($value,$cnum,$sign)
	{
		$vlen = strlen($value);
		$vstr = "";
		$num = $vlen;
		for($i = 1;$i <= $vlen;$i++)
		{
			if($num%$cnum == 0)
			{
				$vstr .= $sign.substr($value,$i-1,1);
			}
			else
			{
				$vstr .= substr($value,$i-1,1);
			}
			$num--;
		}
		if(substr($vstr,0,1) == $sign)
		{
			$newlen = strlen($vstr);
			return substr($vstr,1,$newlen);
		}
		else
		{
			return $vstr;
		}
	}

	function pagingModify($total,$scale,$start,$page,$page_scale,$url)
	{
		echo("<table cellpadding='0' cellspacing='0'><tr><td>");
		if($total > $scale)
		{
			if ($start+1 > $scale*$page_scale)
			{
				$pre_start=($page-1)*$scale*$page_scale;
				echo("<a href='$_SERVER[PHP_SELF]?start=$pre_start&$url'><img src='../lib/img/prev.gif' border='0'></a>&nbsp;&nbsp;");
			}
			else
			{
				//echo("<img src='/phpFunction/images/center_04.gif'>&nbsp;&nbsp;");
			}
		}
		if ($start == 0 || $start == null)
		{
			//echo("<img src='/phpFunction/images/center_04.gif'>&nbsp;&nbsp;");
		}
		//vj는 여기서 페이지단위 뿌릴때 사용하는 변수 10개를 뿌린다....
		echo("</td><td>");
		for($vj=0; $vj<$page_scale ; $vj++)
		{
			$ln=($page*$page_scale+$vj)*$scale;
			$page_num=$page*$page_scale+$vj+1;

			if($ln<$total)
			{
				if($ln!=$start)
				{
					echo("<a href='$_SERVER[PHP_SELF]?start=$ln&$url'>&nbsp;$page_num&nbsp;</a>");
				}
				else
				{
					echo("<b><span style='color:#FF0000'>$page_num</span></b>");//현재페이지
				}
			}
		}
		echo("</td><td></td><td>");
		if ($total>(($page+1)*$scale*$page_scale))
		{
			$n_start=($page+1)*$scale*$page_scale;			
			echo("&nbsp;&nbsp;<a href='$_SERVER[PHP_SELF]?start=$n_start&$url'><img src='../lib/img/next.gif' border='0'></a>");
		}
		else
		{
			//echo("</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src='/phpFunction/images/center_05.gif'>");
		}
		echo("</td></tr></table>");		
	}
	function imageSize($filepath,$iwidth,$iheight)//GD라이브러리를 설치했을때$iwidth,$iheight = 바꿀이미지 사이지
	{
		$max_width = $max_height = 0;//최종적 이미지

		$img_info = getimagesize($filepath);
		$img_width = $img_info[0];//가져온 파일의 이미지 정보
		$img_height = $img_info[1];//가져온 파일의 이미지 정보

		if($iheight < 1 || empty($iheight))//$iheight 값이 1보다 작거나 없을때 즉 iheight를 넣지 않을때
		{
			if($img_width <= $iwidth)//원본이미지 넓이가 작을때
			{
				if($img_height > $iheight)
				{
					$max_height = $iheight;
					$max_width = ceil(($img_width*$iheight)/$img_height);
				}
				else
				{
					$max_width = $img_width;
					$max_height = $img_height;
				}
			}
			else//원본이미지가 클떼
			{
				$max_width = $iwidth;
				$max_height = ceil(($img_height*$iwidth)/$img_width);
			}
		}
		else
		{
			if($img_width <= $iwidth)//원본이미지 넓이가 작을때
			{
				if($img_height > $iheight)
				{
					$max_height = $iheight;
					$max_width = ceil(($img_width*$iheight)/$img_height);
				}
				else
				{
					$max_width = $img_width;
					$max_height = $img_height;
				}
			}
			else//원본이미지 넓이가 클때
			{
				if($img_height <= $iheight)//원본이미지 높이가 작을때
				{
					$max_width = $iwidth;
					$max_height = ceil(($img_height*$iwidth)/$img_width);
				}
				else//원본이미지 높이가 클때
				{
					if($img_height > $img_width)//원본이미지 높이가 원본이미지 넓이보다 클때
					{
						$max_height = $iheight;
						$max_width = ceil(($img_width*$iheight)/$img_height);
					}
					else//원본이미지 높이가 원본이미지 넓이보다 작으나 원본이미지 높이가 해당 높이보단 클때
					{
						$max_width = $iwidth;
						$max_height = ceil(($img_height*$iwidth)/$img_width);
					}
				}
			}
		}
		return $max_width.",".$max_height;
	}
	
	
	
function rand_code($nc) {
	$a='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
     $l=strlen($a)-1; $r='';
     while($nc-->0) $r.=$a{mt_rand(0,$l)};
     return $r;
 }
 
 function Get_lastmonth($month)
 {
 	$last_day = 0;
	
 	if ($month == "1")  $last_day = 31;
 	if ($month == "2")  $last_day = 29;
 	if ($month == "3")  $last_day = 31;
 	if ($month == "4")  $last_day = 30;
 	if ($month == "5")  $last_day = 31;
 	if ($month == "6")  $last_day = 30;
 	if ($month == "7")  $last_day = 31;
 	if ($month == "8")  $last_day = 31;
 	if ($month == "9")  $last_day = 30;
 	if ($month == "10")  $last_day = 31;
 	if ($month == "11")  $last_day = 30;
 	if ($month == "12")  $last_day = 31;
	
	return $last_day;
 }

	/*
	function Encrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return str_replace("=", "", base64_encode(
                 openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
    );
}


function Decrypt($str, $secret_key='secret key', $secret_iv='secret iv')
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return openssl_decrypt(
            base64_decode($str), "AES-256-CBC", $key, 0, $iv);
}

*/

	
?>
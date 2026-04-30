<?
	//$listamount:리스트총갯수,$pagelistcount:한페이지에 보여줄 리스트 갯수,$start:현재시작번호,$pagecount:페이지에 보여줄 페이지갯수
	
	//$start = empty($_GET[start])?$_POST[start]:$_GET[start];
	//$url = &fdfdf=dfdf
	function paging($listamount,$pagelistcount,$start,$pagecount,$url)
	{

		$totalpage = ceil($listamount/$pagelistcount);//전체페이지수
		//if ($rn%$pagelistcount == 0 && $totalpage!=1) // 10/20인경우 3이 되는 것을 막음$totalpage--; // 10/20인경우 3이 되는 것을 막음

		//$countpage = ceil($totalpage/$pagecount);
		if(empty($start) || $start < 1)$start = 1;

		$pageend = (ceil((($start*$pagecount)-(($pagecount-1)*$start))/$pagecount))*$pagecount;

		$pagestart = ($pageend-$pagecount)+1;

		if($pageend > $totalpage)
		{
			$pageend = $totalpage;
		}

		//if($pageend)

		$td = "<table><tr>";
		if($pagestart > 1)
		{
			$td .= "<td><a href='$_SERVER[PHP_SELF]?start=1$url' class='color-3'>&lt;&lt;</a></td>";
			$prvpagenum = $pagestart-$pagecount;
			$td .= "<td><a href='$_SERVER[PHP_SELF]?start=$prvpagenum$url'  class='color-3'>&lt;</a></td>";
		}
		
		for($i=$pagestart;$i<=$pageend;$i++)
		{
			if($start == $i)
			{
				$td .= "<td style='color:#FF3333'>&nbsp;<strong>$i</strong>&nbsp;</td>";
			}
			else
			{
				$td .= "<td>&nbsp;<a href='$_SERVER[PHP_SELF]?start=$i$url' class='color-f'>$i</a>&nbsp;</td>";
			}
		}
		if($pageend < $totalpage)
		{
			$nextpagenum = $pageend+1;
			$td .= "<td><a href='$_SERVER[PHP_SELF]?start=$nextpagenum$url' class='color-3'>&gt;</a></td>";
			$td .= "<td><a href='$_SERVER[PHP_SELF]?start=$totalpage$url' class='color-3'>&gt;&gt;</a></td>";
		}
		$td .= "</tr></table>";
		print $td;
	}
?>
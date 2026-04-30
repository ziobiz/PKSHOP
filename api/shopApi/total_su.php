<?

		
		$DB->single("select sum(sil) as total from $bonus_table  where c_code = :code ",$sus,$sun,array("code"=>$member_code),"key");


		$sql_su = "select  sum(sil) as total  from $bonus_table where c_code=:code and title_2='DB'";	
		$DB->single($sql_su, $totals_mon1,$totaln_mon1,array("code"=>$member_code),"key");
		$sql_su = "select  sum(sil) as total  from $bonus_table where c_code=:code and title_2='SB'";
		$DB->single($sql_su, $totals_mon2,$totaln_mon2,array("code"=>$member_code),"key");
		$sql_su = "select  sum(sil) as total  from $bonus_table where c_code=:code and title_2='MB'";
		$DB->single($sql_su, $totals_mon3,$totaln_mon3,array("code"=>$member_code),"key");
		$sql_su = "select  sum(sil) as total  from $bonus_table where c_code=:code and title_2='ROL'";
		$DB->single($sql_su, $totals_mon4,$totaln_mon4,array("code"=>$member_code),"key");
		$sql_su = "select  sum(sil) as total  from $bonus_table where c_code=:code and title_2='RANK'";
		$DB->single($sql_su, $totals_mon5,$totaln_mon5,array("code"=>$member_code),"key");
		


		$DB->single("select sum(c_cash) as total,sum(c_bit) as btotal,sum(c_pv) as pv from $sell_table  where c_code = :code and (c_state <>'shop' and c_state <> 'resell' ) ",$sells,$selln,array("code"=>$member_code),"key");

		

		
		$DB->single("select sum(c_amount) as total from $with_list  where c_code = :code  and c_state!='Cancel'",$withs,$withnHCBRS,array("code"=>$member_code),"key");
	
		$DB->single("select sum(qty) as total from shop_order  where id = :member_id and onlyP>0 and (status != '주문취소' and status != '주문자취소' and status != '반송' and status != '반품' and status != '주문대기' and status != '취소')  ",$ssss,$sssn,array("member_id"=>$member_id),"key");


		$DB->single("select sum(emoney) as total from p2p  where send_code = :code  and c_state ='Complete'",$p2ps,$p2pn,array("code"=>$member_code),"key");
		$DB->single("select sum(emoney) as total from p2p  where receive_code = :code  and c_state ='Complete'",$p2ps2,$p2pn2,array("code"=>$member_code),"key");
		
	

		// HCBRS 총합

		$total_DB = number_format($totals_mon1["total"],2);
		$total_SB = number_format($totals_mon2["total"],2);
		$total_MB = number_format($totals_mon3["total"],2);
		$total_ROL  = number_format($totals_mon4["total"],2);
		$total_RANK  =  number_format($totals_mon5["total"],2);
		
		$sell_pv = $sells["pv"];


		
		

		// 수당총합
		$su_total		= $sus['total']-$withs["total"]-$ssss["total"]-$p2ps["total"]+$p2ps2["total"];
		$su300=$sus['total'];
		$with300=$withs['total'];
		// 사용가능수당
		$emoney			= floor($su_total*10000)/10000;

	
		$kemoney=$emoney;

		
		
		// 볼륨
		$my_volume		= $sells['total'] ;

?>	
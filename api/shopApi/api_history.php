<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	$Type	= $_POST['Type'];
	$deId	= $_POST['deId'];
	$user_id= $_POST['userid'];
	$btype	= $_POST['btype'];



	
	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		
		// echo 
		$DB->get("select * from $member_table where c_id=:user_id", $custs, $custn,array("user_id"=>$user_id));
		$member_code = $custs[0]['c_code'];


		$data_list = array();


		if ($Type == "cartegory")
		{
			$k = 0;
			$sql = "SELECT code1,cate1,show1 FROM $shop_cate where code2='00' and code3='00' and code4='00' order by order_rank";
			
			$DB->get($sql, $cartes, $carten);
			for($i=0;$i<$carten;$i++)
			{	
				if($cartes[$i]["show1"]==1){
					continue;
				}
				$data_list[$k]=array("code"=>$cartes[$i]['code1'],"cate"=>$cartes[$i]['cate1']);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}
		else if ($Type == "goodsView")
		{
			$k = 0;
			$code = $_POST["code"];
			$sql = "SELECT title,info,pricec,prices,priced,point,size,color,currnum,detail,company,feature,soldout,relation,price_dis,imgm,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,home,event_str,imgb1,imgb2,country,imgb3,imgb4,imgb5,coin,c_pv,onlypoint,code1,code2,onlypoint FROM $shop_goods WHERE code=:code";
			
			
			$DB->get($sql, $cartes, $carten,array("code"=>$code));
			for($i=0;$i<$carten;$i++)
			{	

				$sql = "SELECT * FROM $shop_cate where code1='".$cartes[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$cartes[$i]["code1"]."' and  code2='".$cartes[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}


				$data_list[$k]=$cartes[$i];
				$k++;
			}

	
			echo json_encode($data_list);
		
		}

		else if ($Type == "best")
		{
			$k = 0;
			$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2,country,c_pv,onlypoint FROM shop_goods where theme_r = 'r' and soldout='N' ORDER BY order1,signdate desc";
			
			// echo $sql;

			$DB->get($sql, $bests, $bestn);
			for($i=0;$i<$bestn;$i++)
			{	

				$sql = "SELECT * FROM $shop_cate where code1='".$bests[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$bests[$i]["code1"]."' and  code2='".$bests[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}

				$data_list[$k]=array("code2"=>$bests[$i]['code2'],"code3"=>$bests[$i]['code3'],"code"=>$bests[$i]['code'],"title"=>$bests[$i]['title'],"pricec"=>$bests[$i]['pricec'],"prices"=>$bests[$i]['prices'],"priced"=>$bests[$i]['priced'],"company"=>$bests[$i]['company'],"new"=>$bests[$i]['new'],"soldout"=>$bests[$i]['soldout'],"best"=>$bests[$i]['best'],"cut"=>$bests[$i]['cut'],"recommend"=>$bests[$i]['recommend'],"price_dis"=>$bests[$i]['price_dis'],"size"=>$bests[$i]['size'],"color"=>$bests[$i]['color'],"imgl"=>$bests[$i]['imgl'],"code4"=>$bests[$i]['code4'],"opt_num"=>$bests[$i]['opt_num'],"imgb1"=>$bests[$i]['imgb1'],"imgb2"=>$bests[$i]['imgb2'],"country"=>$bests[$i]['country'],"c_pv"=>$bests[$i]['c_pv'],"onlypoint"=>$bests[$i]["onlypoint"]);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}
		else if ($Type == "new")
		{
			$k = 0;
			$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2,country,c_pv,onlypoint FROM shop_goods where theme_n = 'n' and soldout='N' ORDER BY signdate desc ";
			
			//echo $sql;

			$DB->get($sql, $news, $newn);
			for($i=0;$i<$newn;$i++)
			{	

				$sql = "SELECT * FROM $shop_cate where code1='".$news[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$news[$i]["code1"]."' and  code2='".$news[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}
				$data_list[$k]=array("code2"=>$news[$i]['code2'],"code3"=>$news[$i]['code3'],"code"=>$news[$i]['code'],"title"=>$news[$i]['title'],"pricec"=>$news[$i]['pricec'],"prices"=>$news[$i]['prices'],"priced"=>$news[$i]['priced'],"company"=>$news[$i]['company'],"new"=>$news[$i]['new'],"soldout"=>$news[$i]['soldout'],"best"=>$news[$i]['best'],"cut"=>$news[$i]['cut'],"recommend"=>$news[$i]['recommend'],"price_dis"=>$news[$i]['price_dis'],"size"=>$news[$i]['size'],"color"=>$news[$i]['color'],"imgl"=>$news[$i]['imgl'],"code4"=>$news[$i]['code4'],"opt_num"=>$news[$i]['opt_num'],"imgb1"=>$news[$i]['imgb1'],"imgb2"=>$news[$i]['imgb2'],"country"=>$news[$i]['country'],"c_pv"=>$news[$i]['c_pv'],"onlypoint"=>$news[$i]["onlypoint"]);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}
		else if ($Type == "all")
		{
			$k = 0;
			$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2,country,c_pv,onlypoint FROM shop_goods where  soldout='N' ORDER BY signdate desc limit 4";
			
			//echo $sql;

			$DB->get($sql, $news, $newn);
			for($i=0;$i<$newn;$i++)
			{	

				$sql = "SELECT * FROM $shop_cate where code1='".$news[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$news[$i]["code1"]."' and  code2='".$news[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}
				$data_list[$k]=array("code2"=>$news[$i]['code2'],"code3"=>$news[$i]['code3'],"code"=>$news[$i]['code'],"title"=>$news[$i]['title'],"pricec"=>$news[$i]['pricec'],"prices"=>$news[$i]['prices'],"priced"=>$news[$i]['priced'],"company"=>$news[$i]['company'],"new"=>$news[$i]['new'],"soldout"=>$news[$i]['soldout'],"best"=>$news[$i]['best'],"cut"=>$news[$i]['cut'],"recommend"=>$news[$i]['recommend'],"price_dis"=>$news[$i]['price_dis'],"size"=>$news[$i]['size'],"color"=>$news[$i]['color'],"imgl"=>$news[$i]['imgl'],"code4"=>$news[$i]['code4'],"opt_num"=>$news[$i]['opt_num'],"imgb1"=>$news[$i]['imgb1'],"imgb2"=>$news[$i]['imgb2'],"country"=>$news[$i]['country'],"c_pv"=>$news[$i]['c_pv'],"onlypoint"=>$news[$i]["onlypoint"]);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}

		else if ($Type == "all1")
		{
			$k = 0;
			$sql = "SELECT code1,cate1 FROM $shop_cate where code2='00' and code3='00' and code4='00' order by order_rank";
			$DB->get($sql, $all1s, $all1n);
			for($i=0;$i<$all1n;$i++)
			{	

				$data_list[$k]=array("code"=>$all1s[$i]['code1'],"cate"=>$all1s[$i]['cate1']);
				$k++;
			}

			echo json_encode($data_list);
		
		}

		
		else if ($Type == "all2")
		{
			$k = 0;
			$code1 = htmlspecialchars(addslashes($_POST['code1']));
			$sql = "SELECT code2,cate2,order_rank FROM $shop_cate where code1='".$code1."' and code2<>'00' and code3='00' and code4='00' order by order_rank";
			
			$DB->get($sql, $all1s, $all1n);
			
			if ($all1n > 0)
			{
				for($i_tm  = 0; $i_tm  < $all1n ; $i_tm ++) 
				{
					$menu_code2 = $all1s[$i_tm]['code2'];
					$menu_title2 = $all1s[$i_tm]['cate2'];
					$order_rank = $all1s[$i_tm]['order_rank'];
					$cc_code=$menu_code2;
					$cc_code = $menu_code123.$menu_code2;
					
					$data_list[$k]=array("code2"=>$menu_code2,"cate2"=>$menu_title2,"order_rank"=>$order_rank);

					
					$k++;
					
				}
				echo json_encode($data_list);

			}

			

			
		
		}
	
		else if ($Type == "all3")
		{
			$k = 0;
			$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4 ,opt_num,imgb1,imgb2,country,c_pv,onlypoint FROM $shop_goods where soldout='N' ORDER BY order1,signdate desc";

			//echo $sql;
		
			$DB->get($sql, $all1s, $all1n);
			for($i=0;$i<$all1n;$i++)
			{	
				$sql = "SELECT * FROM $shop_cate where code1='".$all1s[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$all1s[$i]["code1"]."' and  code2='".$all1s[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}
				$data_list[$k]=array("code2"=>$all1s[$i]['code2'],"code3"=>$all1s[$i]['code3'],"code"=>$all1s[$i]['code'],"title"=>$all1s[$i]['title'],"pricec"=>$all1s[$i]['pricec'],"prices"=>$all1s[$i]['prices'],"priced"=>$all1s[$i]['priced'],"company"=>$all1s[$i]['company'],"new"=>$all1s[$i]['new'],"soldout"=>$all1s[$i]['soldout'],"best"=>$all1s[$i]['best'],"cut"=>$all1s[$i]['cut'],"recommend"=>$all1s[$i]['recommend'],"price_dis"=>$all1s[$i]['price_dis'],"size"=>$all1s[$i]['size'],"color"=>$all1s[$i]['color'],"imgl"=>$all1s[$i]['imgl'],"code4"=>$all1s[$i]['code4'],"opt_num"=>$all1s[$i]['opt_num'],"imgb1"=>$all1s[$i]['imgb1'],"imgb2"=>$all1s[$i]['imgb2'],"country"=>$all1s[$i]['country'],"c_pv"=>$all1s[$i]['c_pv'],"onlypoint"=>$all1s[$i]["onlypoint"]);
				$k++;
			}

			echo json_encode($data_list);
		
		}


		else if ($Type == "wait")
		{
			$k = 0;
			$sql = "select ordernum, kind, charge, status,char_num from $shop_order where id = '$user_id' and status<>'주문대기' order by ordernum desc";

			$DB->get($sql, $all1s, $all1n);
				
			for($i=0;$i<$all1n;$i++)
			{	
				$ordernum	= $all1s[$i]['ordernum'];
				$kind		= $all1s[$i]['kind'];
				$charge		= $all1s[$i]['charge'];
				$status		= $all1s[$i]['status'];
				$char_num	= $all1s[$i]['char_num'];
				
				$sql = "SELECT ordernum,signdate, title, money , count , opt1,code, coin, prices FROM $shop_sell where ordernum = '$ordernum'";

				$DB->get($sql, $all2s, $all2n);
				for($i=0;$i<$all2n;$i++)
				{	

				$data_list[$k]=array("ordernum"=>$all2s[$i]['ordernum'],"signdate"=>$all2s[$i]['signdate'],"title"=>$all2s[$i]['title'],"money"=>$all2s[$i]['money'],"count"=>$all2s[$i]['count'],"opt1"=>$all2s[$i]['opt1'],"code"=>$all2s[$i]['code'],"coin"=>$all2s[$i]['coin'],"prices"=>$all2s[$i]['prices']);
				$k++;

				}
			}

			//echo json_encode($data_list);
		
		}
		else if ($Type == "cate1")
		{
			$k = 0;
			$sql = "SELECT code1,cate1 FROM $shop_cate where  code2='00' and code3='00' and code4='00' and code1='".$_POST['cate1']."' order by order_rank" ;
			


			$DB->get($sql, $all1s, $all1n);
			$i = 0;
			for($i=0;$i<$all1n;$i++)
			{	

				$data_list[$k]=array("code"=>$all1s[$i]['code1'],"cate"=>$all1s[$i]['cate1']);
			}

			echo json_encode($data_list);
		
		}

		else if ($Type == "cate2")
		{
			$k = 0;
			$cate1 = htmlspecialchars(addslashes($_POST['cate1']));
			$sql = "SELECT code2,cate2,order_rank FROM $shop_cate where code1='".$cate1."' and code2<>'00' and code3='00' and code4='00' order by order_rank" ;
			// echo $sql;

			$DB->get($sql, $all1s, $all1n);
			$i = 0;
			for($i=0;$i<$all1n;$i++)
			{	
				
				$data_list[$k]=array("code2"=>$all1s[$i]['code2'],"cate2"=>$all1s[$i]['cate2']);
				$k++;
			}

			echo json_encode($data_list);
		
		}
		else if ($Type == "cate33")
		{
			$k = 0;
			$cate1 = htmlspecialchars(addslashes($_POST['cate1']));
			$cate2 = htmlspecialchars(addslashes($_POST['cate2']));
			$sql = "SELECT code3,cate3,order_rank FROM $shop_cate where code1='".$cate1."' and code2='$cate2' and code3<>'00' and code4='00' order by order_rank" ;
			

			$DB->get($sql, $all1s, $all1n);
			$i = 0;
			for($i=0;$i<$all1n;$i++)
			{	
				
				$data_list[$k]=array("code3"=>$all1s[$i]['code3'],"cate3"=>$all1s[$i]['cate3']);
				$k++;
			}

			echo json_encode($data_list);
		
		}
	
		else if ($Type == "cate3")
		{
			$theme_str=htmlspecialchars(addslashes($_POST["theme_str"]));
			$query_dis=htmlspecialchars(addslashes($_POST["query_dis"]));
			$word=htmlspecialchars(addslashes($_POST["word"]));
			$cate1=htmlspecialchars(addslashes($_POST["cate1"]));
			$cate2=htmlspecialchars(addslashes($_POST["cate2"]));
			$cate3=htmlspecialchars(addslashes($_POST["cate3"]));
			$cate4=htmlspecialchars(addslashes($_POST["cate4"]));
			
			if($theme_str == "n") $kk_query = "and theme_n='n'";
			if($theme_str == "r") $kk_query = "and theme_r='r'";
			if($theme_str == "f") $kk_query = "and theme_f='f'";
			if($theme_str == "x") $kk_query = "and theme_x='x'";
			if($theme_str == "y") $kk_query = "and theme_y='y'";
			if($theme_str == "z") $kk_query = "and theme_z='z'";
			if($theme_str == "s") $kk_query = "and theme_s='s'";
		
			if($query_dis=="k_new"){
				$kk_query.="ORDER BY signdate desc";
			}else if($query_dis=="k_price"){
				$kk_query.="ORDER BY pricec ";
			}else if($query_dis=="k_price2"){
				$kk_query.="ORDER BY pricec desc";
			}else if($query_dis=="k_ga1"){
				$kk_query.="ORDER BY title";
			}else if($query_dis=="k_ga2"){
				$kk_query.="ORDER BY title desc";
			}else{
				$kk_query.="ORDER BY signdate desc";
			}

			if($word != ""){
				$where = " and title like '%$word%'";
			}
			if($cate1 != ""){
				$where.= " and code1 like '$cate1'";
			}
			if($cate2 != "" && $cate2 != "00"){
				$where.= " and code2 like '$cate2'";
			}
			if($cate3 != "" && $cate3 != "00"){
				$where.= " and code3 like '$cate3'";
			}
			if($cate4 != "" && $cate4 != "00"){
				$where.= " and code4 like '$cate4'";
			}
			
			$k = 0;
			if($theme_str == ""){
			$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb4,imgb2,country,c_pv,onlypoint FROM $shop_goods where  soldout='N' $where $kk_query" ;
			}else{
				$sql = "SELECT code1,code2, code3, code, title, pricec, prices, priced, company, new, soldout,best,cut,recommend,price_dis,size,color,imgl, code4,opt_num,imgb1,imgb2,country,c_pv,onlypoint FROM $shop_goods where soldout='N' $where $kk_query" ;
			}
			// echo $sql;
			$DB->get($sql, $all1s, $all1n);
			
			$k = 0;
			for($i=0;$i<$all1n;$i++)
			{	
				$sql = "SELECT * FROM $shop_cate where code1='".$all1s[$i]["code1"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show1"] == 1){
					continue;
				}
				$sql = "SELECT * FROM $shop_cate where code1='".$all1s[$i]["code1"]."' and  code2='".$all1s[$i]["code2"]."' ";
				$DB->get($sql, $cates, $caten);
				if($cates[0]["show2"] == 1){
					continue;
				}
				$data_list[$k]=array("code2"=>$all1s[$i]['code2'],"code3"=>$all1s[$i]['code3'],"code"=>$all1s[$i]['code'],"title"=>$all1s[$i]['title'],"pricec"=>$all1s[$i]['pricec'],"prices"=>$all1s[$i]['prices'],"priced"=>$all1s[$i]['priced'],"company"=>$all1s[$i]['company'],"new"=>$all1s[$i]['new'],"soldout"=>$all1s[$i]['soldout'],"best"=>$all1s[$i]['best'],"cut"=>$all1s[$i]['cut'],"recommend"=>$all1s[$i]['recommend'],"price_dis"=>$all1s[$i]['price_dis'],"size"=>$all1s[$i]['size'],"color"=>$all1s[$i]['color'],"imgl"=>$all1s[$i]['imgl'],"code4"=>$all1s[$i]['code4'],"opt_num"=>$all1s[$i]['opt_num'],"imgb1"=>$all1s[$i]['imgb1'],"imgb2"=>$all1s[$i]['imgb2'],"country"=>$all1s[$i]['country'],"c_pv"=>$all1s[$i]['c_pv'],"onlypoint"=>$all1s[$i]["onlypoint"]);
				$k++;
			}

			echo json_encode($data_list);
		
		}
		
	
		else if ($Type == "view")
		{
			$k = 0;

			
			$sql = "SELECT title,info,pricec,prices,priced,point,size,color,currnum,detail,company,feature,soldout,relation,price_dis,imgm,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,home,event_str,imgb1,imgb2,country,imgb3,imgb4,imgb5,coin,c_pv,onlypoint FROM $shop_goods WHERE code='".$_POST['cate1']."'";

			$DB->get($sql, $all1s, $all1n);
			$i = 0;
			for($i=0;$i<$all1n;$i++)
			{	

				$data_list[$k]=array("title"=>$all1s[$i]['title'],"info"=>$all1s[$i]['info'],"pricec"=>$all1s[$i]['pricec'],"priced"=>$all1s[$i]['priced'],"point"=>$all1s[$i]['point'],"size"=>$all1s[$i]['size'],"color"=>$all1s[$i]['color'],"currnum"=>$all1s[$i]['currnum'],"detail"=>$all1s[$i]['detail'],"company"=>$all1s[$i]['company'],"feature"=>$all1s[$i]['feature'],"soldout"=>$all1s[$i]['soldout'],"relation"=>$all1s[$i]['relation'],"price_dis"=>$all1s[$i]['price_dis'],"imgm"=>$all1s[$i]['imgm'],"opt_num"=>$all1s[$i]['opt_num'],"opt_num_str"=>$all1s[$i]['opt_num_str'],"option_t1"=>$all1s[$i]['option_t1'],"option_n1"=>$all1s[$i]['option_n1'],"option_p1"=>$all1s[$i]['option_p1'],"option_k1"=>$all1s[$i]['option_k1'],"option_t2"=>$all1s[$i]['option_t2'],"option_n2"=>$all1s[$i]['option_n2'],"option_p2"=>$all1s[$i]['option_p2'],"option_k2"=>$all1s[$i]['option_k2'],"option_t3"=>$all1s[$i]['option_t3'],"option_n3"=>$all1s[$i]['option_n3'],"option_p3"=>$all1s[$i]['option_p3'],"option_k3"=>$all1s[$i]['option_k3'],"option_t4"=>$all1s[$i]['option_t4'],"option_n4"=>$all1s[$i]['option_n4'],"option_p4"=>$all1s[$i]['option_p4'],"option_k4"=>$all1s[$i]['option_k4'],"option_t5"=>$all1s[$i]['option_t5'],"option_n5"=>$all1s[$i]['option_n5'],"option_p5"=>$all1s[$i]['option_p5'],"option_k5"=>$all1s[$i]['option_k5'],"point_dis"=>$all1s[$i]['point_dis'],"color_opt"=>$all1s[$i]['color_opt'],"size_opt"=>$all1s[$i]['size_opt'],"add_opt1"=>$all1s[$i]['add_opt1'],"add_opt2"=>$all1s[$i]['add_opt2'],"add_opt3"=>$all1s[$i]['add_opt3'],"add_opt4"=>$all1s[$i]['add_opt4'],"add_opt5"=>$all1s[$i]['add_opt5'],"home"=>$all1s[$i]['home'],"event_str"=>$all1s[$i]['event_str'],"imgb1"=>$all1s[$i]['imgb1'],"imgb2"=>$all1s[$i]['imgb2'],"imgb3"=>$all1s[$i]['imgb3'],"imgb4"=>$all1s[$i]['imgb4'],"imgb5"=>$all1s[$i]['imgb5'],"coin"=>$all1s[$i]['coin'],"country"=>$all1s[$i]['country'],"c_pv"=>$all1s[$i]['c_pv'],"onlypoint"=>$all1s[$i]["onlypoint"]);
			}

			echo json_encode($data_list);
		
		}

		else if ($Type == "cart1")
		{
			$k = 0;
			$sql = "select count(*) as soo from $shop_cart where cart_id='$user_id'";
			$DB->get($sql, $all1s, $all1n);

			$k = 0 ;
			
				if ($all1s[0]['soo'] == 0 )
			{

				$sql = "cart_id		='$user_id',
						cart_cont	='".$all1s[0]['soo']."'" ;
				$DB->insert($shop_cart, $sql);
			}
			else
			{
				$sql = "cart_cont='".$_POST['session_cart']."' where cart_id='$user_id'";
				$DB->update($shop_cart, $sql);
			}
		
		}



		
}




?>
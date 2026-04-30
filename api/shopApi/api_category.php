<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

	include_once( "../lib/basic_class2.php") ;
	include_once( "../lib/config.php");
	include_once( "../lib/common.php");
	include_once( "../lib/php_function.php"); 

	$Type	= $_POST['Type'];
	$deId	= $_POST['deId'];
	$user_id= $_POST['user_id'];
	$cook_id = $_POST["cook_id"];
	$code1	= $_POST['code1'];
	$code2	= $_POST['code2'];
	$code3	= $_POST['code3'];
	$code4	= $_POST['code4'];

	if($user_id == "" && $cook_id != ""){
		$user_id = $cook_id;
	}

	if($cook_id == "" && $user_id != ""){
		$cook_id=$user_id;
	}
	
	// echo "Asd";
	// print_r($_POST);exit;

	
	if ($deId != $store_key)
	{
		$result = array("result"=>"0","msg"=>"deId is wrong");
		echo json_encode($result);
	}
	else
	{
		
		// echo 
		$DB->get("select * from $member_table where c_id=:user_id", $custs, $custn,array("user_id"=>$user_id));
		$member_code = $custs[0]['C_CODE'];


		$data_list = array();


		if ($Type == "cate1")
		{
			$k = 0;
			$query_title1 = "SELECT cate1 FROM $shop_cate WHERE code1=:code1 limit 1";
            
			$DB->get($query_title1,$cates,$caten,array("code1"=>$code1));
            
			for($i=0;$i<$caten;$i++)
			{	
                
                
				$data_list[$k]=array("code"=>$cates[$i]['code1'],"cate"=>$cates[$i]['cate1']);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}else if ($Type == "cate2")
		{
			$k = 0;
			$query_title1 = "SELECT cate2 FROM $shop_cate WHERE code1=:code1 and code2=:code2 limit 1";
            
			$DB->get($query_title1,$cates,$caten,array("code1"=>$code1,"code2"=>$code2));
            
			for($i=0;$i<$caten;$i++)
			{	
                
                
				$data_list[$k]=array("code"=>$cates[$i]['code2'],"cate"=>$cates[$i]['cate2']);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}else if ($Type == "cate3")
		{
			$k = 0;
			$query_title1 = "SELECT cate3 FROM $shop_cate WHERE code1=:code1 and code2=:code2 and code3=:code3 limit 1";
            
			$DB->get($query_title1,$cates,$caten,array("code1"=>$code1,"code2"=>$code2,"code3"=>$code3));
            
			for($i=0;$i<$caten;$i++)
			{	
                
                
				$data_list[$k]=array("code"=>$cates[$i]['code3'],"cate"=>$cates[$i]['cate3']);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}else if ($Type == "cate4")
		{
			$k = 0;
			$query_title1 = "SELECT cate4 FROM $shop_cate WHERE code1=:code1 and code2=:code2 and code3=:code3 and  code4=:code4 limit 1";
            
			$DB->get($query_title1,$cates,$caten,array("code1"=>$code1,"code2"=>$code2,"code3"=>$code3,"code4"=>$code4));
            
			for($i=0;$i<$caten;$i++)
			{	
                
                
				$data_list[$k]=array("code"=>$cates[$i]['code4'],"cate"=>$cates[$i]['cate4']);
				$k++;
			}

	
			echo json_encode($data_list);
		
		}else if ($Type == "cartCont")
		{
			$k = 0;
			$sql = "select cart_cont from $shop_cart where cart_id = :user_id";
			
            $DB->get($sql,$cates,$caten,array("user_id"=>$user_id));
			for($i=0;$i<$caten;$i++)
			{	
                
                
				$data_list[$k]=$cates[$i];
				$k++;
			}

	
			echo json_encode($data_list);
		
	
		}
		else if ($Type == "cartCount")
		{
			$k = 0;
			$sql = "select count(*) as soo from $shop_cart where cart_id=:user_id";
			// echo $user_id;
            
			$DB->get($sql,$cates,$caten,array("user_id"=>$user_id));
			for($i=0;$i<$caten;$i++)
			{	
                
				$data_list[$k]=$cates[$i];
				$k++;
			}

			// print_r($data_list);
			echo json_encode($data_list);
		
		}
		else if ($Type == "cartSave")
		{
			$k = 0;
			$session_cart = $_POST["session_cart"];
			
			$sql = "cart_id		=:user_id,									
			cart_cont		=:session_cart";

			// echo $sql;
			// echo "asD";
			// exit;
			$DB->insert($shop_cart,$sql,array("user_id"=>$user_id,"session_cart"=>$session_cart));	

	
			echo json_encode($data_list);
		
		}
		else if ($Type == "cartDel")
		{
			$k = 0;
			$session_cart = $_POST["session_cart"];

			$sql = "cart_id=:user_id";
			$DB->delete($shop_cart, $sql,array("user_id"=>$user_id));
	
			echo json_encode($data_list);
		
		}
		else if ($Type == "sellSave")
		{


			// print_r($_POST);exit;
			$k = 0;
			$session_cart = $_POST["session_cart"];
			$new_num = $_POST["new_num"];
			$code = $_POST["code"];
			$title = $_POST["title"];
			$price = $_POST["price"];
			$my_point = $_POST["my_point"];
			$count = $_POST["count"];
			$code1 = $_POST["code1"];
			$code2 = $_POST["code2"];
			$code3 = $_POST["code3"];
			$signdate = $_POST["signdate"];
			$opt1 = $_POST["opt1"];
			$opt2 = $_POST["opt2"];
			$new_opt1 = $_POST["new_opt1"];
			$new_opt2 = $_POST["new_opt2"];
			$new_opt3 = $_POST["new_opt3"];
			$new_opt4 = $_POST["new_opt4"];
			$new_opt5 = $_POST["new_opt5"];
			$code4 = $_POST["code4"];
			$prices = $_POST["prices"];
			$coin = $_POST["coin"];
			$state = $_POST["state"];
			$cook_id = $_POST["cook_id"];
			$total_pv = $_POST["total_pv"];
			$ordNo = $_POST["ordNo"];
			$ediDate = $_POST["ediDate"];
			$c_dis = $_POST["c_dis"];
			$onlyP =htmlspecialchars(addslashes($_POST['onlyP']));
			$notP =htmlspecialchars(addslashes($_POST['notP']));
			// $DB->get("select * from $member_table where C_ID=:cook_id", $custs, $custn,array("cook_id"=>$cook_id));
			
			// $member_code = $custs[0]['C_CODE'];
			
			$query1 = "SELECT * FROM $shop_sell where id = :cook_id and ordernum =:new_num and code='$code' order by idx desc";
			$DB->get($query1,$ord2s,$ord2n,array("cook_id"=>$cook_id,"new_num"=>$new_num));
			if($ord2n==0){
			$sql = "ordernum		='$new_num',									
			code				='$code',
			title		='$title',
			money			='$price',
			point		='$my_point',
			count		='$count',
			code1		='$code1',
			code2		='$code2',
			code3		='$code3',
			signdate			='$signdate',
			opt1		='$opt1',
			opt2		='$opt2',
			new_opt1		='$new_opt1',
			new_opt2		='$new_opt2',
			new_opt3		='$new_opt3',
			new_opt4		='$new_opt4',
			new_opt5		='$new_opt5',
			code4		='$code4',
			prices		='$prices',
			id		='$cook_id',
			c_pv		='$total_pv',
			onlyP		='$onlyP',
			notP		='$notP',
			ediDate		='$ediDate',
			ordNo		='$ordNo',
			coin		='$coin',
			c_dis		='$c_dis'";
			$DB->insert($shop_sell, $sql);	

			if($state == "결제완료"){
				// $member_code

				$query1 = "SELECT * FROM $sell_table where c_id = :cook_id and c_ordernum=:new_num and code='$code' and title='$title' and c_cash  ='$price'";
				// echo $query1;
				$DB->get($query1,$ord2s,$ord2n,array("cook_id"=>$cook_id,"new_num"=>$new_num));
				// echo "ASd";
				// echo $ord2n;
				// echo $query1;exit;
				if($ord2n == 0){

					$query1 = "SELECT * FROM $shop_sell where id = :cook_id and ordernum =:new_num order by idx desc";
					
					$DB->get($query1,$ord2s,$ord2n,array("cook_id"=>$cook_id,"new_num"=>$new_num));
					$idx = $ord2s[0]["idx"];
					$money = $ord2s[0]["money"];
					$date = date("Y-m-d H:i:s");
					$c_dis = $ord2s[0]["c_dis"];
					$count = $ord2s[0]["count"];
					$money=$money*$count;

					if($c_dis=="1"){
						$c_state="resell";
					}else{
						$DB->single("select * from $sell_table  where c_code = :code and c_state1='Active' and (c_state <>'shop' and c_state <> 'resell' )"  ,$moneys_all,$moneyn_all,array("code"=>$member_code),"key");

						if($moneyn_all>0){
							$c_state="upgrade";
						}else{
                            $c_state="new";
                        }
						
					}

					foreach($amount_array as $key => $value){
						if($money >= $value){
							$type=$key;
						}
					}	

					$sql = "c_ordernum = '$new_num',c_sellnum = '$idx',c_code='$member_code',c_id='$cook_id',c_date='$date',c_cash='$money',c_state='$c_state',c_state1='Active',code='$code',title='$title',c_pv='$total_pv',c_type='$type',c_type2='USD'";
					
					$DB->insert($sell_table, $sql);	


					$DB->single("select sum(c_cash) as total from $sell_table  where c_code = :code and c_state1='Active' and c_state <> 'resell' order by c_cash desc"  ,$moneys_all,$moneyn_all,array("code"=>$member_code),"key");
					$cash = $moneys_all['total'];

					foreach ($amount_array as $key => $value) {
						if($cash >= $value){
							$type = $key;
						}
					}

					
					$jik_sql1 = "C_JIK=:type where C_CODE=:code";
					$DB->update($member_table, $jik_sql1,array("type"=>$type,"code"=>$member_code),"key");

					$jik_sql1 = "c_level=:type where c_code=:code";
					$DB->update("board1", $jik_sql1,array("type"=>$type,"code"=>$member_code),"key");

						// exit;

					}
					// $query1 = "SELECT idx,ordernum FROM $sell_table where c_sellnum = :cook_id order by idx desc";
					// $DB->get($query1,$ord2s,$ord2n,array("cook_id"=>$cook_id));

				

				
			}
		
	
			echo json_encode($data_list);
		}
		
		}
		else if($Type == "orderUpdate"){
			$kka=$_POST["kka"];
			$transactionId = htmlspecialchars(addslashes(trim($_POST["transactionId"])));
			$tid = htmlspecialchars(addslashes(trim($_POST["tid"])));
			$ediDate = htmlspecialchars(addslashes(trim($_POST["ediDate"])));

			


			$sql = "status ='결제완료',tid='$tid' where ediDate='$ediDate' and id = '$user_id'  and status='주문접수'; ";
			// echo $sql;exit;

			// echo $shop_order;exit;
			$DB->update($shop_order,$sql);

			$query1 = "SELECT * FROM $sell_table where c_id = '$user_id' and c_ordernum='$ediDate' ";
			// echo $query1;
			// exit;
			$DB->get($query1,$ord2s,$ord2n);
			// echo "ASd";
			// echo $ord2n;
			// echo $query1;exit;
			if($kka == "a"){
				$sql = "TEXT = '$transactionId'";
				$DB->insert("test", $sql);	
			}
			if($ord2n == 0){
				
				$query1 = "SELECT * FROM $shop_sell where id = :user_id and ediDate =:ediDate order by idx asc";
				
				$DB->get($query1,$ord2s,$ord2n,array("user_id"=>$user_id,"ediDate"=>$ediDate));
				for($i=0;$i<$ord2n;$i++){
				$idx = $ord2s[$i]["idx"];
				$code = $ord2s[$i]["code"];
				$price = $ord2s[$i]["money"];
				$title = $ord2s[$i]["title"];
				$c_pv = $ord2s[$i]["c_pv"];
				$c_dis = $ord2s[$i]["c_dis"];
				$count = $ord2s[$i]["count"];
				
					$c_pv=$c_pv*$count;
					$price=$price*$count;
				$date = date("Y-m-d H:i:s");

				foreach($amount_array as $key => $value){
					if($price >= $value){
						$type=$key;
					}
				}	

				if($c_dis=="1"){
						$c_state="resell";
					}else{
						$DB->single("select * from $sell_table  where c_code = :code and c_state1='Active' and (c_state <>'shop' and c_state <> 'resell' )"  ,$moneys_all,$moneyn_all,array("code"=>$member_code),"key");

						if($moneyn_all>0){
							$c_state="upgrade";
						}else{
                            $c_state="new";
                        }
						
					}

				$sql = "c_ordernum = '$ediDate',c_sellnum = '$idx',c_code='$member_code',c_id='$user_id',c_date='$date',c_cash='$price',c_state='$c_state',c_state1='Active',code='$code',title='$title',c_pv='$c_pv',c_type='$type',c_type2='USD'";
				//echo $sql;exit;
				 $DB->insert($sell_table, $sql);	


				 $DB->single("select sum(c_cash) as total from $sell_table  where c_code = :code and c_state1='Active' and c_state <> 'resell' order by c_cash desc"  ,$moneys_all,$moneyn_all,array("code"=>$member_code),"key");
					$cash = $moneys_all['total'];

					foreach ($amount_array as $key => $value) {
						if($cash >= $value){
							$type = $key;
						}
					}

					
					$jik_sql1 = "C_JIK=:type where C_CODE=:code";
					$DB->update($member_table, $jik_sql1,array("type"=>$type,"code"=>$member_code),"key");

					$jik_sql1 = "c_level=:type where c_code=:code";
					$DB->update("board1", $jik_sql1,array("type"=>$type,"code"=>$member_code),"key");
					
						// exit;

					}
				// echo $sql;
				}
				

			
			
			// $sql = "status ='결제완료' where ordernum='$transactionId'; ";
			// $DB->update($shop_sell,$sql);
			exit;
		}
		else if ($Type == "orderSave")
		{
			
			$k = 0;
			$session_cart = $_POST["session_cart"];
			$new_num =htmlspecialchars(addslashes($_POST['new_num']));
			$cook_id =htmlspecialchars(addslashes($_POST['cook_id']));
			$pay_name =htmlspecialchars(addslashes($_POST['pay_name']));
			$pay_tel =htmlspecialchars(addslashes($_POST['pay_tel']));
			$pay_mobile =htmlspecialchars(addslashes($_POST['pay_mobile']));
			$pay_zip1 =htmlspecialchars(addslashes($_POST['pay_zip1']));
			$pay_zip2 =htmlspecialchars(addslashes($_POST['pay_zip2']));
			$pay_addr =htmlspecialchars(addslashes($_POST['pay_addr']));
			$pay_email =htmlspecialchars(addslashes($_POST['pay_email']));
			$pay_etc =htmlspecialchars(addslashes($_POST['pay_etc']));
			$receive_name =htmlspecialchars(addslashes($_POST['receive_name']));
			$receive_tel =htmlspecialchars(addslashes($_POST['receive_tel']));
			$receive_mobile =htmlspecialchars(addslashes($_POST['receive_mobile']));
			$receive_zip1 =htmlspecialchars(addslashes($_POST['receive_zip1']));
			$receive_zip2 =htmlspecialchars(addslashes($_POST['receive_zip2']));
			$receive_addr =htmlspecialchars(addslashes($_POST['receive_addr']));
			$receive_email =htmlspecialchars(addslashes($_POST['receive_email']));
			$receive_etc =htmlspecialchars(addslashes($_POST['receive_etc']));
			$kind =htmlspecialchars(addslashes($_POST['kind']));
			$bank =htmlspecialchars(addslashes($_POST['bank']));
			$pointin =htmlspecialchars(addslashes($_POST['pointin']));
			$pointout =htmlspecialchars(addslashes($_POST['pointout']));
			$in_name =htmlspecialchars(addslashes($_POST['in_name']));
			$in_year =htmlspecialchars(addslashes($_POST['in_year']));
			$in_month =htmlspecialchars(addslashes($_POST['in_month']));
			$in_day =htmlspecialchars(addslashes($_POST['in_day']));
			$charge =htmlspecialchars(addslashes($_POST['charge']));
			$char_year =htmlspecialchars(addslashes($_POST['char_year']));
			$char_month =htmlspecialchars(addslashes($_POST['char_month']));
			$char_day =htmlspecialchars(addslashes($_POST['char_day']));
			$state =htmlspecialchars(addslashes($_POST['state']));
			$passwd =htmlspecialchars(addslashes($_POST['passwd']));
			$signdate =htmlspecialchars(addslashes($_POST['signdate']));
			$total_settle_num =htmlspecialchars(addslashes($_POST['total_settle_num']));
			$tid =htmlspecialchars(addslashes($_POST['tid']));
			$usepoint =htmlspecialchars(addslashes($_POST['usepoint']));
			$bank =htmlspecialchars(addslashes($_POST['bank']));
			$in_name =htmlspecialchars(addslashes($_POST['in_name']));
			$pay_etc =htmlspecialchars(addslashes($_POST['pay_etc']));
			$total_pv =htmlspecialchars(addslashes($_POST['total_pv']));
			$onlyP =htmlspecialchars(addslashes($_POST['onlyP']));
			$notP =htmlspecialchars(addslashes($_POST['notP']));
			$ordNo =htmlspecialchars(addslashes($_POST['ordNo']));
			$ediDate =htmlspecialchars(addslashes($_POST['ediDate']));
			if($pay_name=="" && $pay_tel == ""){exit;}
			// echo $bank;exit;
			$sql = "ordernum		='$new_num',									
			id				='$cook_id',
			pay_name		='$pay_name',
			pay_tel			='$pay_tel',
			pay_mobile		='$pay_mobile',
			pay_zip1		='$pay_zip1',
			pay_zip2		='$pay_zip2',
			pay_addr		='$pay_addr',
			pay_email		='$pay_email',
			pay_etc			='$pay_etc',
			receive_name		='$receive_name',
			receive_tel		='$receive_tel',
			receive_mobile		='$receive_mobile',
			receive_zip1		='$receive_zip1',
			receive_zip2		='$receive_zip2',
			receive_addr		='$receive_addr',
			receive_email		='$receive_email',
			receive_etc		='$pay_etc',
			kind		='$kind',
			bank		='$bank',
			
			in_name		='$in_name',
			in_year		='$in_year',
			in_month		='$in_month',
			in_day		='$in_day',
			charge		='$charge',
			char_year		='$char_year',
			char_month		='$char_month',
			char_day		='$char_day',
			char_num		='',
			status		='$state',
			passwd		='$passwd',
			usepoint		='$usepoint',
			signdate		='$signdate',
			qty		='$total_settle_num',
			c_pv		='$total_pv',
			onlyP		='$onlyP',
			notP		='$notP',
			ordNo		='$ordNo',
			ediDate		='$ediDate',
			
			
			
			tid		='$tid'";
			// echo $sql;
			$DB->insert($shop_order, $sql);	
			// echo $sql;
	
			echo json_encode($data_list);
		
		}
		else if ($Type == "cartUpdate")
		{
			$k = 0;
			$session_cart = $_POST["session_cart"];

			$sql = "cart_cont=:session_cart where cart_id=:user_id";
			$DB->update($shop_cart,$sql,array("user_id"=>$user_id,"session_cart"=>$session_cart),"key");
	
			echo json_encode($data_list);
		
		}
		else if ($Type == "sellCancle")
		{
			$k = 0;
			$ordnum = $_POST["ordnum"];

			$sql = "status = '주문자취소' WHERE ordernum=$ordnum";
			$DB->update($shop_order,$sql,array("ordnum"=>$ordnum),"key");
			

			
			echo json_encode($data_list);
		
		}
		else if ($Type == "sellCom")
		{
			$k = 0;
			$ordnum = $_POST["ordnum"];

			$sql = "status = '구매확정' WHERE ordernum=$ordnum";
			$DB->update($shop_order,$sql,array("ordnum"=>$ordnum),"key");
			

			
			echo json_encode($data_list);
		
		}
		else if ($Type == "proView")
		{
			$k = 0;
			$code = $_POST["code"];
			// echo "SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,imgb1,imgb2,No,coin,c_pv,onlypoint,c_dis FROM $shop_goods WHERE code='$code'";
			$DB->get("SELECT code,title,pricec,prices,priced,point,soldout,price_dis,imgl,opt_num,opt_num_str,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,point_dis,imgb1,imgb2,No,coin,c_pv,onlypoint,c_dis FROM $shop_goods WHERE code='$code'",$goods,$goodn);
			
			for($i=0;$i<$goodn;$i++)
			{	
                
				$data_list[$k]=$goods[$i];
				$k++;
			}

			
			echo json_encode($data_list);
		
		}
		else if ($Type == "orderMax")
		{
			$k = 0;
			$code = $_POST["code"];
			$DB->get("SELECT max(ordernum) FROM $shop_order",$ords,$ordn);
			for($i=0;$i<$ordn;$i++)
			{	
                
				$data_list[$k]=$ords[$i];
				$k++;
			}

	
			echo json_encode($data_list);
		
		}


		
}




?>
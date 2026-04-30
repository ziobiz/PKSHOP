<?
  include "../include/com.php";
?>
<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>MANOG50</title>
    <link rel="stylesheet" href="../include/reset.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../include/style.css" type="text/css" media="all" />
    <script type="text/javascript" src="../include/jquery-3.3.1.min.js"></script>
</head>

<body>
<script>

function cala_qty(values)
{
	var frm = document.purfrm;


	var gprice		= Number(frm.gprice.value);
	var dprice		= Number(frm.dashavg.value);



	var dash_amount = dprice * values;

	var g50_qty = dash_amount /gprice;

	

	frm.g50_qty.value = g50_qty.toFixed(2);

}

function purchace()
{
	var frm = document.purfrm;
	
	if (frm.amount.value == "")
	{
		alert("매출 수량을 입력하세요");
	}
	else if (Number(frm.amount.value) <= 0)
	{
		alert("매출 수량을 입력하세요");
	}
	else if (Number(frm.dashbl.value) < Number(frm.amount.value))
	{
		frm.amount.value =  "";
		frm.g50_qty.value = "";
		alert("Ethereum 수량이 부족합니다.");
	}
	else
	{
		frm.submit();
	}
}
</script>

    <div id="wrap"><!--wrap-->
		<? include "../include/language.html"; ?>
		<div class="header"><!--header-->
			<div class="back" onclick="location.href='../main/main.php'">
				<img src="../images/back.png" alt="뒤로가기">
			</div>
			<div class="header_title">
				<span>MANOG50 구매</span>
			</div>
		</div><!--header end-->

	<?

	include "../include/get_balance.php";

	function getFromUrl($url, $method = 'GET')
	{
				
				$ch = curl_init();
				$agent = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';
				
				
				switch(strtoupper($method))
				{
					case 'GET':     
						curl_setopt($ch, CURLOPT_URL, $url);
						break;
			 
					case 'POST':
						$info = parse_url($url);
						$url = $info['scheme'] . '://' . $info['host'] . $info['path'];
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $info['query']);
						break;
			 
					default:
						return false;
				}
				
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
				curl_setopt($ch, CURLOPT_TIMEOUT, 5);
				curl_setopt($ch, CURLOPT_REFERER, $url);
				curl_setopt($ch, CURLOPT_USERAGENT, $agent);
				

				$res = curl_exec($ch);

				curl_close($ch);
				
				return $res;
	}
	$api		= "https://api.hitbtc.com/api/2/public/ticker/ETHUSD";
	$datas2		= getFromUrl($api);

	$btc_json2	= json_decode($datas2, true);
	$btc_price2 = $btc_json2['last'];
	?>
	<form name='purfrm' method='post' action='purchase_ok2.php'>
	<input type='hidden' name='dashbl' value="<?=$json_balance['ethcash']?>">
	<input type='hidden' name='dprice' value="<?=$btc_price2?>">
	<input type='hidden' name='gprice' value="<?=$json_balance['gprice']?>">

		<div id="container"><!--container-->
			<div class="wrap_trans"><!--wrap_trans-->

				<div class="coin_state">
					<div>
						<span class="txt_tit" style="border-bottom: 1px solid #bfbcbc; width: 70%; margin: 0 auto; padding-bottom: 5px;margin-bottom: 5px;">Withdrawal Ethereum Balance</span>
						<span class="txt_num"><?=$json_balance['ethcash']?></span>
					</div>
				</div>
				<div class="form01" style="margin-top:30px">
					<img src="images/setup_icon03.png" class="img01">
					<p class="account">Ethereum 시세</p>
				</div>
				<div class="form02">
					<input type="text" class="input_form" readonly name='dashavg' value="<?=$btc_price2?>">
				</div>

				<div class="form01" style="margin-top:30px">
					<img src="images/setup_icon03.png" class="img01">
					<p class="account">결재 Ethereum 수량</p>
				</div>
				<div class="form02">
					<input type="text" class="input_form" placeholder="수량을입력하세요"  name='amount' onblur='cala_qty(this.value)'>
				</div>

				<div class="form01" style="margin-top:30px">
					<img src="images/setup_icon03.png" class="img01">
					<p class="account">구매될 G50 수량</p>
				</div>
				<div class="form02">
					<input type="text" class="input_form" placeholder="수량을입력하세요"  name='g50_qty' readonly value="">
				</div>


				<div class="form01" style="margin-top:30px">
					<img src="images/setup_icon02.png" class="img01">
					<p class="account">결재비밀번호</p>
				</div>
				<div class="form02">
					<input type="password" class="input_form" placeholder="결제비밀번호를 입력하세요" name='fpass' value="">
				</div>

				<div class="form-group mt40">
					<button type="button" id="next" class="btn-primary" onclick="purchace()">구매요청</button>
				</div>
			</div><!--wrap_trans end-->
		</div><!--container end-->
		</form>
    </div><!--wrap end-->

</body>

</html>

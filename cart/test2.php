
 <script src="https://paycdn.pingpongx.com/production-fra/static-fra/sdk/ppAcquirerRisk.min-2.0.0.js"></script>
<?	
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );

	include "../include/get_balance.php";
	include "../include/login_check.php";
    include "../include/top.php";
    $merchantTransactionId=$_GET["merchantTransactionId"];
    $transactionId=$_GET["transactionId"];
	
	$md5 = md5("F78BC96A55548B2319EE68E0accId=2021121005433420956302&signType=MD5&transactionId=$transactionId");
    

    foreach ($_REQUEST as $key => $value) {
        $text=$text."&$key=$value";
    }

    $data = "deId=e7bb77ca2517821473681d3e9fe132e54c21bdff0ef170596f0414032aac3dbc&user_id=".$_SESSION['member_id'].$text;
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, $api_test);
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
    curl_close ($ch);
    // echo $text;

    $body_data = array(
        "accId" => "2021121005433420956302",
        "signType" => "MD5",
        "sign" => $md5,
        "transactionId" => $transactionId,
 
      

    );
    
    
    $body = json_encode($body_data);
    
    $data = "accId=2021121005433420956302&signType=MD5&sign=$md5";
    $ch = curl_init();
    curl_setopt ($ch, CURLOPT_URL, "https://acquirer-payment.pingpongx.com/v2/query");
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt ($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
    curl_setopt ($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt ($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec ($ch);
    curl_close ($ch);
    echo $result;    
    
    ?>

<script src="https://paycdn.pingpongx.com/production/static/sdk/1.2.0/ppPay.min.js"></script>

<input type="button" value="테스트" onclick="test2()">
<form name="form" id="form" method="POST" >
    <input type="text" name="accId" value="2021121005433420956302">
    <input type="text" name="signType" value="MD5">
    <!-- <input type="text" name="amount" value="3">
    <input type="text" name="currency" value="USD"> -->
    <!-- <input type="text" name="merchantTransactionId" value="<?=$merchantTransactionId?>"> -->
    <!-- <input type="text" name="notificationUrl" value="https://pentakleva.shop/cart/test2.php">  -->
    <!-- <input type="text" name="shopperResultUrl" value="https://pentakleva.shop/cart/test2.php">  -->
    <input type="text" name="sign" value="<?=$md5?>" >
    <!-- <input type="text" name="transactionId" id="transactionId" value="<?=$_GET["transactionId"]?>" > -->
    
    <!-- <input type="hidden" name="clientId" value="2018092714313010016">
    <input type="hidden" name="paymentType" value="SALE">
    
    <input type="hidden" name="salt " value="F78BC96A55548B2319EE68E0">
    -->
    <!-- <input type="hidden" name="paymentType" value="SALE">  -->
    <!-- <input type="hidden" name="shopperResultUrl" value="https://pentakleva.shop/cart/cart_order.php"> -->
    <!-- <input type="hidden" name="shopperCancelUrl" value="https://pentakleva.shop/cart/cart_order.php"> -->



</form>
<script>

     jQuery.fn.serializeObject = function() { 
      var obj = null; 
      try { 
          if(this[0].tagName && this[0].tagName.toUpperCase() == "FORM" ) { 
              var arr = this.serializeArray(); 
              if(arr){ obj = {}; 
              jQuery.each(arr, function() { 
                  obj[this.name] = this.value; }); 
              } 
          } 
      }catch(e) { 
          alert(e.message); 
      }finally {} 
      return obj; 
    }


    function test(){
        $.ajax({
            type: "POST",
            url: "https://sandbox-acquirer-payment.pingpongx.com/v2/checkout",
            data: JSON.stringify($("#form").serializeObject()),
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            success: function (response) {
                $("#transactionId").val(response.transactionId);
                window.open(response.paymentUrl);

            }
        });
        // document.form.action="https://sandbox-acquirer-payment.pingpongx.com/v2/checkout";
        //     document.form.submit();
    }

    function test2(){
        var transactionId= "<?=$_GET["transactionId"]?>";
        $.ajax({
            type: "POST",
            url: "https://acquirer-payment.pingpongx.com/v2/query",
            data: JSON.stringify($("#form").serializeObject()),
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            success: function (response) {
                // window.open(response.paymentUrl);
            }
        });
        // document.form.action="https://sandbox-acquirer-payment.pingpongx.com/v2/checkout";
        //     document.form.submit();
    }
</script>
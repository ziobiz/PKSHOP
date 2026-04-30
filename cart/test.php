<?	
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
	include "../include/get_balance.php";
	include "../include/login_check.php";
    include "../include/top.php";
    $merchantTransactionId=rand(100000000,999999999);


        
        
	$md5 = md5("F78BC96A55548B2319EE68E0accId=2021121005433420956302&amount=1.08&currency=USD&merchantTransactionId=$merchantTransactionId&notificationUrl=https://pentakleva.shop/cart/test2.php&shopperResultUrl=https://pentakleva.shop/cart/test2.php&signType=MD5");


    $a=array(
        "accId"=> "2021121005433420956302",
        "amount"=> "1.08",
        "currency"=> "USD",
        "merchantTransactionId"=> $merchantTransactionId,
        "notificationUrl"=> "https://pentakleva.shop/cart/test2.php",
        "shopperResultUrl"=> "https://pentakleva.shop/cart/test2.php",
        "signType"=> "MD5",
        "sign"=> $md5,
        "riskInfo"=> array(
            "billing"=>array(
                "city"=>"Birmingham",
                "country"=>"US",
                "email"=>"13757178575@pingpognx.com",
                "firstName"=>"James",
                "lastName"=>"LeBron",
                "phone"=>"13757178575",
                "postcode"=>"35222",
                "state"=>"Alabama",
                "street"=>"1986 Broad Street"
             )
            )
        );    
        $body=json_encode($a);
        echo $body;
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, "https://acquirer-payment.pingpongx.com/v2/checkout");
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
<body>
<input type="button" value="테스트" onclick="test()">
<form name="form" id="form" method="POST" >
    <input type="text" name="accId" value="2021121005433420956302">
    <input type="text" name="amount" value="1.08">
    <input type="text" name="currency" value="USD">
    <input type="text" name="merchantTransactionId" value="<?=$merchantTransactionId?>">
    <input type="text" name="notificationUrl" value="https://pentakleva.shop/cart/test2.php"> 
    <input type="text" name="shopperResultUrl" value="https://pentakleva.shop/cart/test2.php"> 
    <input type="text" name="signType" value="MD5">
    <input type="text" name="sign" value="<?=$md5?>" >
    <input type="text" name="riskInfo" value="<?=($riskInfo)?>" >
    
    <!-- <input type="text" name="transactionId" id="transactionId"  > -->
    <!-- <input type="hidden" name="clientId" value="2018092714313010016">
    <input type="hidden" name="paymentType" value="SALE">
    
    <input type="hidden" name="salt " value="F78BC96A55548B2319EE68E0">

    <input type="hidden" name="paymentType" value="SALE">
    <input type="hidden" name="shopperResultUrl" value="https://pentakleva.shop/cart/cart_order.php">
    <input type="hidden" name="shopperCancelUrl" value="https://pentakleva.shop/cart/cart_order.php">-->



</form>
    </body>
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
        // console.log(JSON.stringify($("#form").serializeObject()));
        // console.log(   JSON.stringify({
        //         "accId": "2021121005433420956302",
        //         "amount": "1.08",
        //         "currency": "USD",
        //         "merchantTransactionId": "<?=$merchantTransactionId?>",
        //         "notificationUrl": "https://pentakleva.shop/cart/test2.php",
        //         "shopperResultUrl": "https://pentakleva.shop/cart/test2.php",
        //         "signType": "MD5",
        //         "sign": "<?=$md5?>",
        //         "riskInfo": {
        //             "billing":{
        //                 "city":"Birmingham",
        //                 "country":"US",
        //                 "email":"13757178575@pingpognx.com",
        //                 "firstName":"James",
        //                 "lastName":"LeBron",
        //                 "phone":"13757178575",
        //                 "postcode":"35222",
        //                 "state":"Alabama",
        //                 "street":"1986 Broad Street"
        //             }
        //         }
                

        //     }));
        // return false;
        // console.log("123213");
        // alert("1");
        // var a= "ASd";
        $.ajax({
            type: "POST",
            url: "https://acquirer-payment.pingpongx.com/v2/checkout",
            // data: JSON.stringify($("#form").serializeObject()),
            data:JSON.stringify({
                "accId": "2021121005433420956302",
                "amount": "1.08",
                "currency": "USD",
                "merchantTransactionId": "<?=$merchantTransactionId?>",
                "notificationUrl": "https://pentakleva.shop/cart/test2.php",
                "shopperResultUrl": "https://pentakleva.shop/cart/test2.php",
                "signType": "MD5",
                "sign": "<?=$md5?>",
                "riskInfo": {
                    "billing":{
                        "city":"Birmingham",
                        "country":"US",
                        "email":"13757178575@pingpognx.com",
                        "firstName":"James",
                        "lastName":"LeBron",
                        "phone":"13757178575",
                        "postcode":"35222",
                        "state":"Alabama",
                        "street":"1986 Broad Street"
                    }
                }
                

            }),
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            success: function (response) {
                
                // $("#transactionId").val(response.transactionId);
                
                window.open(response.paymentUrl);
                // do_pay(response.token)
            }
        });
        // document.form.action="https://sandbox-acquirer-payment.pingpongx.com/v2/checkout";
        //     document.form.submit();
    }
    


// manul 模式
// 开启 manul 模式 意味着 收银台不会生成支付按钮，支付需要通过实例中的actionPayment 方 法进行手动支付 // 使用方法
// function pay() { 
//     client.actionPayment()
// }


    function test2(){
        $.ajax({
            type: "POST",
            url: "https://sandbox-acquirer-payment.pingpongx.com/v2/payment/",
            data: JSON.stringify($("#form").serializeObject()),
            contentType: 'application/json; charset=utf-8',
            dataType: "json",
            success: function (response) {
                window.open(response.paymentUrl);
            }
        });
        // document.form.action="https://sandbox-acquirer-payment.pingpongx.com/v2/checkout";
        //     document.form.submit();
    }
</script>
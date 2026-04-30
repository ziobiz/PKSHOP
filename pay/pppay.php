---

<a name="O7Ucw"></a>

## 收银台模式

---

<a name="Xyyl8"></a>

### 接入方式

> 1. 内嵌接入：
     >
1. 提供收银台⻚面，商户无需自行开发收银台⻚面，
>    1. 通过引入 PingPongPay 提供的 动态 JS 脚本 ，即时渲染收银台⻚面。
> 2. 跳转接入
     >
1. 提供收银台⻚面，商户无需自行开发收银台⻚面，
>    1. 执行完结账请求，直接跳转至 PingPongPay 收银台⻚面。

<a name="vicYk"></a>

### 3DS 交易

> 3DS 交易要求用户需输入额外的验证信息，基本上可以避免未授权交易和黑卡交易，从而降低商户的 交易⻛险。
> 收银台模式下，3DS 流程由 PingPongPay 进行了内部封装，无需商户额外接入。


---

<a name="YnFRN"></a>

### 电商接入最佳实践

---

<a name="l5fUw"></a>

#### 引导付款

>       - 商户网站购物流程记录下单并引导用户到付款流程
>       - 用户选择付款方式为ping-pong pay，商户前端提交付款信息。

<a name="Ze8tb"></a>

#### 发起支付

> - 商户后端处理付款信息，调用v2/checkout 接口发起支付。
>    - ping pong server 通过v2/checkout 接口响应请求，返回交易信息。
>    - 商户后端处理记录返回交易的信息。返回前端token，paymentUrl 等字段，以便于后续交易进行。

<a name="Nr8lV"></a>

#### 唤起收银台

> 商户前端通过商户后端的接口响应 收到v2/checkout 接口响应信息，此时分为两种情况：
> 1. 内嵌接入：商户前端将token等信息传入JS-SDK唤起收银台。
> 1. 跳转接入：商户前端将页面定向到paymentUrl，前往收银台页面。
>
用户通过收银台的支付按钮完成付款信息收集和验证，并向ping-pong server 发起请求。

<a name="cWSFP"></a>

#### 交易结果处理

> ping-pong server 处理交易：
> - [ ] 将用户页面重定向到**shopperResultUrl**
> - [ ] 同时向商户后端的notificationUrl发送异步通知。
    >
- 商户前端：
> - [ ] 在** shopperResultUrl **页面轮询商户后端的订单状态查询接口，获取订单信息。
    >
- 商户后端：
> - [ ] 实现notificationUrl 指定的接口，并在接受异步通知之后，完成验签，订单状态流转，记录通知内容等动作。
> - [ ] 在查询接口轮询DB N秒(一般5秒内)等待异步通知接口修改DB的结果,并返回前端展示。
> - [ ] 超时未收到异步通知，发送v2/query请求，手动获取交易结果，并处理此次交易相关状态，响应前端页面结果。
>
用户在前端页面看到交易结果，当前发起的一次交易结束。使用PHP SDK 发起请求


---

<a name="wdjGW"></a>

### 使用 PHP-SDK

---

<a name="AZ15h"></a>

#### 自动导入

> 使用composer管理项目依赖：

> - [ ] [安装使用composer](https://pkg.phpcomposer.com/#how-to-install-composer)
> - [ ] 使用命令composer init 初始化你的composer.json(已有composer.json文件 跳过此步骤)
> - [ ] 将SDK拖入vendor 目录
> - [ ] 在你的项目根目录中找到composer.json文件，添加如下自动加载依赖

```json
"autoload": {
"files": [
"./vendor/pppay/vendor/autoload.php"
]
}
```

> - [ ] 运行命令 composer dump-autoload


---

<a name="s4S8V"></a>

#### 配置SDK

> 新建你的配置类，继承如下抽象类

```PHP
abstract class PPConfigs extends SplBean
{
	public $salt;//md5秘钥
	public $clientId;
	public $accId;//用户accId
	public $gateway;//网关地址
  //以下是pingpong支付状态和商户订单状态的映射关系
	public $stateFailed = 'failed';//pingpong返回Failed时候对应的商户订单状态
	public $stateSuccess = 'processing';//pingpong返回Success状态时候对应的商户订单状态
	public $stateRefunded = 'refunded';//pingpong返回Refunded状态时候对应的商户订单状态
	public $stateProcessing = 'pending';//pingpong返回Processing时候对应的商户订单状态
	public $stateReview = 'on-hold';//pingpong返回Review时候对应的商户订单状态

}
```

<a name="N3BkB"></a>

#### 发起交易请求

- 请求类代码位置

> **Request/CheckOut.php**

- 方法列表

```PHP
//构造方法
public function __construct(PPConfigs $ppConfigs, CheckOutPayLoad $checkOutPayLoad)
//发起请求方法  
public function request(?callable $success = null, ?callable $fail = null): PPXCheckOutResponse
```

- 使用示例

```PHP
//实例化请求对象
$checkOutRequest = new CheckOut($config, $payload);
//设置HTTP请求驱动类 目前提供两种驱动：协程http(需要swoole扩展) 和curl
$checkOutRequest->setHttpClientDriver(CoHttpClient::class);
//返回接口（v2/chekout）请求结果以便于后续初始化JS-SDK 拉起收银台  
$response = $checkOutRequest->request();
```

- 返回结果数据模型

```php
class PPXCheckOutResponse extends SplBean
{
	protected $accId;
	protected $clientId;
	protected $code;
	protected $description;
	protected $innerJsUrl;
	protected $merchantTransactionId;
	protected $paymentUrl;//收银台跳转接入时候用到-跳转前往收银台页面
	protected $sign;//签名
	protected $signType;//签名类型
	protected $token;//拉起JS-SDK所需参数
```

<a name="o5jJs"></a>

#### 发起交易查询

- 请求类代码位置

> **Request/Query.php**

- 方法列表

```PHP
//构造方法
public function __construct(PPConfigs $ppConfigs, $merchantTransactionId, $transactionId, $signType = PPSignType::SIGN_TYPE_MD5)

//发起请求方法  
public function request(?callable $success = null, ?callable $fail = null): PPXQueryResponse
```

- 使用示例

```PHP
	/***
	 * 从PingPong服务器获取支付结果-使用查询接口主动查询
	 * @param PPConfigs $configs
	 * @param string $transactionId
	 * @return PPXQueryResponse
	 * @throws
	 */
private static function getResultFromPingPongServer(PPConfigs $configs, string $transactionId): PPXQueryResponse
	{
		$queryClient = new Query($configs, null, $transactionId);
		$queryClient->setHttpClientDriver(CoHttpClient::class);
		$queryClient->setHttpClient();
		$response = $queryClient->request();

		if ( is_string($response->getMerchantTransactionId()) ) {
			OrderServer::saveOrderInfo($response->getMerchantTransactionId(), 'query', $response);
		}

		return $response;
	}

```

- 返回结果数据模型

```PHP
class PPXQueryResponse extends AbstractPPXResponse
{
    protected $accId;
    protected $amount;
    protected $channel;
    protected $clientId;
    protected $currency;
    protected $description;
    protected $merchantTransactionId;
    protected $notificationUrl;
    protected $paymentType;
    protected $relateTransactionId;
    protected $shopperResultUrl;
    protected $sign;
    protected $signType;
    protected $status;
    protected $transactionId;
    protected $transactionTime;
```

---

<a name="m3Uri"></a>

## 端到端模式

---

<a name="BmaP5"></a>

### 说明

<a name="NafSU"></a>

#### 接入前提

> - 商户与 PingPongPay 完全通过 API 来进行交互，商户需自行开发收银台⻚面，保存、处理用户的信用卡信息。
> - 该方案要求商户服务器自行保存、处理用户的信用卡信息，因此强制要求商户具备 PCI 资质。以下请求接口 Content-Type 均为 application/json

<a name="rpErT"></a>

#### 业务类型

> - SALE-消费

    >          - 消费者在商户客户端进行消费时，选择支付方式进行支付。支付成功后，商户即可发货，资金会按照 约定的结算周期结算给商户。
    >          - 注意:在交易进行中，为了更好地帮助商户提前规避⻛险，若 PingPongPay ⻛控系统识别出订单⻛ 险存疑，会在客户端展示交易状态为“status=REVIEW”，商户收到“status=REVIEW”时，需要及时进 行内部审核。商户可执行 2 种操作:“审核通过”或“审核拒绝”(具体内容详⻅商户接入指南3.2.2.4 和 3.2.2.5)。若 商户 7 天内无反馈，PingPongPay 7 天后将自动撤销该笔交易。

> - AUTH-预授权

    >          - 商户在持卡人消费前先冻结持卡人 creditcard 的余额或者额度，持卡人消费结束后，商户再正式扣掉 这部分资金，常用于酒店住宿、出租等行业。线上交易正常预授权资金冻结期限为 7 天，部分发卡行 是 30 天。
    >          - 注意: PingPongPay 默认不会自动解冻持卡人资金。预授权交易 7 天或者 30 天后，如果商户在这期 间没有任何操作，发卡行会自动解冻持卡人冻结的资金。
>




---

<a name="eJRm5"></a>

### 3DS 交易

> - 3DS 交易要求用户需输入额外的验证信息，基本上可以避免未授权交易和黑卡交易，从而降低商户的 交易⻛险。
> - 端到端模式下，商户需要根据“一次交易”接口中响应的报文，将特定的参数通过表单形式进行提交，从而将用户当前⻚面跳转至发卡行的 3DS 验证⻚面来完成流程衔接。
> - 详见商户接入指南3.5.2

<a name="d9gsW"></a>

### 电商接入最佳实践-SALE业务模型

<a name="qRDiN"></a>

#### 引导付款

>       - 商户网站购物流程记录下单并引导用户到付款流程，收集必要支付信息
>       - 用户选择付款方式为ping-pong pay，输入信用卡信息，商户前端提交付款信息。

<a name="J2Fia"></a>

#### 发起支付

> - 商户后端处理付款信息，调用v2/payment 接口发起支付。

​<br />
<a name="iJwVL"></a>

#### 处理支付响应结果

> - ping pong server 通过v2/payment 接口响应交易结果。
>    - 商户后端处理记录返回交易结果信息。根据返回empty(response->acsUrl)分成两种情况：
       >
- 非3D交易
  >
- acsUrl 为空或者不返回，此时返回交易结果，商户根据结果处理订单状态
>       - 3D交易
          >
- acsUrl 存在且不为空，商户需要引导用户定向页面到3DS验证
>          - threedDHighLevelParams 为空，直接定向页面到acsUrl
>          - threedDHighLevelParams不为空，提交表单到acsUrl

​<br />

```html
//3DS Form 示例：
<form id="postForm" name="postForm" action="{acsUrl} " method="POST"><input type="hidden" name="PaReq"
                                                                            value=" {paReq}"/>
    <input type="hidden" name="TermUrl" value="{termUrl} "/>
    <input type="hidden" name="MD" value="{md}"/>
    <input type="hidden" name="connector" value="{connector}"/>
    <input type="submit" value="Continue"/>
    <form>
```

```JavaScript
        //3D表单自动提交并跳转示例：
//此方法大意:在发起支付收到接口响应后通过JavaScript 创建一个隐藏的表单，跳转到3DS验证页面
threeDFormSubmit()
{
    if (this.threeDForm.acsUrl === '') {
        return false
    }

    let tmpForm = document.createElement('form')
    tmpForm.action = this.threeDForm.acsUrl
    if (this.threeDForm.requestMethod !== '') {
        tmpForm.method = this.threeDForm.requestMethod
    }
    tmpForm.style.display = 'none'
    tmpForm.style.width = '400px'
    tmpForm.style.height = '400px'
    tmpForm.target = '_self'
    let params = this.threeDForm.threedDHighLevelParams
    for (const key in params) {
        if (key === 'acsUrl' || key === 'requestMethod') {
            continue
        }
        if (!params.hasOwnProperty(key)) {
            continue
        }
        if (params[key] === '' || params[key] === undefined || params[key] === null) {
            continue
        }
        let input = document.createElement('input')
        input.name = key
        input.value = params[key]
        tmpForm.appendChild(input)
    }
    let hiddenFormContainer = document.getElementById('hiddenFormContainer')
    hiddenFormContainer.appendChild(tmpForm)
    console.log(this.threeDTableData)
    debugger
    tmpForm.submit()
}
```

<a name="ebyqy"></a>

### 使用 PHP-SDK

<a name="Mwgko"></a>

#### 自动导入

> 使用composer管理项目依赖：

> - [ ] [安装使用composer](https://pkg.phpcomposer.com/#how-to-install-composer)
> - [ ] 使用命令composer init 初始化你的composer.json(已有composer.json文件 跳过此步骤)
> - [ ] 将SDK拖入vendor 目录
> - [ ] 在你的项目根目录中找到composer.json文件，添加如下自动加载依赖

```json
"autoload": {
"files": [
"./vendor/pppay/vendor/autoload.php"
]
}
```

> - [ ] 运行命令 composer dump-autoload


---

<a name="ed328"></a>

#### 配置SDK

> 新建你的配置类，继承如下抽象类

```PHP
abstract class PPConfigs extends SplBean
{
	public $salt;//md5秘钥
	public $clientId;
	public $accId;//用户accId
	public $gateway;//网关地址
  //以下是pingpong支付状态和商户订单状态的映射关系
	public $stateFailed = 'failed';//pingpong返回Failed时候对应的商户订单状态
	public $stateSuccess = 'processing';//pingpong返回Success状态时候对应的商户订单状态
	public $stateRefunded = 'refunded';//pingpong返回Refunded状态时候对应的商户订单状态
	public $stateProcessing = 'pending';//pingpong返回Processing时候对应的商户订单状态
	public $stateReview = 'on-hold';//pingpong返回Review时候对应的商户订单状态

}
```

<a name="lDWyP"></a>

#### 发起交易请求

- 请求类代码位置

> **Request/S2SPay.php**

- 方法列表

```PHP
//构造方法
public function __construct(PPConfigs $ppConfigs, ServerToServerPayLoad $serverToServerPayLoad)

//请求方法
public function request(?callable $success = null, ?callable $fail = null): PPXS2SPayResponse
```

- 使用示例

```PHP
	  //获取配置信息
		$configs = ConfigHelper::getConfig($s2sPayDTO->serverEnv);
		$payLoad = $this->getPayLoad($s2sPayDTO, $configs);
		$req = new S2SPay($configs, $payLoad);
		$req->setHttpClientDriver(CoHttpClient::class);
		$response = $req->request();
```

- 返回结果数据模型

```PHP

/**
 * Class PPXS2SPayResponse
 * @package PingPong\src\Response
 */
class PPXS2SPayResponse extends HttpResponse
{
	public $clientId = '';
	public $accId = '';
	public $transactionId = '';
	public $merchantTransactionId = '';
	public $code = '';
	public $description = '';
	public $paymentType = '';
	public $currency = '';
	public $amount = '';
	public $transactionTime = '';
	public $completeTime = '';
	public $status = '';
	public $signType = '';
	public $sign = '';
	public $remark;
	public $threeDSecure = '';
	public $acsUrl = '';
	public $paReq;
	public $termUrl = '';
	public $requestMethod = '';
	public $md = '';
	public $connector = '';
	public $threedDHighLevelParams = '';


}
```

<a name="zdjf7"></a>

## 附录

<a name="AkVAU"></a>

### payment表结构参考

<a name="NFFaR"></a>

#### 建表SQL

```sql
create table ping_pong_payment_log
(
    id              bigint auto_increment comment 'ID'
        primary key,
    order_id        bigint                             not null comment 'order_id',
    transaction_id  varchar(160)                       not null,
    pp_status       varchar(30)                        not null comment 'status',
    description     varchar(255)                       not null,
    query_response  text                               not null comment 'query response',
    notify_response text                               not null comment 'notify response',
    date_add        datetime default CURRENT_TIMESTAMP not null,
    constraint uq_transaction_id
        unique (transaction_id)
)
    comment 'ping_pong_payment_log';
```

<a name="Turgu"></a>

#### 异步通知实现参考

```php
	/**
	 * 异步回调处理
	 * @return string
	 * @throws Exception
	 */
	public function notify(): string
	{
		//从流中获取数据
		$notifyString = file_get_contents('php://input');
		if ( empty($notifyString) ) {
			return 'fail';
		}
		//调用SDK 方法验签 当前请求是否来自ping-pong server
		$notifyResponse = Notify::isPingPongPay($this->config, $notifyString);
    
		(new CheckTransaction($this->config))->change($notifyResponse->getMerchantTransactionId(), $notifyResponse);

		return 'ok';
	}
```

```PHP
/**
	 * @param string $merchantTransactionId
	 * @param AbstractPPXResponse $response
	 * @throws Exception
	 */
	public function change(string $merchantTransactionId, AbstractPPXResponse $response): void
	{
    //从ping_pong_payment_log表中查询
		$pingPongPayment = new PingPongPayment();
		//获取当前交易号支付记录
		$data = $pingPongPayment->getOne($response->getTransactionId());
		$order = wc_get_order($merchantTransactionId);
		if ( empty($order) || ((!$order instanceof OrderRefund) && (!$order instanceof Order)) ) {
			throw new Exception('order not found');
		}
    
		//初始化状态变量
		$pingPongServerState = $response->getStatus();
		$localDBState = $data['pp_status'] ?? null;
		//当前交易尚未有记录 设置默认状态为pending
		if ( empty($data) ) {
			$localDBState = PPConst::STATUS_ORDER_PENDING;
		}
		//根据ping pong server 返回的状态检查是否需要改变订单状态
		//获取配置中ping-pong返回状态对应的订单状态 并将当前的订单状态修改成映射的订单状态
		$canChange = (new OrderStateChange($this->config))->canChange($pingPongServerState, $localDBState);
		//状态在允许修改的范围并且当前交易号没有记录-新增修改状态
		if ( $canChange === true ) {
			$this->setOrderStatus($order, $response);
		}

		$queryResponse = json_encode(new \StdClass(), JSON_THROW_ON_ERROR);
		$notifyResponse = '';
		if ( $response instanceof PPXQueryResponse ) {
			$queryResponse = $response;
		}
		if ( $response instanceof PPXNotifyResponse ) {
			$notifyResponse = file_get_contents('php://input');
		}

		//设置payment信息 到ping_pong_payment_log表 不存在新增 存在更新 
		$pingPongPayment->setPayment(
			$response->getTransactionId(),
			[
				'order_id' => $merchantTransactionId,
				'transaction_id' => $response->getTransactionId(),
				'pp_status' => $response->getStatus(),
				'description' => $response->getDescription(),
				'query_response' => $queryResponse,
				'notify_response' => $notifyResponse
			]
		);
	}
```

<?
// error_reporting( E_ALL );
// ini_set( "display_errors", 1 );
include "../include/get_balance.php";
include "../include/login_check.php";





// print_r($_SESSION);
//echo $_SESSION['connect_check']."1212";

//=========== 중복 결제 확인 삭제 =====================
//$result = session_unregister("connect_check");
unset($_SESSION["connect_check"]);
$session_cart = $_SESSION['session_cart'];

//=====================================================

include "cartfunc.php";
include_once dirname(__FILE__) . '/../lib/icopay_pg_config.php';
$icopay_unified_ui = (defined('ICOPAY_UNIFIED_ENABLED') && ICOPAY_UNIFIED_ENABLED);
$icopay_chill_cfg = null;
if (!$icopay_unified_ui && is_file(dirname(__FILE__) . '/lib_icopay_chillpay.php')) {
	include_once dirname(__FILE__) . '/lib_icopay_chillpay.php';
	if (defined('ICOPAY_CHILLPAY_ENABLED') && ICOPAY_CHILLPAY_ENABLED && function_exists('icopay_chillpay_fetch_pg_config')) {
		$icopay_chill_cfg = icopay_chillpay_fetch_pg_config();
	}
}
$icopay_ccd_script = 'https://cdn.chill.credit/js/ccdpayment.js';
$icopay_merchant_code = '';
$icopay_api_key = '';
if (is_array($icopay_chill_cfg)) {
	if (!empty($icopay_chill_cfg['ccdScriptUrl'])) {
		$icopay_ccd_script = (string)$icopay_chill_cfg['ccdScriptUrl'];
	}
	$icopay_merchant_code = isset($icopay_chill_cfg['merchantCode']) ? (string)$icopay_chill_cfg['merchantCode'] : '';
	$icopay_api_key = isset($icopay_chill_cfg['apiKey']) ? (string)$icopay_chill_cfg['apiKey'] : '';
}
if ($icopay_merchant_code === '' && defined('ICOPAY_CCD_MERCHANT_CODE') && ICOPAY_CCD_MERCHANT_CODE !== '') {
	$icopay_merchant_code = ICOPAY_CCD_MERCHANT_CODE;
}
if ($icopay_api_key === '' && defined('ICOPAY_CCD_API_KEY') && ICOPAY_CCD_API_KEY !== '') {
	$icopay_api_key = ICOPAY_CCD_API_KEY;
}
$icopay_chillpay_ui = (!$icopay_unified_ui && defined('ICOPAY_CHILLPAY_ENABLED') && ICOPAY_CHILLPAY_ENABLED && $icopay_merchant_code !== '' && $icopay_api_key !== '');
$icopay_allow_legacy_kspay = !empty($GLOBALS['ICOPAY_USE_KSPAY_CARD']);
$icopay_load_kspay = false;
if ($icopay_unified_ui || $icopay_chillpay_ui || (defined('ICOPAY_CHILLPAY_ENABLED') && ICOPAY_CHILLPAY_ENABLED)) {
	$icopay_load_kspay = false;
} elseif ($icopay_allow_legacy_kspay) {
	$icopay_load_kspay = true;
}

//echo $session_cart;
//exit;

/*
$query = "SELECT coin_price FROM $coin_goods order by no desc";
$result = mysql_query($query,$DBconn);
$value = mysql_fetch_row($result);
$exchange = $value[0];
*/

$order_kk = $_GET['order_kk'];
$buyselected = $_GET['buyselected'];

if ($buyselected == 'Y') {
    //선택주문
    $session_cart = $session_cart_selected;
} else if ($order_kk == "Y") {
    //바로주문
    $ss_dis = time();

    // echo curl_d($api_category,"&Type=cartCount");
    $crts = json_decode(curl_d($api_category, "&Type=cartCount"), true);
    $total_su = (is_array($crts) && isset($crts[0]['soo'])) ? $crts[0]['soo'] : '0';

    if ($total_su == '0') {

        curl_d($api_category, "&Type=cartSave&session_cart=$session_cart");
    } else {

        if ($session_cart != "") {

            curl_d($api_category, "&Type=cartUpdate&session_cart=$session_cart");
        }
    }
} else {
    //전체주문
}

?>
<!doctype html>
<html lang="en">

<head>
<?php
$pkshop_head_style = 'shop';
$pkshop_page_title = 'Order';
include dirname(__FILE__) . '/../include/pkshop_html_head.php';
?>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">

    <!-- <link rel="stylesheet" href="../include/reset.css">
  <link rel="stylesheet" href="../include/style.css"> -->
    <?
    if ($session_cart == "") {
        popup_msg("There is no product you chose in the shopping basket.");
    ?>
        <script>
            location.href = '../main/main.html';
        </script>
    <?
        exit;
    }

    #####################################################################



    // $DB->get("SELECT C_NAME,C_EMAIL,C_HAND,C_HAND,c_point from $member_table WHERE c_id='$valid_user'",$mems,$memn);

    $name        = isset($json_balance['name']) ? $json_balance['name'] : '';
    $name_full   = trim((string)$name);
    $buyername_default = $name_full;
    $buyername_l_default = '';
    if ($name_full !== '' && preg_match('/^(\S+)\s+(.+)$/u', $name_full, $__nm_split)) {
        $buyername_l_default = $__nm_split[1];
        $buyername_default = trim($__nm_split[2]);
    }

    $email        = isset($json_balance['email']) ? $json_balance['email'] : '';
    $zip        = isset($json_balance['zip']) ? $json_balance['zip'] : '';
    $address    = isset($json_balance['address']) ? $json_balance['address'] : '';
    $tel        = isset($json_balance['hand']) ? $json_balance['hand'] : '';
    $handphone  = isset($json_balance['hand']) ? $json_balance['hand'] : '';
    $c_zip  = isset($json_balance['c_zip']) ? $json_balance['c_zip'] : '';
    $c_addr  = isset($json_balance['c_addr']) ? $json_balance['c_addr'] : '';
    $c_addr2  = isset($json_balance['c_addr2']) ? $json_balance['c_addr2'] : '';
    $point      = isset($json_balance['c_point']) ? $json_balance['c_point'] : 0;
    // $point		= $json_balance['c_point'];
    $kk_point = $point;


    // $DB->get("SELECT sum(Point) as point_cur FROM $shop_point WHERE Cid='$valid_user'",$pnts,$pntn);

    // $point_cur = $pnts[0]['point_cur'];
    // $kk_point=$point_cur;

    // if($kk_point==""){
    // 	$kk_point=0;
    // }
    #####################################################################
    ?>
    <!-- <script type="text/javascript" src="../include/js/jquery-1.12.2.min.js"></script> -->
    <style>
        #popupDiv {
            /* 팝업창 css */
            top: 0px;
            position: absolute;
            background: #ffffff;
            width: 500px;
            height: 200px;
            display: none;
        }

        #popCloseBtn {
            border: none;
            /* text-align: right; */
            float: right;
            clear: both;
            margin-right: 2%;
            margin-top: 2%;
            padding: 1%;
            color: #fff;
            background-color: #1fa0e8;
            cursor: pointer;
        }

        #popup_mask {
            /* 팝업 배경 css */
            position: fixed;
            width: 100%;
            height: 1000px;
            top: 0px;
            left: 0px;
            display: none;
            background-color: #000;
            opacity: 0.8;
        }
    </style>
    <?php if (!empty($icopay_load_kspay)) { ?>
    <script language="javascript" src="https://kspay.ksnet.to/store/KSPayWebV1.4/js/kspay_web_ssl.js"></script>
    <?php } ?>
    <!-- <script src="https://api.payster.co.kr/js/pgAsistant.js"></script> -->
    <script type="text/javascript">

            var ICOPAY_UNIFIED_ACTIVE = <?php echo $icopay_unified_ui ? 'true' : 'false'; ?>;
            var ICOPAY_CHILLPAY_ACTIVE = <?php echo $icopay_chillpay_ui ? 'true' : 'false'; ?>;
            var ICOPAY_API_BASE = <?php echo json_encode(defined('ICOPAY_PUBLIC_BASE') ? ICOPAY_PUBLIC_BASE : 'https://api.icopay.co.kr', JSON_UNESCAPED_SLASHES); ?>;
            var ICOPAY_CHECKOUT_LANG = <?php echo json_encode(defined('ICOPAY_CHECKOUT_LANG') ? ICOPAY_CHECKOUT_LANG : 'JPN', JSON_UNESCAPED_UNICODE); ?>;
            <?php if (!empty($icopay_chillpay_ui)) { ?>
            var ICOPAY_CCD_CONFIG = {
                scriptUrl: <?php echo json_encode($icopay_ccd_script, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>,
                merchantCode: <?php echo json_encode($icopay_merchant_code, JSON_UNESCAPED_UNICODE); ?>,
                apiKey: <?php echo json_encode($icopay_api_key, JSON_UNESCAPED_UNICODE); ?>,
                lang: <?php echo json_encode(defined('ICOPAY_CCD_LANG') ? (string)ICOPAY_CCD_LANG : 'en', JSON_UNESCAPED_UNICODE); ?>
            };
            <?php } ?>
            <?php if (empty($icopay_load_kspay)) { ?>
            function _pay(_frm) {
                <?php if (!empty($icopay_unified_ui)) { ?>
                return;
                <?php } elseif (!empty($icopay_chillpay_ui)) { ?>
                return;
                <?php } elseif (defined('ICOPAY_CHILLPAY_ENABLED') && ICOPAY_CHILLPAY_ENABLED) { ?>
                alert("Icopay is configured but ChillPay CCD credentials could not be loaded.\\nCheck server access to https://api.icopay.co.kr or set ICOPAY_CCD_MERCHANT_CODE and ICOPAY_CCD_API_KEY in lib/icopay_pg_secrets.local.php.");
                <?php } else { ?>
                alert("Card payment requires ICOPAY.\\nSet ICOPAY_COMP_ID and ICOPAY_BROKER_SECRET in lib/icopay_pg_secrets.local.php.");
                <?php } ?>
            }
            if (typeof window.payResultSubmit !== "function") {
                window.payResultSubmit = function() {
                    try {
                        if (document.join) {
                            document.join.target = "";
                            document.join.action = "./finish.php";
                            document.join.submit();
                        }
                    } catch (e1) {}
                };
            }
            <?php } ?>

            function icopayUnifiedEnsureHost() {
                var host = document.getElementById('icopayUnifiedHost');
                if (host) {
                    return host;
                }
                var wrap = document.getElementById('icopayUnifiedEmbed');
                if (!wrap) {
                    return null;
                }
                host = document.createElement('div');
                host.id = 'icopayUnifiedHost';
                host.style.minHeight = '400px';
                host.style.width = '100%';
                wrap.appendChild(host);
                return host;
            }

            function icopayUnifiedResolveEmbedConfig(orderJson) {
                if (!orderJson) {
                    return null;
                }
                if (orderJson.embed && orderJson.embed.src && orderJson.embed.sessionToken) {
                    return orderJson.embed;
                }
                var src = orderJson.embedSrc || '';
                var sessionToken = orderJson.embedSessionToken || orderJson.sessionToken || '';
                var target = orderJson.embedTarget || 'icopayUnifiedHost';
                var lang = orderJson.embedLang || '';
                if (src && sessionToken) {
                    return { src: src, sessionToken: sessionToken, target: target, lang: lang };
                }
                if (typeof orderJson.embedHtml === 'string' && orderJson.embedHtml) {
                    try {
                        var doc = new DOMParser().parseFromString(orderJson.embedHtml, 'text/html');
                        var oldScript = doc.querySelector('script');
                        if (oldScript && oldScript.getAttribute('src')) {
                            return {
                                src: oldScript.getAttribute('src'),
                                sessionToken: oldScript.getAttribute('data-session-token') || sessionToken,
                                target: oldScript.getAttribute('data-target') || target,
                                lang: oldScript.getAttribute('data-lang') || lang
                            };
                        }
                    } catch (eParse) {}
                }
                return null;
            }

            function icopayUnifiedResolveIframeUrl(orderJson) {
                if (!orderJson) {
                    return '';
                }
                var url = orderJson.iframeUrl || orderJson.payUrl || '';
                if (url && url.indexOf('/checkout/') !== -1) {
                    url = url.replace(/\/checkout\/[^?]+/, '/jpay-pay.html');
                }
                return url;
            }

            function icopayUnifiedIframeHeightPx() {
                if (window.innerWidth >= 768) {
                    return 638;
                }
                return Math.max(480, Math.min(620, Math.round(window.innerHeight * 0.68)));
            }

            function icopayUnifiedApplyIframeLayout(iframe) {
                if (!iframe) {
                    return;
                }
                var h = icopayUnifiedIframeHeightPx();
                var isDesktop = window.innerWidth >= 768;
                iframe.style.display = 'block';
                iframe.style.width = '100%';
                iframe.style.height = h + 'px';
                iframe.style.minHeight = h + 'px';
                iframe.style.maxHeight = isDesktop ? h + 'px' : '72vh';
                iframe.style.border = '0';
                iframe.style.background = '#fff';
                iframe.style.borderRadius = '12px';
                iframe.style.overflow = 'hidden';
                iframe.setAttribute('scrolling', isDesktop ? 'no' : 'auto');
            }

            function icopayUnifiedMountIframe(host, frameUrl) {
                host.removeAttribute('data-icopay-checkout-mounted');
                host.innerHTML = '';
                var iframe = document.createElement('iframe');
                iframe.id = 'icopayUnifiedFrame';
                iframe.title = 'ICOPAY secure checkout';
                iframe.src = frameUrl;
                iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');
                iframe.setAttribute('allow', 'payment *');
                icopayUnifiedApplyIframeLayout(iframe);
                host.appendChild(iframe);
                if (!window.__icopayUnifiedResizeBound) {
                    window.__icopayUnifiedResizeBound = true;
                    window.addEventListener('resize', function() {
                        var frame = document.getElementById('icopayUnifiedFrame');
                        if (frame) {
                            icopayUnifiedApplyIframeLayout(frame);
                        }
                    });
                }
                return true;
            }

            function icopayUnifiedInjectEmbed(orderJson) {
                var host = icopayUnifiedEnsureHost();
                if (!host) {
                    return false;
                }
                var wrap = host.parentNode || document.getElementById('icopayUnifiedEmbed');
                if (!wrap) {
                    return false;
                }
                var oldScript = document.getElementById('icopayUnifiedEmbedScript');
                if (oldScript && oldScript.parentNode) {
                    oldScript.parentNode.removeChild(oldScript);
                }
                var frameUrl = icopayUnifiedResolveIframeUrl(orderJson);
                if (frameUrl) {
                    return icopayUnifiedMountIframe(host, frameUrl);
                }
                var cfg = icopayUnifiedResolveEmbedConfig(orderJson);
                if (!cfg || !cfg.src || !cfg.sessionToken) {
                    return false;
                }
                host.innerHTML = '';
                var s = document.createElement('script');
                s.id = 'icopayUnifiedEmbedScript';
                s.src = cfg.src;
                s.charset = 'utf-8';
                s.setAttribute('data-session-token', cfg.sessionToken);
                s.setAttribute('data-target', cfg.target || 'icopayUnifiedHost');
                var embedLang = cfg.lang || ICOPAY_CHECKOUT_LANG || '';
                if (embedLang) {
                    s.setAttribute('data-lang', embedLang);
                }
                s.onerror = function() {
                    alert('Could not load the ICOPAY payment window. Please try again in a moment.');
                    icopayUnifiedCloseModal();
                };
                if (host.nextSibling) {
                    wrap.insertBefore(s, host.nextSibling);
                } else {
                    wrap.appendChild(s);
                }
                return true;
            }

            function icopayUnifiedCloseModal() {
                $("#icopayUnifiedModal").css("display", "none");
                $("#popup_mask").css("display", "none");
                $("body").css("overflow", "auto");
                $("#icopayUnifiedStatus").css("display", "none");
                var oldScript = document.getElementById('icopayUnifiedEmbedScript');
                if (oldScript && oldScript.parentNode) {
                    oldScript.parentNode.removeChild(oldScript);
                }
                var host = document.getElementById('icopayUnifiedHost');
                if (host) {
                    host.removeAttribute('data-icopay-checkout-mounted');
                    host.innerHTML = '';
                }
            }

            function icopayUnifiedBindPostMessage(orderInfo) {
                if (window.__icopayUnifiedListenerBound) {
                    return;
                }
                window.__icopayUnifiedListenerBound = true;
                var handler = function(detail) {
                    if (!detail) {
                        return;
                    }
                    if (detail.phase === 'finished' && detail.success) {
                        $.ajax({
                            type: 'POST',
                            url: './icopay_unified_confirm.php',
                            contentType: 'application/json; charset=utf-8',
                            data: JSON.stringify({
                                orderNo: orderInfo.orderNo,
                                ediDate: orderInfo.ediDate
                            }),
                            dataType: 'json',
                            success: function(res) {
                                if (res && res.success) {
                                    icopayUnifiedCloseModal();
                                    window.location.href = './icopay_unified_return.php?success=1&orderNo=' + encodeURIComponent(orderInfo.orderNo) + '&tid=' + encodeURIComponent(res.tid || orderInfo.orderNo);
                                } else {
                                    alert((res && res.message) ? res.message : 'Payment confirmation failed.');
                                }
                            },
                            error: function() {
                                alert('Network error while confirming payment.');
                            }
                        });
                    } else if (detail.phase === 'finished' && detail.success === false) {
                        alert('Payment was not completed.');
                        icopayUnifiedCloseModal();
                    }
                };
                if (typeof IcopayCheckout !== 'undefined' && IcopayCheckout.onMessage) {
                    IcopayCheckout.onMessage(handler, ICOPAY_API_BASE);
                } else {
                    window.addEventListener('message', function(ev) {
                        if (!ev || !ev.data || ev.data.type !== 'ICOPAY_INLINE_CHECKOUT') {
                            return;
                        }
                        handler(ev.data.detail || {});
                    }, false);
                }
            }

            function icopayUnifiedStartFromCart() {
                $("#popup_mask").css("display", "block");
                $("#icopayUnifiedModal").css("display", "flex");
                $("#icopayUnifiedStatus").css("display", "block").text('Preparing payment…');
                icopayUnifiedEnsureHost();
                var host = document.getElementById('icopayUnifiedHost');
                if (host) {
                    host.innerHTML = '';
                }
                $("body").css("overflow", "hidden");
                $.ajax({
                    type: 'POST',
                    url: './order_ok2.php',
                    data: $('#join').serialize(),
                    dataType: 'text',
                    success: function(txt) {
                        var j = null;
                        try {
                            j = JSON.parse(txt);
                        } catch (e1) {
                            icopayUnifiedCloseModal();
                            var snip = (typeof txt === 'string') ? txt.replace(/^\s+/, '').slice(0, 280) : '';
                            alert('Order save returned invalid JSON.\\n\\n' + snip);
                            return;
                        }
                        if (!j || !j.icopayUnified || (!j.iframeUrl && !j.payUrl && !j.embed && !j.embedHtml && !j.embedSrc && !j.sessionToken)) {
                            icopayUnifiedCloseModal();
                            alert((j && j.msg) ? j.msg : 'Cannot start ICOPAY checkout. Select CARD and ensure the order is not fully paid with points.');
                            return;
                        }
                        window.__icopayCartOrder = j;
                        $("#icopayUnifiedStatus").css("display", "none");
                        if (!icopayUnifiedInjectEmbed(j)) {
                            icopayUnifiedCloseModal();
                            alert('Could not load the ICOPAY payment script.');
                            return;
                        }
                        icopayUnifiedBindPostMessage(j);
                    },
                    error: function() {
                        icopayUnifiedCloseModal();
                        alert('Network error while saving order.');
                    }
                });
            }

            function icopayChillpayClearCcdFallbackTimer() {
                try {
                    if (window.__icopayCcdFallbackTimer) {
                        clearTimeout(window.__icopayCcdFallbackTimer);
                        window.__icopayCcdFallbackTimer = null;
                    }
                } catch (eT) {}
            }

            function icopayChillpayShowPayButtonAfterCcdReady() {
                if (window.__icopayCcdPayButtonShown) {
                    return;
                }
                if (typeof ccdinline === 'undefined' || !ccdinline.CreatePaymentCreditToken) {
                    return;
                }
                window.__icopayCcdPayButtonShown = true;
                icopayChillpayClearCcdFallbackTimer();
                $("#icopayChillpayCcdStatus").css("display", "none");
                $("#icopayChillpayPayBtn").css("display", "block");
            }

            /**
             * 주문서 firstName(buyername)·Last Name(buyername_l) 중 하나만 있을 때 공백으로 나눔.
             * 규칙: 첫 번째 단어 → Last Name, 나머지 → First Name (예: "YI BYOUNGSUN" → 성 YI / 이름 BYOUNGSUN).
             */
            function icopayChillpaySyncBuyerNameFields(jn) {
                if (!jn || !jn.buyername || !jn.buyername_l) {
                    return;
                }
                var fn = String(jn.buyername.value != null ? jn.buyername.value : '').trim();
                var ln = String(jn.buyername_l.value != null ? jn.buyername_l.value : '').trim();
                if (fn && ln) {
                    return;
                }
                if (fn && !ln) {
                    var p = fn.split(/\s+/).filter(function (x) {
                        return x.length;
                    });
                    if (p.length >= 2) {
                        jn.buyername_l.value = p[0];
                        jn.buyername.value = p.slice(1).join(' ');
                    } else {
                        jn.buyername_l.value = fn;
                    }
                    return;
                }
                if (ln && !fn) {
                    var q = ln.split(/\s+/).filter(function (x) {
                        return x.length;
                    });
                    if (q.length >= 2) {
                        jn.buyername_l.value = q[0];
                        jn.buyername.value = q.slice(1).join(' ');
                    } else {
                        jn.buyername.value = ln;
                    }
                }
            }

            function icopayChillpayMergeRecipientIntoBuyerIfNeeded(jn) {
                if (!jn || !jn.buyername || !jn.buyername_l) {
                    return;
                }
                if (!jn.recvname || !jn.recvname_l) {
                    return;
                }
                var fn = String(jn.buyername.value != null ? jn.buyername.value : '').trim();
                var ln = String(jn.buyername_l.value != null ? jn.buyername_l.value : '').trim();
                if (fn && ln) {
                    return;
                }
                var rfn = String(jn.recvname.value != null ? jn.recvname.value : '').trim();
                var rln = String(jn.recvname_l.value != null ? jn.recvname_l.value : '').trim();
                if (!fn && rfn) {
                    jn.buyername.value = rfn;
                }
                if (!ln && rln) {
                    jn.buyername_l.value = rln;
                }
            }

            function icopayChillpaySyncAllPayerFields(jn) {
                icopayChillpaySyncBuyerNameFields(jn);
                icopayChillpayMergeRecipientIntoBuyerIfNeeded(jn);
                icopayChillpaySyncBuyerNameFields(jn);
            }

            function icopayChillpayCcdReceiver(eventId, subId, data) {
                if (eventId === 'Initialized') {
                    icopayChillpayShowPayButtonAfterCcdReady();
                    return;
                }
                if (eventId === 'CreateTokenSucceed') {
                    var tok = (data && data.PaymentCreditToken) ? data.PaymentCreditToken : '';
                    var ord = window.__icopayCartOrder;
                    if (!tok || !ord) {
                        $("#icopayChillpayPayBtn").prop("disabled", false);
                        return;
                    }
                    $.ajax({
                        url: './icopay_chillpay_pay.php',
                        method: 'POST',
                        contentType: 'application/json; charset=utf-8',
                        data: JSON.stringify({
                            merchantOrderId: ord.ediDate,
                            paymentCreditToken: tok,
                            payerEmail: document.join.email.value,
                            payerPhone: String(document.join.htel.value || '').replace(/\D/g, '').slice(0, 15),
                            payerFirstName: document.join.buyername.value,
                            payerLastName: document.join.buyername_l.value,
                            description: ord.description || 'Order'
                        }),
                        dataType: 'json',
                        success: function(res) {
                            $("#icopayChillpayCcdStatus").css("display", "none");
                            if (res && res.success && res.paymentUrl) {
                                $("#popup_mask").css("display", "none");
                                $("#icopayChillpayModal").css("display", "none");
                                window.location.href = res.paymentUrl;
                            } else {
                                $("#icopayChillpayPayBtn").prop("disabled", false);
                                $("#popup_mask").css("display", "block");
                                $("#icopayChillpayModal").css("display", "block");
                                alert((res && res.message) ? res.message : 'Payment request failed. Please try again.');
                            }
                        },
                        error: function() {
                            $("#icopayChillpayPayBtn").prop("disabled", false);
                            $("#icopayChillpayCcdStatus").css("display", "none");
                            $("#popup_mask").css("display", "block");
                            $("#icopayChillpayModal").css("display", "block");
                            alert('A network error occurred while contacting the payment server.');
                        }
                    });
                } else if (eventId === 'CreateTokenFailed' || eventId === 'CreateTokenError') {
                    $("#icopayChillpayCcdStatus").css("display", "none");
                    $("#icopayChillpayPayBtn").prop("disabled", false);
                    $("#popup_mask").css("display", "block");
                    $("#icopayChillpayModal").css("display", "block");
                    $("body").css("overflow", "hidden");
                    var detail = '';
                    try {
                        detail = (typeof subId !== 'undefined' && subId !== '' && subId !== null) ? (' [' + subId + ']') : '';
                        if (data) {
                            detail += '\n' + (typeof data === 'string' ? data : JSON.stringify(data)).slice(0, 500);
                        }
                    } catch (eDbg) {}
                    var hint = '\n\nPlease verify:\n· Card number, expiry (MM/YY), CVV, and cardholder name\n· Consent checkbox is checked\n· ICOPAY_CCD_LANG matches your merchant region (e.g. en)\n· Allowed domain and API keys at Icopay/ChillPay';
                    if (/invalid\s*input/i.test(detail) || /\[-1\]/.test(detail)) {
                        hint = '\n\nChillPay rejected the card input (Invalid Input).\nPlease review the fields above and click Proceed Payment again.' + hint;
                    }
                    alert('Could not create card token.' + detail + hint);
                }
            }

            function icopayChillpaySubmitToken() {
                var jn = document.join;
                if (!jn) {
                    alert('Order form not found.');
                    return;
                }
                icopayChillpaySyncAllPayerFields(jn);
                var fn = String(jn.buyername && jn.buyername.value != null ? jn.buyername.value : '').trim();
                var ln = String(jn.buyername_l && jn.buyername_l.value != null ? jn.buyername_l.value : '').trim();
                if (!fn || !ln) {
                    alert('Please enter the payer First Name and Last Name on the order form.\nIf your full name is in one field, separate first and last with a space.');
                    icopayChillpayCloseModal();
                    try {
                        if (!ln && jn.buyername_l) {
                            jn.buyername_l.focus();
                        } else if (!fn && jn.buyername) {
                            jn.buyername.focus();
                        } else if (jn.buyername_l) {
                            jn.buyername_l.focus();
                        } else if (jn.buyername) {
                            jn.buyername.focus();
                        }
                    } catch (eFoc) {}
                    return;
                }
                if (typeof ccdinline === 'undefined' || !ccdinline.CreatePaymentCreditToken) {
                    alert('Card form is not ready yet.');
                    return;
                }
                $("#icopayChillpayPayBtn").prop("disabled", true);
                var ok = false;
                try {
                    ok = !!ccdinline.CreatePaymentCreditToken();
                } catch (eTok) {
                    ok = false;
                }
                if (!ok) {
                    $("#icopayChillpayPayBtn").prop("disabled", false);
                    alert('Card fields are not ready. Please wait a moment and try again.');
                }
            }

            function icopayChillpayResetCcdDom() {
                try {
                    ['ccdinline-card-name', 'ccdinline-card-number', 'ccdinline-card-expiry', 'ccdinline-card-cvv', 'ccdinline-card-remember'].forEach(function(id) {
                        var el = document.getElementById(id);
                        if (el) {
                            el.innerHTML = '';
                        }
                    });
                } catch (e1) {}
            }

            function icopayChillpayEnsureCcdScript(onScriptReady) {
                if (typeof ICOPAY_CCD_CONFIG === 'undefined') {
                    $("#icopayChillpayCcdStatus").css("display", "none");
                    $("#popup_mask").css("display", "none");
                    $("#icopayChillpayModal").css("display", "none");
                    $("body").css("overflow", "auto");
                    alert('ChillPay CCD configuration is missing.');
                    return;
                }
                var form = document.getElementById('icopayCcdForm');
                if (!form) {
                    $("#icopayChillpayCcdStatus").css("display", "none");
                    $("#popup_mask").css("display", "none");
                    $("#icopayChillpayModal").css("display", "none");
                    $("body").css("overflow", "auto");
                    alert('Payment form container not found.');
                    return;
                }
                var existing = document.getElementById('icopayCcdInlineScript');
                if (existing && typeof ccdinline !== 'undefined' && ccdinline.CreatePaymentCreditToken) {
                    onScriptReady();
                    return;
                }
                if (existing) {
                    existing.parentNode.removeChild(existing);
                }
                try {
                    delete window.ccdinline;
                } catch (e2) {
                    try {
                        window.ccdinline = undefined;
                    } catch (e3) {}
                }
                icopayChillpayResetCcdDom();
                var ccdSrc = String(ICOPAY_CCD_CONFIG.scriptUrl || '').trim();
                if (ccdSrc.indexOf('cdn.chill.credit') !== -1) {
                    if (ccdSrc.indexOf('//') === 0) {
                        ccdSrc = 'https:' + ccdSrc;
                    } else if (/^http:\/\//i.test(ccdSrc)) {
                        ccdSrc = ccdSrc.replace(/^http:/i, 'https:');
                    }
                }
                if (!/^https:\/\/cdn\.chill\.credit/i.test(ccdSrc)) {
                    ccdSrc = 'https://cdn.chill.credit/js/ccdpayment.js';
                }
                var s = document.createElement('script');
                s.id = 'icopayCcdInlineScript';
                s.async = false;
                s.src = ccdSrc;
                s.setAttribute('data-merchant-code', ICOPAY_CCD_CONFIG.merchantCode);
                s.setAttribute('data-api-key', ICOPAY_CCD_CONFIG.apiKey);
                s.setAttribute('data-callback-event-receiver', 'icopayChillpayCcdReceiver');
                s.setAttribute('data-auto-create-payment-credit-token-on-submit', 'false');
                s.setAttribute('data-lang', ICOPAY_CCD_CONFIG.lang || 'en');
                s.onload = function() {
                    try {
                        if (typeof document.onreadystatechange === 'function') {
                            document.onreadystatechange();
                        }
                    } catch (eRs) {}
                    onScriptReady();
                };
                s.onerror = function() {
                    $("#icopayChillpayCcdStatus").css("display", "none");
                    $("#popup_mask").css("display", "none");
                    $("#icopayChillpayModal").css("display", "none");
                    $("body").css("overflow", "auto");
                    alert('Could not load ChillPay card script (CDN). Check network or ad blocker.');
                };
                form.insertBefore(s, form.firstChild);
            }

            function icopayChillpayStartFromCart() {
                window.__icopayCcdPayButtonShown = false;
                icopayChillpayClearCcdFallbackTimer();
                $("#icopayChillpayPayBtn").css("display", "none").prop("disabled", false);
                $("#popup_mask").css("display", "block");
                $("#icopayChillpayModal").css("display", "block");
                $("#icopayChillpayCcdStatus").css("display", "block");
                $("body").css("overflow", "hidden");
                $.ajax({
                    type: 'POST',
                    url: './order_ok2.php',
                    data: $('#join').serialize(),
                    dataType: 'text',
                    success: function(txt) {
                        var j = null;
                        try {
                            j = JSON.parse(txt);
                        } catch (e1) {
                            $("#icopayChillpayCcdStatus").css("display", "none");
                            $("#popup_mask").css("display", "none");
                            $("#icopayChillpayModal").css("display", "none");
                            $("body").css("overflow", "auto");
                            var snip = (typeof txt === 'string') ? txt.replace(/^\s+/, '').slice(0, 280) : '';
                            alert('Order save returned invalid JSON. Check server output for PHP warnings.\n\n' + snip);
                            return;
                        }
                        if (!j || !j.icopayChillpay) {
                            $("#icopayChillpayCcdStatus").css("display", "none");
                            $("#popup_mask").css("display", "none");
                            $("#icopayChillpayModal").css("display", "none");
                            $("body").css("overflow", "auto");
                            alert('Cannot start card payment. Select CARD as payment method and ensure the order total is not paid entirely with points.');
                            return;
                        }
                        window.__icopayCartOrder = j;
                        window.__icopayCcdPayButtonShown = false;
                        $("#icopayChillpayPayBtn").css("display", "none").prop("disabled", false);
                        icopayChillpayClearCcdFallbackTimer();
                        icopayChillpaySyncAllPayerFields(document.join);
                        icopayChillpayEnsureCcdScript(function() {
                            window.requestAnimationFrame(function() {
                                window.requestAnimationFrame(function() {
                                    $("#icopayChillpayCcdStatus").text('Loading card fields…');
                                    window.__icopayCcdFallbackTimer = setTimeout(function() {
                                        window.__icopayCcdFallbackTimer = null;
                                        if (window.__icopayCcdPayButtonShown) {
                                            return;
                                        }
                                        if (typeof ccdinline !== 'undefined' && ccdinline.CreatePaymentCreditToken) {
                                            icopayChillpayShowPayButtonAfterCcdReady();
                                        } else {
                                            $("#icopayChillpayCcdStatus").css("display", "none");
                                            $("#popup_mask").css("display", "none");
                                            $("#icopayChillpayModal").css("display", "none");
                                            $("body").css("overflow", "auto");
                                            alert('Could not load the card form. Please refresh the page and try again.');
                                        }
                                    }, 2800);
                                });
                            });
                        });
                    },
                    error: function() {
                        $("#icopayChillpayCcdStatus").css("display", "none");
                        $("#popup_mask").css("display", "none");
                        $("#icopayChillpayModal").css("display", "none");
                        $("body").css("overflow", "auto");
                        alert('Network error while saving order.');
                    }
                });
            }

            function _submit(_frm)
            {
                if (typeof ICOPAY_CHILLPAY_ACTIVE !== 'undefined' && ICOPAY_CHILLPAY_ACTIVE) {
                    alert('Card payment uses ChillPay (Icopay). Please use the green Order button in the card section.');
                    return;
                }
                _frm.sndReply.value = getLocalUrl("wh_rcv.php") ;

                _pay(_frm);
            }
            function getLocalUrl(mypage)
            {
                var myloc = location.href;
                return myloc.substring(0, myloc.lastIndexOf('/')) + '/' + mypage;
            }
            // goResult() - 함수설명 : 결재완료후 결과값을 지정된 결과페이지(kspay_wh_result.php)로 전송합니다.
            function goResult(){
                document.join.target = "";
                document.join.action = "./finish.php";
                document.join.submit();
            }
            // eparamSet() - 함수설명 : 결재완료후 (wh_rcv.php로부터)결과값을 받아 지정된 결과페이지(kspay_wh_result.php)로 전송될 form에 세팅합니다.
            function eparamSet(rcid, rctype, rhash){
                document.join.reCommConId.value 	= rcid;
                document.join.reCommType.value = rctype  ;
                document.join.reHash.value 	= rhash  ;
            }
            function mcancel()
            {
                // 취소
                closeEvent();
            }


function doPaySubmit(){
    <?
            if (!$_SESSION['member_id']) {
            ?>
                alert("You have to log in to pay for it's");
                location.href = 'cart.php';
                return false;
            <? } ?>

            var bonus = parseFloat(<?= $json_balance['total_SP'] ?>);
            // var usepoint = parseFloat($("#userpoint").val());
            var total_settle = parseFloat($("#total_settle").val());
            // var total_settle = parseFloat($("#total_settle").val());
            // if(total_settle > bonus){
            // 	alert("보유 쇼핑 포인트보다 많이 구매할수없습니다");
            // 	return false;
            // }
            // if(userpoint != "" && usepoint >0){
            // 	if(usepoint > bonus){
            // 		alert("You can't use it more than your shopping points.");
            // 		return false;
            // 	}
            // 	if(usepoint > total_settle){
            // 		alert("You can't use more points than the product price.");
            // 		return false;
            // 	}

            // }
            icopayChillpaySyncAllPayerFields(document.join);
            if (!String(document.join.buyername.value || '').trim()) {
                alert('Order please enter firstname.');
                document.join.buyername.focus();
                return;
            }
            if (!String(document.join.buyername_l.value || '').trim()) {
                alert('Order please enter lastname.');
                document.join.buyername_l.focus();
                return;
            }

            if (!document.join.post.value) {
                alert('Please enter the zip code of the orderer.');
                document.join.post1.focus();
                return;
            }

            if (!document.join.addr1.value) {
                alert('Enter the address of the orderer.');
                document.join.addr1.focus();
                return;
            }

            if (!document.join.city.value) {
                alert('Please enter the city of the orderer.');
                document.join.post1.focus();
                return;
            }
            if (!document.join.state.value) {
                alert('Please enter the state of the orderer.');
                document.join.post1.focus();
                return;
            }

            if (!document.join.htel.value) {
                alert('Please enter the contact information of the orderer.');
                document.join.htel.focus();
                return;
            }

            if (!document.join.email.value) {
                alert('Enter the orderer\'\s email.');
                document.join.email.focus();
                return;
            }

            if (!document.join.recvname.value) {
                alert('Enter the recipient\'\s firstname.');
                document.join.recvname.focus();
                return;
            }

            if (!document.join.recvname_l.value) {
                alert('Enter the recipient\'\s lastname.');
                document.join.recvname.focus();
                return;
            }
            $("#ordNm").val(document.join.buyername_l.value+document.join.buyername.value);
            $("#ordTel").val(document.join.htel.value);
            var pk = document.querySelector('input[name=paymentkind]:checked');
            var pkVal = pk ? pk.value : '';
            var cardUi = ($('.card').length && $('.card').is(':visible')) || pkVal === '1';
            if (typeof ICOPAY_UNIFIED_ACTIVE !== 'undefined' && ICOPAY_UNIFIED_ACTIVE && cardUi) {
                icopayUnifiedStartFromCart();
                return;
            }
            if (typeof ICOPAY_CHILLPAY_ACTIVE !== 'undefined' && ICOPAY_CHILLPAY_ACTIVE && cardUi) {
                icopayChillpayStartFromCart();
                return;
            }
            document.join.action="finish.php";
            _submit(document.join);

}
// 결제창 return 함수(pay_result_submit 이름 변경 불가능)
function pay_result_submit(){


    $("#popupDiv").css({
                "top": (($(window).height() / 2 - $("#popupDiv").outerHeight()) / 2 + $(window).scrollTop()) + "px",
                "left": (($(window).width() - $("#popupDiv").outerWidth()) / 2 + $(window).scrollLeft()) + "px"
                //팝업창을 가운데로 띄우기 위해 현재 화면의 가운데 값과 스크롤 값을 계산하여 팝업창 CSS 설정

            });

            $("#popup_mask").css("display", "block"); //팝업 뒷배경 display block
            $("#popupDiv").css("display", "block"); //팝업창 display block

            $("body").css("overflow", "hidden"); //body 스크롤바 없애기
            $.ajax({
                type: "POST",
                url: "./order_ok2.php",
                async:false,
                data: $("#join").serialize(),
                dataType: "html",
                success: function(response) {
                    $("#popup_mask").css("display", "none"); //팝업 뒷배경 display block
                        $("#popupDiv").css("display", "none"); //팝업창 display block
                    document.join.action="finish.php";
            payResultSubmit();
            return false;
                    // console.log(response);
                    if (response.result == 1) {
                        $("#popup_mask").css("display", "none"); //팝업 뒷배경 display block
                        $("#popupDiv").css("display", "none"); //팝업창 display block
                        // alert(response.msg);
                        // if (response.paymentUrl != "" && response.paymentUrl != undefined) {
                        //     location.href = response.paymentUrl;
                        //     return false;
                        // } else {
                        //     location.href = "./finish.php";
                        //     return false;
                        // }
                        // return false;
                    } else {
                        alert("Please contact the product storage error manager.");
                        return false;
                        // alert(response.msg);
                        // return false;
                    }
                }
            });
            // return false;

    return false;
	// payResultSubmit();
}
// 결제창 종료 함수(pay_result_close 이름 변경 불가능)
function pay_result_close(){
	alert('Payment was cancelled.');
}
</script>
    <script language="JavaScript">
        <!--
        function paygo() {
            <?
            if (!$_SESSION['member_id']) {
            ?>
                alert("You have to log in to pay for it's");
                location.href = 'cart.php';
                return false;
            <? } ?>

            var onlyP = parseFloat($("#onlyP").val());
            var notP = parseFloat($("#notP").val());
            var bonus = parseFloat(<?= $json_balance['emoney'] ?>);

            // var usepoint = parseFloat($("#userpoint").val());
            var total_settle = parseFloat($("#total_settle").val());

            // var total_settle = parseFloat($("#total_settle").val());
            // if(total_settle > bonus){
            // 	alert("보유 쇼핑 포인트보다 많이 구매할수없습니다");
            // 	return false;
            // }
            // if(userpoint != "" && usepoint >0){
            // 	if(usepoint > bonus){
            // 		alert("You can't use it more than your shopping points.");
            // 		return false;
            // 	}
            // 	if(usepoint > total_settle){
            // 		alert("You can't use more points than the product price.");
            // 		return false;
            // 	}

            // }
            icopayChillpaySyncAllPayerFields(document.join);
            if (!String(document.join.buyername.value || '').trim()) {
                alert('Order please enter firstname.');
                document.join.buyername.focus();
                return;
            }
            if (!String(document.join.buyername_l.value || '').trim()) {
                alert('Order please enter lastname.');
                document.join.buyername_l.focus();
                return;
            }
            if (!document.join.post.value) {
                alert('Please enter the zip code of the orderer.');
                document.join.post1.focus();
                return;
            }
            if (!document.join.addr1.value) {
                alert('Enter the address of the orderer.');
                document.join.addr1.focus();
                return;
            }
            if (!document.join.city.value) {
                alert('Please enter the city of the orderer.');
                document.join.post1.focus();
                return;
            }
            if (!document.join.state.value) {
                alert('Please enter the state of the orderer.');
                document.join.post1.focus();
                return;
            }
            if (!document.join.htel.value) {
                alert('Please enter the contact information of the orderer.');
                document.join.htel.focus();
                return;
            }

            if (!document.join.email.value) {
                alert('Enter the orderer\'\s email.');
                document.join.email.focus();
                return;
            }

            if (!document.join.recvname.value) {
                alert('Enter the recipient\'\s name.');
                document.join.recvname.focus();
                return;
            }
            if (!document.join.recvname_l.value) {
                alert('Enter the recipient\'\s lastname.');
                document.join.recvname.focus();
                return;
            }
            //if (Number(GP) < Number(document.join.usepoint.value) )
            {
                // alert('코인이 부족합니다.');
                // document.join.usepoint.focus();
                // return;
            }
            //   if(!document.join.rhtel.value) {
            //      alert('배송지 연락처를 입력하세요.');
            //      document.join.rhtel.focus();
            //      return;
            //   }
            //   <? if ($valid_user) { ?>
            //	   if(document.join.usepoint.value!="") {
            //		  if(parseInt(document.join.usepoint.value)>'<?= $kk_point ?>'){
            //			 alert('사용하실코인이 보유코인을 초과하였습니다.');
            //			document.join.usepoint.focus();
            //			return;
            //		  }
            //	   }
            //	   var kk_point = '<?= $kk_point ?>';
            //	   if(document.join.usepoint.value!="") {
            //		  if(parseInt(document.join.usepoint.value)>parseInt(document.join.total_coin1.value)){
            //			 alert('사용가능한 코인을 초과하였습니다.');
            //			document.join.usepoint.focus();
            //			return;
            //		  }
            //	   }
            //	<? } ?>

            // onlyP
            // notP
            if (document.join.paymentkind.value == 5) {

                if (notP > 0) {
                    alert("Products purchased exclusively for points can be purchased only by points.");
                    return false;
                }
                if (total_settle > bonus) {
                    alert("Insufficient retention points.");
                    return false;
                }
            } else {
                if (document.join.paymentkind.checked == true) {
                    if (document.join.in_name.value == "") {
                        alert('Please enter the name of the depositor.');
                        document.join.in_name.focus();
                        return;
                    }
                    // if(document.join.bank.value==""){
                    // 	alert('입금 예정 계좌번호를 입력해주세요 입력해주세요.');
                    // 	document.join.bank.focus();
                    // 	return;
                    // }
                }
            }

            //alert(document.join.receive.value);
            document.join.submit();
        }

        function no_cart() {
            alert("There are products that are sold out. Please check and purchase it.");
            return;
        }
        //
        -->
    </script>
    <script language="javascript">
        function go_recal1() {
            document.form.action = './cart_racal.php';
            document.form.submit();
        }
        //-->
    </script>
</head>

<body>
    <div class="wrap">

        <!-- 상단(Top) -->


        <? include "../include/top.php"; ?>


        <!-- 상단(Top) -->

        <!-- 컨텐츠 시작 -->
        <div class="content_inner">
            <div class="sp40"></div>
            <!-- 카테고리 -->

            <? include "../include/category_info.php"; ?>

            <!-- 카테고리 끝 -->


            <div class="content_inner">


                <div class="content">
                    <div class="page_title">
                        Fill out the order
                    </div>

                    <table class="cart_table">
                        <tr>
                            <th width="10%">Image</th>
                            <th width="35%">Product name</th>
                            <th width="15%">Quantity</th>
                            <th width="10%">Product price</th>
                            <th width="10%">Total products</th>
                            <th width="10%">Real Value</th>
                            <th width="10%">elimination</th>
                        </tr>
                        <form name=form method=post>
                            <?
                            #####################################################################
                            $tot = totCount();
                            $total_price = 0;
                            $total_coin = 0;
                            $onlyP = 0;
                            $notP = 0;
                            $title_array="";
                            for ($i = 0; $i < $tot; $i++) {

                                $ii = $i; //gas_sel
                                getCart($i, $arr);

                                if ($arr[1] < 1 || $arr[1] == '') {
                                    echo "<script type='text/javascript'>
		<!--
			alert('There is less than one product in the shopping basket.');
		//-->
		</script>";
                                    echo "<meta http-equiv='refresh' content='0;url=cart.php'>";
                                    exit;
                                }

                                $goods = json_decode(curl_d($api_category, "&Type=proView&code=$arr[0]"), true);
                                if (!is_array($goods) || !isset($goods[0]) || !is_array($goods[0])) {
                                    continue;
                                }


                                $code        = $goods[0]['code'];
                                $title        = $goods[0]['title'];
                                if ($title == "") {
                                    continue;
                                }
                                $title_array=$title_array.$title.",";
                                $pricec        = $goods[0]['pricec'];
                                $prices        = $goods[0]['prices'];
                                $priced        = $goods[0]['priced'];
                                $point        = $goods[0]['point'];
                                $soldout    = $goods[0]['soldout'];
                                $price_dis  = $goods[0]['price_dis'];
                                $imgl        = $goods[0]['imgl'];
                                $opt_num    = $goods[0]['opt_num'];
                                $opt_num_str = $goods[0]['opt_num_str'];

                                $option_t1    = $goods[0]['option_t1'];
                                $option_n1    = $goods[0]['option_n1'];
                                $option_p1    = $goods[0]['option_p1'];
                                $option_k1    = $goods[0]['option_k1'];

                                $option_t2    = $goods[0]['option_t2'];
                                $option_n2    = $goods[0]['option_n2'];
                                $option_p2    = $goods[0]['option_p2'];
                                $option_k2    = $goods[0]['option_k2'];

                                $option_t3    = $goods[0]['option_t3'];
                                $option_n3    = $goods[0]['option_n3'];
                                $option_p3    = $goods[0]['option_p3'];
                                $option_k3    = $goods[0]['option_k3'];

                                $option_t4    = $goods[0]['option_t4'];
                                $option_n4    = $goods[0]['option_n4'];
                                $option_p4    = $goods[0]['option_p4'];
                                $option_k4    = $goods[0]['option_k4'];

                                $option_t5    = $goods[0]['option_t5'];
                                $option_n5    = $goods[0]['option_n5'];
                                $option_p5    = $goods[0]['option_p5'];
                                $option_k5    = $goods[0]['option_k5'];

                                $point_dis    = $goods[0]['point_dis'];
                                $imgb1        = $goods[0]['imgb1'];
                                $imgb2        = $goods[0]['imgb2'];
                                $coin        = $goods[0]['coin'];
                                $c_pv        = $goods[0]['c_pv'];
                                $onlypoint        = $goods[0]['onlypoint'];

                                if ($onlypoint == 1) {
                                    $onlyP = $onlyP + 1;
                                    $title=$title."<span style='color:#ff0000;'>[Point Only]</span>";
                                } else {
                                    $notP = $notP + 1;
                                }


                                if ($soldout == "Y") {
                                    $out111 = "Y";
                                }

                                $title = stripslashes($title);


                                $detail = stripslashes($detail);

                                ##############가격계산###################################3
                                if ($priced > 0) {
                                    $price_tmp = $priced;
                                } else {
                                    $price_tmp = $pricec;
                                }

                                // echo $priced;
                                // echo $pricec;
                                // $price_tmp = $pricec;
                                // $sail_price = $priced;




                                #################################################

                                if ($point_dis == 'pe') {
                                    $cpoint = number_format(floor($price_tmp * $point / 100)) . "&nbsp;Point";
                                    $cpoint1 = floor($price_tmp * $point / 100);
                                } else {
                                    $cpoint = number_format($point) . "&nbsp;Point";
                                    $cpoint1 = $point;
                                }

                                $asize = explode(",", $size);    /*사이즈 분리*/
                                $acolor = explode(",", $color);    /*색상 분리*/
                                $aopt_num = explode(",", $opt_num);
                                $aoption_n1 = explode("\r\n", $option_n1);
                                $aoption_p1 = explode("\r\n", $option_p1);
                                $aoption_k1 = explode("\r\n", $option_k1);
                                $aoption_n2 = explode("\r\n", $option_n2);
                                $aoption_p2 = explode("\r\n", $option_p2);
                                $aoption_k2 = explode("\r\n", $option_k2);
                                $aoption_n3 = explode("\r\n", $option_n3);
                                $aoption_p3 = explode("\r\n", $option_p3);
                                $aoption_k3 = explode("\r\n", $option_k3);
                                $aoption_n4 = explode("\r\n", $option_n4);
                                $aoption_p4 = explode("\r\n", $option_p4);
                                $aoption_k4 = explode("\r\n", $option_k4);
                                $aoption_n5 = explode("\r\n", $option_n5);
                                $aoption_p5 = explode("\r\n", $option_p5);
                                $aoption_k5 = explode("\r\n", $option_k5);

                                $aaoption_n1 = explode("\r\n", $option_n1);
                                $aaoption_p1 = explode("\r\n", $option_p1);
                                $aaoption_k1 = explode("\r\n", $option_k1);
                                $aaoption_n2 = explode("\r\n", $option_n2);
                                $aaoption_p2 = explode("\r\n", $option_p2);
                                $aaoption_k2 = explode("\r\n", $option_k2);
                                $aaoption_n3 = explode("\r\n", $option_n3);
                                $aaoption_p3 = explode("\r\n", $option_p3);
                                $aaoption_k3 = explode("\r\n", $option_k3);
                                $aaoption_n4 = explode("\r\n", $option_n4);
                                $aaoption_p4 = explode("\r\n", $option_p4);
                                $aaoption_k4 = explode("\r\n", $option_k4);
                                $aaoption_n5 = explode("\r\n", $option_n5);
                                $aaoption_p5 = explode("\r\n", $option_p5);
                                $aaoption_k5 = explode("\r\n", $option_k5);

                                $ki = 0;
                                // print_r($aoption_n1);
                                if ($option_t1 != "") {
                                    $ki = 0;
                                    foreach ($aoption_n1 as $key => $value) {
                                        if ($value == "") {
                                        } else {
                                            if ($value == $arr[5]) {

                                                $price1 = $aoption_p1[$ki];
                                                $priced1 = $aoption_p1[$ki];
                                                $point1 = $aoption_k1[$ki];
                                            }
                                        }
                                        $ki++;
                                    }
                                } else {
                                    $price1 = 0;
                                    $priced1 = 0;
                                    if ($point_dis != "pe")  $point1 = 0;
                                }

                                if ($option_t2 != "") {
                                    $ki = 0;
                                    foreach ($aoption_n2 as $key => $value) {
                                        if ($value == "") {
                                        } else {
                                            if ($value == $arr[6]) {
                                                $price2 = $aoption_p2[$ki];
                                                $priced2 = $aoption_p2[$ki];
                                                $point2 = $aoption_k2[$ki];
                                            }
                                        }
                                        $ki++;
                                    }
                                } else {
                                    $price2 = 0;
                                    $priced2 = 0;
                                    if ($point_dis != "pe") $point2 = 0;
                                }

                                if ($option_t3 != "") {
                                    $ki = 0;
                                    foreach ($aoption_n3 as $key => $value) {
                                        if ($value == "") {
                                        } else {
                                            if ($value == $arr[7]) {
                                                $price3 = $aoption_p3[$ki];
                                                $priced3 = $aoption_p3[$ki];
                                                $point3 = $aoption_k3[$ki];
                                            }
                                        }
                                        $ki++;
                                    }
                                } else {
                                    $price3 = 0;
                                    $priced3 = 0;
                                    if ($point_dis != "pe") $point3 = 0;
                                }

                                if ($option_t4 != "") {
                                    $ki = 0;
                                    foreach ($aoption_n4 as $key => $value) {
                                        if ($value == "") {
                                        } else {
                                            if ($value == $arr[8]) {
                                                $price4 = $aoption_p4[$ki];
                                                $priced4 = $aoption_p4[$ki];
                                                $point4 = $aoption_k4[$ki];
                                            }
                                        }
                                        $ki++;
                                    }
                                } else {
                                    $price4 = 0;
                                    $priced4 = 0;
                                    if ($point_dis != "pe") $point4 = 0;
                                }

                                if ($option_t5 != "") {
                                    $ki = 0;
                                    foreach ($aoption_n5 as $key => $value) {
                                        if ($value == "") {
                                        } else {
                                            if ($value == $arr[9]) {
                                                $price5 = $aoption_p5[$ki];
                                                $priced5 = $aoption_p5[$ki];
                                                $point5 = $aoption_k5[$ki];
                                            }
                                        }
                                        $ki++;
                                    }
                                } else {
                                    $price5 = 0;
                                    $priced5 = 0;
                                    if ($point_dis != "pe") $point5 = 0;
                                }


                                $title = stripslashes($title);

                                if ($point_dis == "pe") {
                                    $point = floor($price_tmp * $point / 100);
                                    $point1 = floor($price1 * $point1 / 100);
                                    $point2 = floor($price2 * $point2 / 100);
                                    $point3 = floor($price3 * $point3 / 100);
                                    $point4 = floor($price4 * $point4 / 100);
                                    $point5 = floor($price5 * $point5 / 100);
                                    $point = ($point + $point1 + $point2 + $point3 + $point4 + $point5) * $arr[1];
                                } else {
                                    $point = ($point + $point1 + $point2 + $point3 + $point4 + $point5) * $arr[1];
                                }

                                $sum_price = ($price_tmp + $price1 + $price2 + $price3 + $price4 + $price5) * $arr[1];

                                $unit_usd = $price_tmp + $price1 + $price2 + $price3 + $price4 + $price5;
                                $c_pv = floor($sum_price * ($c_pv / 100));
                                $price = pkshop_format_checkout_price($unit_usd);

                                $sale_price_total = $price_tmp   * $arr[1];



                                $result_price = $result_price + $sale_price_total;




                                $sale_price_total_stt = pkshop_format_checkout_price($sale_price_total);
                                $result_price_total = pkshop_format_checkout_price($result_price);

                                $sum_price = $sum_price;
                                $total_price = $total_price + $sum_price;

                                $sum_price = pkshop_format_checkout_price($sum_price);

                                $total_point = $total_point + $point;
                                $point_tot = $point;
                                $point =  number_format($point);

                                ### 이미지 파일 저장 디렉토리 ###
                                $savedir = "//pentakleva.shop/upload/";

                                $img_name = $savedir . $imgl;

                            ?>

                                <tr>
                                    <td><a href="../sub04/view.php?left_code=<?= $code ?>"><? if ($imgl) { ?><img src="<?= $savedir ?><?= $imgl ?>" width="120"><? } else { ?><img src="<?= $savedir ?><?= $imgb1 ?>" width="120"><? } ?></a></td>
                                    <td class="review_cont">
                                        <a href="../sub04/view.php?left_code=<?= $code ?>" class="a_3">
                                            <?= $title ?><br />
                                            <span class="cart_list_option"><? if ($arr[5] != "") { ?>&nbsp;Option :
                                                <? if ($arr[5] != "") { ?> &nbsp;<?= $arr[5] ?><? } ?>
                                                    <? if ($arr[6] != "") { ?> &nbsp;<?= $arr[6] ?><? } ?>
                                                        <? if ($arr[7] != "") { ?> &nbsp;<?= $arr[7] ?><? } ?>
                                                            <? if ($arr[8] != "") { ?> &nbsp;<?= $arr[8] ?><? } ?>
                                                                <? if ($arr[9] != "") { ?> &nbsp;<?= $arr[9] ?><? } ?>
                                                                <? } ?></span>
                                        </a>
                                        <input type="hidden" name="size<?= $i ?>" value="<?= $arr[2] ?>">
                                        <input type="hidden" name="color<?= $i ?>" value="<?= $arr[3] ?>">
                                        <input type="hidden" name="option1<?= $i ?>" value="<?= $arr[5] ?>">
                                        <input type="hidden" name="option2<?= $i ?>" value="<?= $arr[6] ?>">
                                        <input type="hidden" name="option3<?= $i ?>" value="<?= $arr[7] ?>">
                                        <input type="hidden" name="option4<?= $i ?>" value="<?= $arr[8] ?>">
                                        <input type="hidden" name="option5<?= $i ?>" value="<?= $arr[9] ?>"></a><? if ($soldout == "Y") { ?><FONT COLOR="#EC7600">[Out of stock]</FONT><? } ?>
                                    </td>
                                    <td><?= $arr[1] ?></td>
                                    <td class="font_b"><?= $price ?></td>

                                    <td class="c_redb"><?= $sum_price ?></td>
                                    <td class="c_redb">RV <?= $c_pv ?></td>
                                    <td><a href="./cart_del1.php?del_num=<?= $i ?>" onFocus='this.blur()'><img src="images/cart_delet.png" alt="삭제" width='30px'></a></td>
                                </tr>
                            <? } ?>
                            <?


                            if (50 <= $total_price || $code == "09000000039") $charge = 0;
                            else $charge = 3;

                            $total_settle = $total_price + $charge;
                            $total_settle_diot = $total_settle + $charge;
                            $total_settle_num = $total_settle;
                            $total_settle_num_diot = $total_settle_diot;    //diot 로 계산 한 값
                            $chargeT = pkshop_format_checkout_price($charge);
                            $total_price_fmt = pkshop_format_checkout_price($total_price);
                            $total_settle_fmt = pkshop_format_checkout_price($total_settle);
                            $payment_currency = pkshop_get_payment_currency();
                            $total_settle_payment_amt = pkshop_payment_amount_from_usd($total_settle_num);
                            $ex_money_display = pkshop_format_currency_amount($total_settle_payment_amt, $payment_currency);

                            if ($_SESSION['connect_check'] != "ok") {



                                // 새로운 주문번호를 생성한다
                                $ords = json_decode(curl_d($api_category, "&Type=orderMax&code=$arr[0]"), true);

                                //echo $ords[0]['max(ordernum)'];
                                if ($ords[0]['max(ordernum)']) {
                                    $new_num = $ords[0]['max(ordernum)'] + 1;
                                } else {
                                    $new_num = 10000001;
                                }


                                if ($valid_user != "") {
                                    $cook_id = $valid_user;
                                } else {
                                    $cook_id = "g" . $new_num;
                                }

                                if ($usepoint == $totalPrice && $usepoint > 0) {
                                    $state = "결제완료";
                                } else {
                                    $state = "주문접수";
                                }
                                // $state="결제완료";
                                // echo $buyername;


                                $new_num = $new_num;            //주문번호
                                $cook_id = $cook_id;            //아이디
                                $pay_name = $_POST['buyername'];            //주문자 이름
                                $pay_tel = $_POST['htel'];                //주문자 연락처
                                $pay_mobile = $htel;
                                $post = explode("-", $_POST['post']);
                                $pay_zip1 = $post[0];                //주문자 우편번호1
                                $pay_zip2 = $post[1];                //주문자 우편번호2
                                $pay_addr = $_POST['addr1'];                //주문자 주소
                                $pay_email = $_POST['email'];            //주문자 이메일

                                $receive_name = $_POST['recvname'];        //수신자 이름
                                $receive_tel = $_POST['rhtel'];            //수신자 연락처
                                $receive_mobile = $rhtel;
                                $rpost = explode("-", $_POST['rpost']);
                                $receive_zip1 = $rpost[0];        //배송지 우편번호1
                                $receive_zip2 = $rpost[1];        //배송지 우편번호2
                                $receive_addr = $_POST['raddr1'];        //배송지 주소
                                $receive_email = $_POST['email'];        //수신자 이메일
                                $receive_etc = addslashes($_POST["rcontent"]); //특이사항

                                // $paymentkind=2;
                                $kind = $paymentkind;            //결재종류 무통장:2 , 신용카드:1

                                $total_point = $total_point;    //총 적립되는 금액



                                $charge = $charge_num;

                                $passwd = $passwd;                //비밀번호
                                $signdate = time();                //주문일자


                                //주문 데이터베이스에 입력값을 삽입한다.

                                // curl_d($api_category,"&Type=orderSave&new_num=$new_num&cook_id=$cook_id&pay_name=$pay_name&pay_tel=$pay_tel&pay_mobile=$pay_mobile&pay_zip1=$pay_zip1&pay_zip2=$pay_zip2&pay_addr=$pay_addr&pay_email=$pay_email&pay_etc=$receive_etc&receive_name=$receive_name&receive_tel=$receive_tel&receive_mobile=$receive_mobile&receive_zip1=$receive_zip1&receive_zip2=$receive_zip2&receive_addr=$receive_addr&receive_email=$receive_email&receive_etc=$receive_etc&kind=$kind&bank=$bank&pointin=$pointin&pointout=$pointout&in_name=$in_name&in_year=$in_year&in_month=$in_month&in_day=$in_day&charge=$charge&char_year=$char_year&char_month=$char_month&char_day=$char_day&state=$state&passwd=$passwd&signdate=$signdate&total_settle_num=$total_settle_num&tid=$tid&usepoint=$usepoint&bank=$bank&in_name=$in_name");






                                $tot = totCount();
                                $total_price = 0;
                                for ($i = 0; $i < $tot; $i++) {
                                    $ii = $i; //gas_sel
                                    getCart($i, $arr);



                                    $goods = json_decode(curl_d($api_category, "&Type=proView&code=$arr[0]"), true);
                                    if (!is_array($goods) || !isset($goods[0]) || !is_array($goods[0])) {
                                        continue;
                                    }
                                    $code        = $goods[0]['code'];

                                    if ($code == "") {
                                        continue;
                                    }

                                    $title        = $goods[0]['title'];
                                    $pricec        = $goods[0]['pricec'];
                                    $prices        = $goods[0]['prices'];
                                    $priced        = $goods[0]['priced'];
                                    //	$priced_diot = mysql_result($result1,0,0);
                                    $point        = $goods[0]['point'];
                                    $soldout    = $goods[0]['soldout'];
                                    $price_dis  = $goods[0]['price_dis'];
                                    $imgl        = $goods[0]['imgl'];
                                    $opt_num    = $goods[0]['opt_num'];
                                    $opt_num_str = $goods[0]['opt_num_str'];

                                    $option_t1    = $goods[0]['option_t1'];
                                    $option_n1    = $goods[0]['option_n1'];
                                    $option_p1    = $goods[0]['option_p1'];
                                    $option_k1    = $goods[0]['option_k1'];

                                    $option_t2    = $goods[0]['option_t2'];
                                    $option_n2    = $goods[0]['option_n2'];
                                    $option_p2    = $goods[0]['option_p2'];
                                    $option_k2    = $goods[0]['option_k2'];

                                    $option_t3    = $goods[0]['option_t3'];
                                    $option_n3    = $goods[0]['option_n3'];
                                    $option_p3    = $goods[0]['option_p3'];
                                    $option_k3    = $goods[0]['option_k3'];

                                    $option_t4    = $goods[0]['option_t4'];
                                    $option_n4    = $goods[0]['option_n4'];
                                    $option_p4    = $goods[0]['option_p4'];
                                    $option_k4    = $goods[0]['option_k4'];

                                    $option_t5    = $goods[0]['option_t5'];
                                    $option_n5    = $goods[0]['option_n5'];
                                    $option_p5    = $goods[0]['option_p5'];
                                    $option_k5    = $goods[0]['option_k5'];

                                    $point_dis    = $goods[0]['point_dis'];

                                    if ($soldout == "Y") {
                                        $out111 = "Y";
                                    }

                                    $title = stripslashes($title);


                                    $detail = stripslashes($detail);

                                    ##############회&nbsp;원등급에 따른 가격계산###################################3
                                    if ($cook_dis == "1" && $cook_dis1 == "1") {
                                        $price_tmp = $priced;
                                    } else	if ($cook_dis == "2" && $cook_dis1 == "1") {
                                        $price_tmp = $pricec;
                                    } else if ($cook_dis == "3" && $cook_dis1 == "1") {
                                        $price_tmp = $prices;
                                    } else {
                                        if ($priced > 0) {
                                            $price_tmp = $priced;
                                        } else {
                                            $price_tmp = $pricec;
                                        }
                                    }
                                    // $price_tmp = $pricec;
                                    $sell_price = $priced;

                                    #################################################

                                    if ($point_dis == 'pe') {
                                        $cpoint = number_format(floor($price_tmp * $point / 100)) . "&nbsp;원";
                                        $cpoint1 = floor($price_tmp * $point / 100);
                                    } else {
                                        $cpoint = number_format($point) . "&nbsp;원";
                                        $cpoint1 = $point;
                                    }

                                    $asize = explode(",", $size);                /*사이즈 분리*/
                                    $acolor = explode(",", $color);                    /*색상 분리*/


                                    $aopt_num = explode(",", $opt_num);


                                    $aoption_n1 = explode("\r\n", $option_n1);
                                    $aoption_p1 = explode("\r\n", $option_p1);
                                    $aoption_k1 = explode("\r\n", $option_k1);
                                    $aoption_n2 = explode("\r\n", $option_n2);
                                    $aoption_p2 = explode("\r\n", $option_p2);
                                    $aoption_k2 = explode("\r\n", $option_k2);
                                    $aoption_n3 = explode("\r\n", $option_n3);
                                    $aoption_p3 = explode("\r\n", $option_p3);
                                    $aoption_k3 = explode("\r\n", $option_k3);
                                    $aoption_n4 = explode("\r\n", $option_n4);
                                    $aoption_p4 = explode("\r\n", $option_p4);
                                    $aoption_k4 = explode("\r\n", $option_k4);
                                    $aoption_n5 = explode("\r\n", $option_n5);
                                    $aoption_p5 = explode("\r\n", $option_p5);
                                    $aoption_k5 = explode("\r\n", $option_k5);

                                    $aaoption_n1 = explode("\r\n", $option_n1);
                                    $aaoption_p1 = explode("\r\n", $option_p1);
                                    $aaoption_k1 = explode("\r\n", $option_k1);
                                    $aaoption_n2 = explode("\r\n", $option_n2);
                                    $aaoption_p2 = explode("\r\n", $option_p2);
                                    $aaoption_k2 = explode("\r\n", $option_k2);
                                    $aaoption_n3 = explode("\r\n", $option_n3);
                                    $aaoption_p3 = explode("\r\n", $option_p3);
                                    $aaoption_k3 = explode("\r\n", $option_k3);
                                    $aaoption_n4 = explode("\r\n", $option_n4);
                                    $aaoption_p4 = explode("\r\n", $option_p4);
                                    $aaoption_k4 = explode("\r\n", $option_k4);
                                    $aaoption_n5 = explode("\r\n", $option_n5);
                                    $aaoption_p5 = explode("\r\n", $option_p5);
                                    $aaoption_k5 = explode("\r\n", $option_k5);



                                    $ki = 0;


                                    if ($option_t1 != "") {
                                        $ki = 0;
                                        foreach ($aoption_n1 as $key => $value) {
                                            if ($value == "") {
                                            } else {
                                                if ($value == $arr[5]) {
                                                    $price1 = $aoption_p1[$ki];
                                                    $priced1 = $aoption_p1[$ki];
                                                    $point1 = $aoption_k1[$ki];
                                                }
                                            }
                                            $ki++;
                                        }
                                    } else {
                                        $price1 = 0;
                                        $priced1 = 0;
                                        if ($point_dis != "pe")  $point1 = 0;
                                    }

                                    if ($option_t2 != "") {
                                        $ki = 0;
                                        foreach ($aoption_n2 as $key => $value) {
                                            if ($value == "") {
                                            } else {
                                                if ($value == $arr[6]) {
                                                    $price2 = $aoption_p2[$ki];
                                                    $priced2 = $aoption_p2[$ki];
                                                    $point2 = $aoption_k2[$ki];
                                                }
                                            }
                                            $ki++;
                                        }
                                    } else {
                                        $price2 = 0;
                                        $priced2 = 0;
                                        if ($point_dis != "pe") $point2 = 0;
                                    }

                                    if ($option_t3 != "") {
                                        $ki = 0;
                                        foreach ($aoption_n3 as $key => $value) {
                                            if ($value == "") {
                                            } else {
                                                if ($value == $arr[7]) {
                                                    $price3 = $aoption_p3[$ki];
                                                    $priced3 = $aoption_p3[$ki];
                                                    $point3 = $aoption_k3[$ki];
                                                }
                                            }
                                            $ki++;
                                        }
                                    } else {
                                        $price3 = 0;
                                        $priced3 = 0;
                                        if ($point_dis != "pe") $point3 = 0;
                                    }

                                    if ($option_t4 != "") {
                                        $ki = 0;
                                        foreach ($aoption_n4 as $key => $value) {
                                            if ($value == "") {
                                            } else {
                                                if ($value == $arr[8]) {
                                                    $price4 = $aoption_p4[$ki];
                                                    $priced4 = $aoption_p4[$ki];
                                                    $point4 = $aoption_k4[$ki];
                                                }
                                            }
                                            $ki++;
                                        }
                                    } else {
                                        $price4 = 0;
                                        $priced4 = 0;
                                        if ($point_dis != "pe") $point4 = 0;
                                    }

                                    if ($option_t5 != "") {
                                        $ki = 0;
                                        foreach ($aoption_n5 as $key => $value) {
                                            if ($value == "") {
                                            } else {
                                                if ($value == $arr[9]) {
                                                    $price5 = $aoption_p5[$ki];
                                                    $priced5 = $aoption_p5[$ki];
                                                    $point5 = $aoption_k5[$ki];
                                                }
                                            }
                                            $ki++;
                                        }
                                    } else {
                                        $price5 = 0;
                                        $priced5 = 0;
                                        if ($point_dis != "pe") $point5 = 0;
                                    }


                                    $title = stripslashes($title);

                                    if ($point_dis == "pe") {
                                        $point = floor($price_tmp * $point / 100);
                                        $point1 = floor($price1 * $point1 / 100);
                                        $point2 = floor($price2 * $point2 / 100);
                                        $point3 = floor($price3 * $point3 / 100);
                                        $point4 = floor($price4 * $point4 / 100);
                                        $point5 = floor($price5 * $point5 / 100);
                                        $my_point = ($point + $point1 + $point2 + $point3 + $point4 + $point5);
                                    } else {
                                        $my_point = ($point + $point1 + $point2 + $point3 + $point4 + $point5);
                                    }

                                    $price = ($price_tmp + $price1 + $price2 + $price3 + $price4 + $price5);

                                    $total_price = $total_price + $sum_price;

                                    $total_point = $total_point + $point;
                                    $point_tot = $point;


                                    //데이터베이스에 입력값을 삽입한다.


                                    //  curl_d($api_category,"&Type=sellSave&&new_num=$new_num&code=$arr[0]&title=$title&price=$price&my_point=$my_point&count=$arr[1]&code1=$code1&code2=$code2&code3=$code3&signdate=$signdate&opt1=$arr[2]&opt2=$arr[3]&new_opt1=$arr[5]&new_opt2=$arr[6]&new_opt3=$arr[7]&new_opt4=$arr[8]&new_opt5=$arr[9]&code4=$code4&prices=$prices&coin=$coin&state=$state&cook_id=$cook_id");

                                    $title_11111 = $title_11111 . $title;
                                }



                                //중복 실행 방지
                                // $connect_check="ok";
                                //session_register("connect_check");
                                // $_SESSION['connect_check'] = $connect_check;


                                // 체크
                                // $_SESSION["session_cart"] = "";
                            }

                            ?>

                    </table>
                    <div class="cart_price">
                        <div class="sp30"></div>
                        <div class="cart_price_inner">
                            Total payment amount.[Amount(<?= $result_price_total ?>) + The delivery charge(<?= $chargeT ?>)]&nbsp;&nbsp;<span class="c_redb font_24"><?= $total_settle_fmt ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="sp15"></div>
                        <div class="price_text">
                            Additional shipping costs may be incurred depending on the manufacturer and supplier.&nbsp;&nbsp;&nbsp;&nbsp;<br />
                            Additional charges (payment) may be incurred in islands and mountainous areas.&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                        <div class="sp30"></div>
                    </div>
                    </form>
                    <div class="sp20"></div>
                    <form name=join id="join" method=post action="confirm.php">
                        <input type="hidden" name="total_settle" id="total_settle" value="<?= $total_settle_num ?>">
                        <input type="hidden" name="onlyP" id="onlyP" value="<?= $onlyP ?>">
                        <input type="hidden" name="notP" id="notP" value="<?= $notP ?>">
                        <script language="javascript">
                            function sync_data(m) {
                                if (m == 1) {
                                    document.join.recvname.value = document.join.buyername.value;
                                    document.join.recvname_l.value = document.join.buyername_l.value;
                                    document.join.rpost.value = document.join.post.value;
                                    document.join.r_city.value = document.join.city.value;
                                    document.join.r_state.value = document.join.state.value;
                                    document.join.raddr1.value = document.join.addr1.value;
                                    //document.join.rtel.value=document.join.tel.value;
                                    document.join.rhtel.value = document.join.htel.value;
                                }
                                if (m == 2) {
                                    document.join.recvname.value = "";
                                    document.join.recvname_l.value = "";
                                    document.join.rpost.value = "";
                                    document.join.r_city.value = "";
                                    document.join.r_state.value = "";
                                    document.join.raddr1.value = "";
                                    //document.join.rtel.value="";
                                    document.join.rhtel.value = "";
                                }
                            }
                            //
                        </script>
                        <table class="order_table">
                            <!-- <tr>
				<th>What do you have?</th>
				<td><input type="text" value="<?= number_format($json_balance['total_SP']) ?>" readonly class="input_name"></td>
			</tr> -->
                            <tr>
                                <th>firstName</th>
                                <td><input type="text" name="buyername" value="<?= htmlspecialchars($buyername_default, ENT_QUOTES, 'UTF-8') ?>" class="input_name"></td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td><input type="text" name="buyername_l" value="<?= htmlspecialchars($buyername_l_default, ENT_QUOTES, 'UTF-8') ?>" class="input_name"></td>
                            </tr>
                            <!-- <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script> -->
                            <script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                            <script>
                                function sample6_execDaumPostcode() {
                                    new daum.Postcode({
                                        oncomplete: function(data) {
                                            var addr = ''; // 주소 변수
                                            var extraAddr = ''; // 참고항목 변수

                                            if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                                addr = data.roadAddress;
                                            } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                                addr = data.jibunAddress;
                                            }

                                            // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                                            if (data.userSelectedType === 'R') {
                                                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                                                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                                                if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                                                    extraAddr += data.bname;
                                                }
                                                // 건물명이 있고, 공동주택일 경우 추가한다.
                                                if (data.buildingName !== '' && data.apartment === 'Y') {
                                                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                                }
                                                // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                                                if (extraAddr !== '') {
                                                    extraAddr = ' (' + extraAddr + ')';
                                                }
                                                // 조합된 참고항목을 해당 필드에 넣는다.
                                                // document.getElementById("addr1").value = extraAddr;

                                            } else {
                                                document.getElementById("addr1").value = '';
                                            }

                                            // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                            document.getElementById('post').value = data.zonecode;
                                            document.getElementById("addr1").value = addr;
                                            // 커서를 상세주소 필드로 이동한다.
                                            document.getElementById("addr1").focus();
                                        }
                                    }).open();
                                }
                            </script>
                            <tr>
                                <th>Address</th>
                                <td>
                                    postcode
                                    <input type="text" name="post" value="<?= $c_zip ?>" id="post" class="input_name">&nbsp;
                                    <!-- <input type="button" value="Find Address" class="find_address" > -->
                                    <div class="sp5"></div>
                                    Street Adress
                                    <input type="text" name="addr1" value="<?= $c_addr ?> <?= $c_addr2 ?>" id="addr1" class="input_addr">
                                </td>
                            </tr>
                            <tr>
                                <th>City</th>
                                <td>
                                    <input type="text" name="city" id="city" class="input_name">
                                </td>
                            </tr>
                            <tr>
                                <th>State</th>
                                <td>
                                <input type="text" name="state" id="state" class="input_name">
                                    <!-- <select style="border:1px solid #000;padding:1% 0px;" name="state" id="state">
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="CA">California</option>
                                        <option value="CO">Colorado</option>
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="DC">District Of Columbia</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="HI">Hawaii</option>
                                        <option value="ID">Idaho</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IN">Indiana</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NV">Nevada</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="OH">Ohio</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="OR">Oregon</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="TX">Texas</option>
                                        <option value="UT">Utah</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WA">Washington</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select> -->

                                </td>
                            </tr>
                            <tr>
                                <th>E-mail</th>
                                <td><input type="text" name="email" value="<?= $email ?>" class="input_email"></td>
                            </tr>
                            <!-- <tr>
				<th>일반전화</th>
				<td><input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel"></td>
			</tr> -->
                            <tr>
                                <th>Cell phone</th>
                                <td><input type="text" name="htel" value="<?= $handphone ?>" class="input_email"></td>
                            </tr>
                        </table>

                        <div class="sp30"></div>

                        <div class="order_title">
                            Recipient Information &nbsp;&nbsp; <span class="font_12 font_thin c_gary">Same as the orderer.</span><input name="buytype" type="radio" value="radiobutton" onClick="sync_data(1);">
                            Yes.
                            <input type="radio" name="buytype" value="radiobutton" onClick="sync_data(2);">
                            No, I don't.
                        </div>

                        <div class="sp10"></div>

                        <table class="order_table">
                            <tr>
                                <th>Recipient first Name</th>
                                <td><input type="text" name="recvname" class="input_name"></td>
                            </tr>
                            <tr>
                                <th>Recipient last Name</th>
                                <td><input type="text" name="recvname_l" class="input_name"></td>
                            </tr>
                            <!-- <script src="//dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
                            <script>
                                function openDaumPostcode1() {
                                    new daum.Postcode({
                                        oncomplete: function(data) {
                                            // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                            // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                                            // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                            var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                                            var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                                            // 법정원 MALL이 있을 경우 추가한다. (법정리는 제외)
                                            // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                                            if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                                                extraRoadAddr += data.bname;
                                            }
                                            // 건물명이 있고, 공동주택일 경우 추가한다.
                                            if (data.buildingName !== '' && data.apartment === 'Y') {
                                                extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                            }
                                            // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                                            if (extraRoadAddr !== '') {
                                                extraRoadAddr = ' (' + extraRoadAddr + ')';
                                            }
                                            // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                                            if (fullRoadAddr !== '') {
                                                fullRoadAddr += extraRoadAddr;
                                            }

                                            // 우편번호와 주소 정보를 해당 필드에 넣는다.
                                            document.getElementById('rpost').value = data.zonecode; //5자리 새우편번호 사용
                                            document.getElementById('raddr1').value = fullRoadAddr;
                                            //document.getElementById('address').value = data.jibunAddress;


                                        }
                                    }).open();
                                }
                            </script>
                            <tr>
                                <th>Recipient Address</th>
                                <td>
                                    Post code<input type="text" name="rpost" id="rpost" class="input_name">&nbsp;
                                    <!-- <input type="button" value="Find Address" class="find_address" onClick="openDaumPostcode1('rpost','raddr1');"> -->
                                    <div class="sp5"></div>
                                    Street Adress<input type="text" name="raddr1" id="raddr1" class="input_addr">
                                </td>
                            </tr>
                            <tr>
                                <th>Recipient City</th>
                                <td>
                                    <input type="text" name="r_city" id="r_city" class="input_name">
                                </td>
                            </tr>
                            <tr>
                                <th>Recipient State</th>
                                <td>
                                <input type="text" name="r_state" id="r_state" class="input_name">
                                    <!-- <select style="border:1px solid #000;padding:1% 0px;" name="r_state" id="r_state">
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                        <option value="AR">Arkansas</option>
                                        <option value="CA">California</option>
                                        <option value="CO">Colorado</option>
                                        <option value="CT">Connecticut</option>
                                        <option value="DE">Delaware</option>
                                        <option value="DC">District Of Columbia</option>
                                        <option value="FL">Florida</option>
                                        <option value="GA">Georgia</option>
                                        <option value="HI">Hawaii</option>
                                        <option value="ID">Idaho</option>
                                        <option value="IL">Illinois</option>
                                        <option value="IN">Indiana</option>
                                        <option value="IA">Iowa</option>
                                        <option value="KS">Kansas</option>
                                        <option value="KY">Kentucky</option>
                                        <option value="LA">Louisiana</option>
                                        <option value="ME">Maine</option>
                                        <option value="MD">Maryland</option>
                                        <option value="MA">Massachusetts</option>
                                        <option value="MI">Michigan</option>
                                        <option value="MN">Minnesota</option>
                                        <option value="MS">Mississippi</option>
                                        <option value="MO">Missouri</option>
                                        <option value="MT">Montana</option>
                                        <option value="NE">Nebraska</option>
                                        <option value="NV">Nevada</option>
                                        <option value="NH">New Hampshire</option>
                                        <option value="NJ">New Jersey</option>
                                        <option value="NM">New Mexico</option>
                                        <option value="NY">New York</option>
                                        <option value="NC">North Carolina</option>
                                        <option value="ND">North Dakota</option>
                                        <option value="OH">Ohio</option>
                                        <option value="OK">Oklahoma</option>
                                        <option value="OR">Oregon</option>
                                        <option value="PA">Pennsylvania</option>
                                        <option value="RI">Rhode Island</option>
                                        <option value="SC">South Carolina</option>
                                        <option value="SD">South Dakota</option>
                                        <option value="TN">Tennessee</option>
                                        <option value="TX">Texas</option>
                                        <option value="UT">Utah</option>
                                        <option value="VT">Vermont</option>
                                        <option value="VA">Virginia</option>
                                        <option value="WA">Washington</option>
                                        <option value="WV">West Virginia</option>
                                        <option value="WI">Wisconsin</option>
                                        <option value="WY">Wyoming</option>
                                    </select> -->

                                </td>
                            </tr>
                            <!-- <tr>
				<th>일반전화</th>
				<td><input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel">&nbsp;-&nbsp;<input type="text" class="input_tel"></td>
			</tr> -->
                            <tr>
                                <th>Cell phone</th>
                                <td><input type="text" name="rhtel" class="input_email"></td>
                            </tr>

                            <tr>
                                <th>Requirements for delivery</th>
                                <td><input type="text" name="rcontent" class="input_name"></td>
                            </tr>
                        </table>

                        <div class="sp30"></div>

                        <div class="order_title">
                            Payment method
                        </div>

                        <div class="sp10"></div>
                        <!-- <script type="text/javascript"> -->
                        <!-- <!-- -->
                        <!-- 	function coin_sum(){ -->
                        <!-- 		total_price1=<?= $total_settle_num ?>-document.join.usepoint.value; -->
                        <!-- 		var s = total_price1.toString();  -->
                        <!-- 		var s2 = s.replace(/(,|\s)+/g,'');  -->
                        <!-- 		total_price1 = s2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g,'$1,');  -->
                        <!-- 		document.join.total_price123.value=total_price1+"&nbsp;원"; -->
                        <!-- 		} -->
                        <!-- //-->
                        <!-- </script> -->
                        <table class="order_table">


                            <!-- <tr>
				<th>Use the point</th>
				<td>
					<input name="usepoint" type="number" class="userpoint" id="userpoint" class="input_name"  placehoder="Please enter the shopping point you want to use." id="textfield7" size="15">


				</td>
			</tr> -->
                            <tr>
                                <th>Expected amount of money (<?=htmlspecialchars($payment_currency, ENT_QUOTES, 'UTF-8')?>)</th>
                                <td>
                                    <input type="text" id="exMoney" class="input_name" value="<?=htmlspecialchars($ex_money_display, ENT_QUOTES, 'UTF-8')?>" readonly size="15">
                                </td>
                            </tr>
                            <!-- <tr>
				<th>입금예정 계좌번호</th>
				<td>
					<input name="bank" type="text"  id="bank" class="input_name"  placehoder="입금할 은행 계좌번호를 입력해주세요" id="textfield7" size="30">
				</td>
			</tr> -->
                            <tr class="bank" <? if ($onlyP == 0) { ?>style="" <? } else { ?>style="display: none;" <? } ?>>
                                <th>Name of depositor</th>
                                <td>
                                    <input name="in_name" type="text" id="in_name" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="15">
                                </td>
                            </tr>
                            <tr class="bank" <? if ($onlyP == 0) { ?>style="" <? } else { ?>style="display: none;" <? } ?>>
                                <th>Deposit information</th>
                                <td>
                                    <?=htmlspecialchars(pkshop_site_setting('payment_bank_line1'), ENT_QUOTES, 'UTF-8')?><br>
                                    <?=htmlspecialchars(pkshop_site_setting('payment_bank_line2'), ENT_QUOTES, 'UTF-8')?><br>
                                    <?=htmlspecialchars(pkshop_site_setting('payment_bank_line3'), ENT_QUOTES, 'UTF-8')?>
                                </td>
                            </tr>
                            <tr class="point" <? if ($onlyP > 0) { ?>style="" <? } else { ?>style="display: none;" <? } ?>>
                                <th>My own points</th>
                                <td>
                                    <input  type="text" class="input_name" value="<?= $json_balance["emoney"] ?>" readonly id="textfield7" size="15">
                                </td>
                            </tr>
                            <tr>
                                <th>Payment method.</th>
                                <td>

                                    <? if ($onlyP > 0) { ?>
                                        <input name="paymentkind" class="paymentkind" type="radio" value="5" checked>
                                        POINT
                                    <? } else { ?>
                                        <label><input name="paymentkind" class="paymentkind" type="radio" value="2" checked>
                                        BANK</label>
                                        <label><input name="paymentkind" class="paymentkind" type="radio" value="1">
                                        CARD</label>
<!-- <span style="color:#c3070b"> <B>Sorry! currently we are testing card payment integration.</B></span> -->

                                    <? } ?>
                                    <!-- <input name="paymentkind" type="radio" value="2" checked>
 					무통장결제   -->
                                    <!-- 					<input name="paymentkind" type="radio" value="1"> -->
                                    <!-- 					카드결제 -->
                                    <!-- 					<input name="paymentkind" type="radio" value="3"> -->
                                    <!-- 					계좌이체(에스크로) -->
                                </td>
                            </tr>
                            <!-- <tr class="card" style="display: none;" >
                                <th>Card Number</th>
                                <td>
                                    <input name="card1" type="text" id="card1" style="width:20%;" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="4">
                                    -
                                    <input name="card1" type="text" id="card1" style="width:20%;" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="4">
                                    -
                                    <input name="card1" type="text" id="card1" style="width:20%;" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="4">
                                    -
                                    <input name="card1" type="text" id="card1" style="width:20%;" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="4">
                                </td>
                            </tr>
                            <tr class="card" style="display: none;" >
                                <th>EXPIRATION DATE</th>
                                <td>
                                <input name="card1" type="text" id="card1" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="2">
                                    /
                                    <input name="card1" type="text" id="card1" class="input_name" placehoder="입금자 이름을 입력하세요" id="textfield7" size="2">
                                </td>
                            </tr> -->

                        </table>


                        <div class="sp20"></div>

                        <div class="view_btn">
                            <input type="button" value="Cancellation" class="cart_btn01" onclick="location.href='./cart.php'">

                            <input type="button" value="Order" class="cart_btn03 bank" <? if ($out111 == "Y") { ?>onclick="javascript:sold_out()" <? } else { ?>onclick="javascript:paygo();" <? } ?>>&nbsp;
                            <input type="button" value="Order" class="cart_btn03 card" id="cardBtn" style="display:none">&nbsp;
                        </div>
                        	<!-- 옵션 -->
                            <?

                                $merchantKey	= "4G6hpuj0n9+3KgY+aSGn/S8+DwRV75qLns9mFhTybrFFGuQYs0B38Zj75ZpVjSAS0ipSbN4Xqq/3UTEQ8eEZwg==";
                                $merchantID		= "or0000001m";					// 상점아이디
                                $goodsNm		= "PGTEST"; 						// 결제상품명
                                							// 결제상품금액
                                $ordNm  		= "PGTEST";							// 구매자명
                                $ordTel			= "01000000000"; 					// 구매자연락처
                                $ordEmail		= "abcd@zxcv.com"; 					// 구매자메일주소
                                $ordNo			= "hcglboal".date("mdHis").rand(0000,9999);					// 상품주문번호
                                $returnUrl		= "./finish.php"; 			// 결과페이지(절대경로)
                                // $total_settle_num=1;
                                // $total_settle_num=1;
                                $goodsAmt=$total_settle_num;

                                // $goodsAmt=$total_settle_num;
                                $goodsNm=$title_array;
                                $ediDate = date("YmdHis");
                                $encData = bin2hex(hash('sha256', $merchantID.$ediDate.$goodsAmt.$merchantKey, true));
                            ?>

    <input type="hidden" id="sndPaymethod" name="sndPaymethod" value="1000000000">
    <input type="hidden" id="sndStoreid" name="sndStoreid" value="2001107183">
    <input type="hidden" id="sndOrdernumber" name="sndOrdernumber" value="<?=$ordNo?>">
    <input type="hidden" id="sndGoodname" name="sndGoodname" value="<?=$title_array?>">
    <input type="hidden" id="sndAmount" name="sndAmount" value="<?=$goodsAmt*1000?>">
    <input type="hidden" id="sndOrdername" name="sndOrdername" value="<?=$ordNm?>">
    <input type="hidden" id="sndEmail" name="sndEmail" value="<?=$email?>">
    <input type="hidden" id="sndMobile" name="sndMobile" value="<?=$ordTel?>">


	<!-- 0. 공통 환경설정 -->
	<input type=hidden	name=sndReply value="">
	<input type=hidden	name=sndCharSet value="UTF-8">	<!-- 가맹점 CharSet 환경 EUC-KR, UTF-8-->
	<input type=hidden  name=sndGoodType value="1"> 	<!-- 상품유형: 실물(1),디지털(2) -->

	<!-- 1. 신용카드 관련설정 -->

	<!-- 신용카드 결제방법  -->
	<!-- 일반적인 업체의 경우 ISP,안심결제만 사용하면 되며 다른 결제방법 추가시에는 사전에 협의이후 적용바랍니다 -->
	<input type=hidden  name=sndShowcard value="C(25)">

	<!-- 신용카드(해외카드) 통화코드: 해외카드결제시 달러결제를 사용할경우 변경 -->
	<input type=hidden	name=sndCurrencytype value="USD"> <!-- 원화(WON), 달러(USD) -->
	<input type=hidden	name=iframeYn value="Y"> <!-- 원화(WON), 달러(USD) -->

	<!-- 할부개월수 선택범위 -->
	<!--상점에서 적용할 할부개월수를 세팅합니다. 여기서 세팅하신 값은 결제창에서 고객이 스크롤하여 선택하게 됩니다 -->
	<!--아래의 예의경우 고객은 0~12개월의 할부거래를 선택할수있게 됩니다. -->
	<input type=hidden	name=sndInstallmenttype value="ALL(0:2:3:4:5:6:7:8:9:10:11:12)">

	<!-- 가맹점부담 무이자할부설정 -->
	<!-- 카드사 무이자행사만 이용하실경우  또는 무이자 할부를 적용하지 않는 업체는  "NONE"로 세팅  -->
	<!-- 예 : 전체카드사 및 전체 할부에대해서 무이자 적용할 때는 value="ALL" / 무이자 미적용할 때는 value="NONE" -->
	<!-- 예 : 전체카드사 3,4,5,6개월 무이자 적용할 때는 value="ALL(3:4:5:6)" -->
	<!-- 예 : 삼성카드(카드사코드:04) 2,3개월 무이자 적용할 때는 value="04(3:4:5:6)"-->
	<!-- <input type=hidden	name=sndInteresttype value="10(02:03),05(06)"> -->
	<input type=hidden	name=sndInteresttype value="NONE">

	<!-- 카카오페이 사용시 필수 세팅 값 -->
	<input type=hidden name=sndStoreCeoName         value="">  <!--  카카오페이용 상점대표자명 -->
	<input type=hidden name=sndStorePhoneNo         value="">  <!--  카카오페이 연락처 -->
	<input type=hidden name=sndStoreAddress         value="">  <!--  카카오페이 주소 -->

	<!-- 2. 온라인입금(가상계좌) 관련설정 -->
	<input type=hidden	name=sndEscrow value="0"> 			        <!-- 에스크로사용여부 (0:사용안함, 1:사용) -->

	<!-- 3. 계좌이체 현금영수증발급여부 설정 -->
	<input type=hidden  name=sndCashReceipt value="0">          <!--계좌이체시 현금영수증 발급여부 (0: 발급안함, 1:발급) -->


<!----------------------------------------------- <Part 3. 승인응답 결과데이터>  ----------------------------------------------->
<!-- 결과데이타: 승인이후 자동으로 채워집니다. (*변수명을 변경하지 마세요) -->

	<input type=hidden name=reCommConId 	value="">
	<input type=hidden name=reCommType 	value="">
	<input type=hidden name=reHash 	            value="">


<!--------------------------------------------------------------------------------------------------------------------------->

<!--업체에서 추가하고자하는 임의의 파라미터를 입력하면 됩니다.-->
<!--이 파라메터들은 지정된결과 페이지(kspay_result.php)로 전송됩니다.-->
	<input type=hidden name=a        value="a1">
	<input type=hidden name=b        value="b1">
	<input type=hidden name=c        value="c1">
	<input type=hidden name=d        value="d1">



    <input type="hidden" id="payMethod" name="payMethod" value="card">
    <input type="hidden" id="mid" name="mid" value="<?php echo($merchantID)?>">
    <input type="hidden" id="goodsNm" name="goodsNm" value="<?php echo($goodsNm)?>">
    <input type="hidden" id="ordNo" name="ordNo" value="<?php echo($ordNo)?>">
    <input type="hidden" id="goodsAmt" name="goodsAmt" value="<?php echo($goodsAmt)?>">
    <input type="hidden" id="ordNm" name="ordNm" value="<?php echo($ordNm)?>">
    <input type="hidden" id="ordTel" name="ordTel" value="<?php echo($ordTel)?>">
    <input type="hidden" name="ordEmail" value="<?php echo($email)?>">
    <input type="hidden" name="returnUrl" value="<?php echo($returnUrl)?>">
    <input type="hidden" name="notiUrl" value="">
	<input type="hidden" name="userIp"	value="<?=$_SERVER['HTTP_X_FORWARDED_FOR']?>">
	<input type="hidden" name="trxCd"	value="0">
	<input type="hidden" name="tid" id="tid">
	<input type="hidden" name="mbsUsrId" value="user1234">
	<input type="hidden" name="mbsReserved" value="MallReserved">

	<!-- <input type="hidden" name="goodsSplAmt" value="0"> -->
	<!-- <input type="hidden" name="goodsVat" value="0"> -->
	<!-- <input type="hidden" name="goodsSvsAmt" value="0"> -->

	<input type="hidden" name="charSet" value="UTF-8">
	<input type="hidden" name="appMode" value="1">
	<!-- <input type="hidden" name="period" value="별도 제공기간없음"> -->

	<!-- 변경 불가능 -->
	<input type="hidden" name="ediDate" value="<?php echo($ediDate)?>"><!-- 전문 생성일시 -->
	<input type="hidden" name="encData" value="<?php echo($encData)?>"><!-- 해쉬값 -->
                    </form>

                </div>


            </div>
        </div>
        <!-- 컨텐츠 종료 -->

        <!-- 하단(Copy) -->

        <div class="sp50"></div>
        <? include "../include/bottom.php"; ?>


        <!-- 하단(Copy) -->
    </div>
    <!-- <button id="popOpenBtn">Popup Open</button> -->
    <div id="popup_mask"></div> <!-- 팝업 배경 DIV -->

    <div id="popupDiv">
        <!-- 팝업창 -->
        <!-- <button id="popCloseBtn" >close</button> -->
        <!-- <div style="text-align:center;"> -->
        <div style="    margin-top: 15%;
    vertical-align: middle;
    padding: 3% 10%;
    background-color: #29d0e5;
    text-align:center;
    font-size: 1.5em;
    color: #fff;
    font-weight: bold;
    border-radius: 10px;">Please wait</div>
    </div>
    <!-- </div> -->
<?php if (!empty($icopay_unified_ui)) { ?>
    <script src="./icopay-checkout.js"></script>
    <style>
        #icopayUnifiedModal {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 20px 16px;
            box-sizing: border-box;
            overflow-y: auto;
        }
        .icopay-unified-modal-card {
            background: #fff;
            max-width: 560px;
            width: 100%;
            margin: 0;
            padding: 18px 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.15);
        }
        .icopay-unified-embed-wrap {
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            line-height: 0;
        }
        #icopayUnifiedHost {
            width: 100%;
            min-height: 0;
            overflow: hidden;
            line-height: 0;
        }
        #icopayUnifiedHost iframe {
            display: block;
            overflow: hidden;
            vertical-align: top;
        }
        .icopay-unified-cancel-wrap {
            margin-top: 8px;
            padding-bottom: 18px;
            text-align: center;
        }
        .icopay-unified-cancel-wrap .cart_btn01 {
            width: 150px;
            height: 45px;
            margin: 0 auto;
            font-weight: 700;
        }
        @media (min-width: 768px) {
            #icopayUnifiedModal {
                overflow: hidden;
                padding-top: 28px;
            }
            .icopay-unified-embed-wrap,
            #icopayUnifiedHost,
            #icopayUnifiedHost iframe {
                overflow: hidden !important;
            }
        }
    </style>
    <div id="icopayUnifiedModal" style="display:none;position:fixed;z-index:10000;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.55);">
        <div class="icopay-unified-modal-card">
            <p id="icopayUnifiedStatus" style="display:none;font-size:13px;color:#0a7;margin:10px 0;">Preparing payment…</p>
            <div id="icopayUnifiedEmbed" class="icopay-unified-embed-wrap">
                <div id="icopayUnifiedHost"></div>
            </div>
            <div class="icopay-unified-cancel-wrap">
                <button type="button" id="icopayUnifiedCancelBtn" class="cart_btn01" onclick="icopayUnifiedCloseModal()">Cancel</button>
            </div>
        </div>
    </div>
<?php } elseif (!empty($icopay_chillpay_ui)) { ?>
    <div id="icopayChillpayModal" style="display:none;position:fixed;z-index:10000;left:0;top:0;width:100%;height:100%;overflow:auto;background:rgba(0,0,0,0.55);">
        <div style="background:#fff;max-width:540px;margin:48px auto;padding:24px;border-radius:10px;box-shadow:0 4px 24px rgba(0,0,0,0.15);">
            <p style="margin-top:0;font-weight:bold;font-size:18px;letter-spacing:0.05em;">ICOPAY</p>
            <p id="icopayChillpayCcdStatus" style="display:none;font-size:13px;color:#0a7;margin:10px 0;">Loading card form…</p>
            <form id="icopayCcdForm" action="#" method="post" onsubmit="return false;">
                <div id="ccdinline-card-name" class="ccdinline-card-name" style="margin-bottom:8px;"></div>
                <div id="ccdinline-card-number" class="ccdinline-card-number" style="margin-bottom:8px;"></div>
                <div id="ccdinline-card-expiry" class="ccdinline-card-expiry" style="margin-bottom:8px;"></div>
                <div id="ccdinline-card-cvv" class="ccdinline-card-cvv" style="margin-bottom:8px;"></div>
                <div id="ccdinline-card-remember" class="ccdinline-card-remember" style="margin-bottom:16px;"></div>
                <button type="button" id="icopayChillpayPayBtn" class="cart_btn01" style="display:none;width:100%;margin-bottom:10px;background:#1a7f37;color:#fff;font-weight:bold;" onclick="icopayChillpaySubmitToken()">Proceed Payment</button>
                <button type="button" class="cart_btn01" onclick="icopayChillpayCloseModal()">Cancel</button>
            </form>
        </div>
    </div>
    <script>
        function icopayChillpayCloseModal() {
            try {
                if (typeof icopayChillpayClearCcdFallbackTimer === 'function') {
                    icopayChillpayClearCcdFallbackTimer();
                }
            } catch (eCl) {}
            try {
                window.__icopayCcdPayButtonShown = false;
            } catch (eFl) {}
            $("#icopayChillpayPayBtn").css("display", "none").prop("disabled", false);
            $("#icopayChillpayCcdStatus").css("display", "none");
            $("#icopayChillpayModal").css("display", "none");
            $("#popup_mask").css("display", "none");
            $("body").css("overflow", "auto");
        }
    </script>
<?php } ?>
</body>
<script>
    $(".userpoint").on("keyup", function() {
        var shop_bonus = parseFloat("<?= $json_balance['emoney'] ?>");
        var userpoint = $(this).val();
        var total_settle_usd = parseFloat("<?= $total_settle_num ?>");
        var total_settle_payment = parseFloat("<?= (int)$total_settle_payment_amt ?>");
        var paymentSymbol = "<?=htmlspecialchars(pkshop_currency_options()[$payment_currency]['symbol'], ENT_QUOTES, 'UTF-8')?>";

        if (userpoint > shop_bonus) {
            userpoint = shop_bonus;
        }
        if (userpoint > total_settle_usd) {
            userpoint = total_settle_usd;
        }
        if (userpoint == "" || userpoint == undefined || isNaN(userpoint)) {
            userpoint = 0;
        }

        var remain_usd = total_settle_usd - userpoint;
        var remain_payment = total_settle_payment;
        if (total_settle_usd > 0) {
            remain_payment = Math.round(remain_usd * (total_settle_payment / total_settle_usd));
        }
        $("#exMoney").val(paymentSymbol + ' ' + remain_payment.toLocaleString());
        $(this).val(userpoint);
    });
    $(document).ready(function() {
        $(".paymentkind").on("change", function() {
            var val = $('input[name=paymentkind]:checked').val();
            if (val == undefined || val == 2) {
                $(".bank").show();
                $(".card").hide();
                $(".point").hide();
            } else if (val == 1) {
                $(".bank").hide();
                $(".point").hide();
                $(".card").show();
            } else if (val == 5) {
                $(".bank").hide();
                $(".card").hide();
                $(".point").show();
            }

        });
        $(".paymentkind").filter(":checked").first().trigger("change");

        $("#cardBtn").click(function(event) { //팝업 Open 버튼 클릭 시

            doPaySubmit();
            // pay();
        });

        $("#popCloseBtn").click(function(event) {
            $("#popup_mask").css("display", "none"); //팝업창 뒷배경 display none
            $("#popupDiv").css("display", "none"); //팝업창 display none
            $("body").css("overflow", "auto"); //body 스크롤바 생성
        });
        var pay = function() {
            <?
            if (!$_SESSION['member_id']) {
            ?>
                alert("You have to log in to pay for it's");
                location.href = 'cart.php';
                return false;
            <? } ?>

            var bonus = parseFloat(<?= $json_balance['total_SP'] ?>);
            // var usepoint = parseFloat($("#userpoint").val());
            var total_settle = parseFloat($("#total_settle").val());
            // var total_settle = parseFloat($("#total_settle").val());
            // if(total_settle > bonus){
            // 	alert("보유 쇼핑 포인트보다 많이 구매할수없습니다");
            // 	return false;
            // }
            // if(userpoint != "" && usepoint >0){
            // 	if(usepoint > bonus){
            // 		alert("You can't use it more than your shopping points.");
            // 		return false;
            // 	}
            // 	if(usepoint > total_settle){
            // 		alert("You can't use more points than the product price.");
            // 		return false;
            // 	}

            // }
            icopayChillpaySyncAllPayerFields(document.join);
            if (!String(document.join.buyername.value || '').trim()) {
                alert('Order please enter firstname.');
                document.join.buyername.focus();
                return;
            }
            if (!String(document.join.buyername_l.value || '').trim()) {
                alert('Order please enter lastname.');
                document.join.buyername_l.focus();
                return;
            }
            if (!document.join.post.value) {
                alert('Please enter the zip code of the orderer.');
                document.join.post1.focus();
                return;
            }

            if (!document.join.addr1.value) {
                alert('Enter the address of the orderer.');
                document.join.addr1.focus();
                return;
            }

            if (!document.join.city.value) {
                alert('Please enter the city of the orderer.');
                document.join.post1.focus();
                return;
            }
            if (!document.join.state.value) {
                alert('Please enter the state of the orderer.');
                document.join.post1.focus();
                return;
            }

            if (!document.join.htel.value) {
                alert('Please enter the contact information of the orderer.');
                document.join.htel.focus();
                return;
            }

            if (!document.join.email.value) {
                alert('Enter the orderer\'\s email.');
                document.join.email.focus();
                return;
            }

            if (!document.join.recvname.value) {
                alert('Enter the recipient\'\s firstname.');
                document.join.recvname.focus();
                return;
            }

            if (!document.join.recvname_l.value) {
                alert('Enter the recipient\'\s lastname.');
                document.join.recvname.focus();
                return;
            }

            //if (Number(GP) < Number(document.join.usepoint.value) )
            {
                // alert('코인이 부족합니다.');
                // document.join.usepoint.focus();
                // return;
            }
            //   if(!document.join.rhtel.value) {
            //      alert('배송지 연락처를 입력하세요.');
            //      document.join.rhtel.focus();
            //      return;
            //   }
            //   <? if ($valid_user) { ?>
            //	   if(document.join.usepoint.value!="") {
            //		  if(parseInt(document.join.usepoint.value)>'<?= $kk_point ?>'){
            //			 alert('사용하실코인이 보유코인을 초과하였습니다.');
            //			document.join.usepoint.focus();
            //			return;
            //		  }
            //	   }
            //	   var kk_point = '<?= $kk_point ?>';
            //	   if(document.join.usepoint.value!="") {
            //		  if(parseInt(document.join.usepoint.value)>parseInt(document.join.total_coin1.value)){
            //			 alert('사용가능한 코인을 초과하였습니다.');
            //			document.join.usepoint.focus();
            //			return;
            //		  }
            //	   }
            //	<? } ?>


            // if(document.join.paymentkind.checked==true){
            // 	if(document.join.in_name.value==""){
            // 		alert('Please enter the name of the depositor.');
            // 		document.join.in_name.focus();
            // 		return;
            // 	}

            // }

            //alert(document.join.receive.value);

            $("#popupDiv").css({
                "top": (($(window).height() / 2 - $("#popupDiv").outerHeight()) / 2 + $(window).scrollTop()) + "px",
                "left": (($(window).width() - $("#popupDiv").outerWidth()) / 2 + $(window).scrollLeft()) + "px"
                //팝업창을 가운데로 띄우기 위해 현재 화면의 가운데 값과 스크롤 값을 계산하여 팝업창 CSS 설정

            });

            $("#popup_mask").css("display", "block"); //팝업 뒷배경 display block
            $("#popupDiv").css("display", "block"); //팝업창 display block

            $("body").css("overflow", "hidden"); //body 스크롤바 없애기
            $.ajax({
                type: "POST",
                url: "./order_ok.php",
                async:false,
                data: $("#join").serialize(),
                dataType: "json",
                success: function(response) {
                    // console.log(response);
                    if (response.result == 1) {
                        $("#popup_mask").css("display", "none"); //팝업 뒷배경 display block
                        $("#popupDiv").css("display", "none"); //팝업창 display block
                        alert(response.msg);
                        if (response.paymentUrl != "" && response.paymentUrl != undefined) {
                            location.href = response.paymentUrl;
                            return false;
                        } else {
                            location.href = "./finish.php";
                            return false;
                        }
                        return false;
                    } else {
                        alert(response.msg);
                        return false;
                    }
                }
            });
            //    document.join.submit();

        }
        //



    });
</script>

</html>
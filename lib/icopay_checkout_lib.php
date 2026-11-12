<?php
/**
 * ICOPAY unified checkout helpers for PKSHOP cart.
 */
if (!defined('ICOPAY_PUBLIC_BASE')) {
    require_once dirname(__FILE__) . '/icopay_pg_config.php';
}
require_once dirname(__FILE__) . '/IcopayMerchantApi.php';

if (!function_exists('pkshop_icopay_merchant_api')) {
    function pkshop_icopay_merchant_api()
    {
        if (!defined('ICOPAY_COMP_ID') || ICOPAY_COMP_ID === ''
            || !defined('ICOPAY_BROKER_SECRET') || ICOPAY_BROKER_SECRET === '') {
            return null;
        }
        $base = defined('ICOPAY_PUBLIC_BASE') ? ICOPAY_PUBLIC_BASE : 'https://api.icopay.co.kr';
        return new IcopayMerchantApi($base, ICOPAY_COMP_ID, ICOPAY_BROKER_SECRET);
    }
}

if (!function_exists('pkshop_icopay_checkout_currency')) {
    function pkshop_icopay_checkout_currency()
    {
        if (defined('ICOPAY_CHECKOUT_CURRENCY') && ICOPAY_CHECKOUT_CURRENCY !== '') {
            return strtoupper(ICOPAY_CHECKOUT_CURRENCY);
        }
        if (defined('ICOPAY_CHILL_PAY_CURRENCY') && ICOPAY_CHILL_PAY_CURRENCY !== '') {
            return strtoupper(ICOPAY_CHILL_PAY_CURRENCY);
        }
        if (function_exists('pkshop_get_payment_currency')) {
            return pkshop_get_payment_currency();
        }
        return 'JPY';
    }
}

if (!function_exists('pkshop_icopay_checkout_lang')) {
    function pkshop_icopay_checkout_lang()
    {
        if (defined('ICOPAY_CHECKOUT_LANG') && ICOPAY_CHECKOUT_LANG !== '') {
            return ICOPAY_CHECKOUT_LANG;
        }
        return 'ENG';
    }
}

if (!function_exists('pkshop_icopay_normalize_phone')) {
    function pkshop_icopay_normalize_phone($phone, $countryIso2 = 'JP')
    {
        $digits = preg_replace('/\D+/', '', (string)$phone);
        $countryIso2 = strtoupper((string)$countryIso2);
        if ($countryIso2 === 'JP' && strpos($digits, '81') === 0 && strlen($digits) > 10) {
            $digits = substr($digits, 2);
        }
        if ($countryIso2 === 'KR' && strpos($digits, '82') === 0 && strlen($digits) > 10) {
            $digits = substr($digits, 2);
        }
        if (strpos($digits, '0') === 0) {
            $digits = ltrim($digits, '0');
        }
        return $digits;
    }
}

if (!function_exists('pkshop_icopay_buyer_from_order_post')) {
    function pkshop_icopay_buyer_from_order_post(array $post)
    {
        $country = 'JP';
        if (!empty($post['icopay_country'])) {
            $country = strtoupper(substr(trim((string)$post['icopay_country']), 0, 2));
        } elseif (!empty($post['country'])) {
            $country = strtoupper(substr(trim((string)$post['country']), 0, 2));
        } elseif (!empty($post['state']) && strlen(trim((string)$post['state'])) === 2) {
            $country = strtoupper(trim((string)$post['state']));
        }

        $email = isset($post['email']) ? trim((string)$post['email']) : '';
        $phone = isset($post['htel']) ? trim((string)$post['htel']) : '';
        if ($phone === '' && isset($post['tel'])) {
            $phone = trim((string)$post['tel']);
        }

        $buyer = array(
            'email' => $email,
            'phone' => pkshop_icopay_normalize_phone($phone, $country),
            'countryIso2' => $country,
        );

        $first = isset($post['buyername']) ? trim((string)$post['buyername']) : '';
        if ($first === '' && !empty($post['firstName'])) {
            $first = trim((string)$post['firstName']);
        }
        $last = isset($post['buyername_l']) ? trim((string)$post['buyername_l']) : '';
        if ($last === '' && !empty($post['lastName'])) {
            $last = trim((string)$post['lastName']);
        }
        if ($first !== '' && $last === '') {
            $parts = preg_split('/\s+/u', $first, -1, PREG_SPLIT_NO_EMPTY);
            if (is_array($parts) && count($parts) >= 2) {
                $last = $parts[0];
                $first = implode(' ', array_slice($parts, 1));
            } else {
                $last = $first;
            }
        } elseif ($last !== '' && $first === '') {
            $parts = preg_split('/\s+/u', $last, -1, PREG_SPLIT_NO_EMPTY);
            if (is_array($parts) && count($parts) >= 2) {
                $last = $parts[0];
                $first = implode(' ', array_slice($parts, 1));
            } else {
                $first = $last;
            }
        }
        $fullName = trim($last . ' ' . $first);
        if ($fullName === '') {
            $fullName = $first !== '' ? $first : $last;
        }
        if ($fullName !== '') {
            $buyer['name'] = $fullName;
        }
        if ($first !== '') {
            $buyer['firstName'] = $first;
        }
        if ($last !== '') {
            $buyer['lastName'] = $last;
        }

        if (!empty($post['addr1'])) {
            $buyer['address'] = trim((string)$post['addr1']);
        }
        if (!empty($post['addr2'])) {
            $buyer['address2'] = trim((string)$post['addr2']);
        }
        if (!empty($post['city'])) {
            $buyer['city'] = trim((string)$post['city']);
        }
        if (!empty($post['state'])) {
            $buyer['state'] = trim((string)$post['state']);
        }
        if (!empty($post['post'])) {
            $buyer['postcode'] = preg_replace('/\s+/', '', (string)$post['post']);
        }

        return $buyer;
    }
}

if (!function_exists('pkshop_icopay_payment_amount')) {
    function pkshop_icopay_payment_amount($usd_total)
    {
        $currency = pkshop_icopay_checkout_currency();
        if (function_exists('pkshop_convert_usd_amount')) {
            return (int)pkshop_convert_usd_amount($usd_total, $currency);
        }
        return (int)round((float)$usd_total);
    }
}

if (!function_exists('pkshop_icopay_is_paid_status')) {
    function pkshop_icopay_is_paid_status($status)
    {
        $status = strtoupper(trim((string)$status));
        return in_array($status, array('PAID', 'SUCCESS', 'SUCCEEDED', 'APPROVED', 'COMPLETED', 'COMPLETE'), true);
    }
}

if (!function_exists('pkshop_icopay_extract_tid')) {
    function pkshop_icopay_extract_tid(array $data)
    {
        foreach (array('transactionId', 'TransactionId', 'tid', 'paymentId', 'pgTransactionId', 'referenceNo') as $k) {
            if (!empty($data[$k])) {
                return trim((string)$data[$k]);
            }
        }
        return '';
    }
}

if (!function_exists('pkshop_icopay_finalize_order')) {
    function pkshop_icopay_finalize_order($ediDate, $tid, $api_category)
    {
        if ($ediDate === '' || $tid === '' || !function_exists('curl_d')) {
            return false;
        }
        curl_d($api_category, '&Type=orderUpdate&ediDate=' . rawurlencode($ediDate) . '&tid=' . rawurlencode($tid));
        return true;
    }
}

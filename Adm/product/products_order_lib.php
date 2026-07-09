<?php

function pkshop_product_order_field($sel_code1, $sel_code2, $sel_code3, $sel_code4) {
    if ($sel_code4 !== '' && $sel_code4 !== '00') {
        return 'order4';
    }
    if ($sel_code3 !== '' && $sel_code3 !== '00') {
        return 'order3';
    }
    if ($sel_code2 !== '' && $sel_code2 !== '00') {
        return 'order2';
    }
    return 'order1';
}

function pkshop_product_order_where($soldout, $sel_code1, $sel_code2, $sel_code3, $sel_code4) {
    if ($soldout === 'Y') {
        $where = "soldout='Y'";
    } else {
        $where = "soldout<>''";
    }

    if ($sel_code1 !== '') {
        $where .= " AND code1='" . addslashes($sel_code1) . "'";
    }
    if ($sel_code2 !== '' && $sel_code2 !== '00') {
        $where .= " AND code2='" . addslashes($sel_code2) . "'";
    }
    if ($sel_code3 !== '' && $sel_code3 !== '00') {
        $where .= " AND code3='" . addslashes($sel_code3) . "'";
    }
    if ($sel_code4 !== '' && $sel_code4 !== '00') {
        $where .= " AND code4='" . addslashes($sel_code4) . "'";
    }

    return $where;
}

function pkshop_product_move_order($DB, $shop_goods, $no, $dir, $soldout, $sel_code1, $sel_code2, $sel_code3, $sel_code4) {
    $no = intval($no);
    if ($no <= 0) {
        return array('ok' => false, 'message' => '상품 번호가 올바르지 않습니다.');
    }
    if ($sel_code1 === '') {
        return array('ok' => false, 'message' => '1차 카테고리를 선택하세요.');
    }
    if ($dir !== 'up' && $dir !== 'down') {
        return array('ok' => false, 'message' => '이동 방향이 올바르지 않습니다.');
    }

    $order_field = pkshop_product_order_field($sel_code1, $sel_code2, $sel_code3, $sel_code4);
    $where = pkshop_product_order_where($soldout, $sel_code1, $sel_code2, $sel_code3, $sel_code4);
    $sql = "SELECT No, {$order_field} AS ord_val FROM {$shop_goods} WHERE {$where} ORDER BY {$order_field} ASC, signdate DESC, No ASC";
    $DB->get($sql, $rows, $rn);

    if ($rn < 2) {
        return array('ok' => false, 'message' => '순서를 변경할 상품이 충분하지 않습니다.');
    }

    $idx = -1;
    for ($i = 0; $i < $rn; $i++) {
        if (intval($rows[$i]['No']) === $no) {
            $idx = $i;
            break;
        }
    }
    if ($idx < 0) {
        return array('ok' => false, 'message' => '상품을 찾을 수 없습니다.');
    }

    $swap_idx = -1;
    if ($dir === 'up' && $idx > 0) {
        $swap_idx = $idx - 1;
    } elseif ($dir === 'down' && $idx < $rn - 1) {
        $swap_idx = $idx + 1;
    } else {
        return array('ok' => false, 'message' => '더 이상 이동할 수 없습니다.');
    }

    $a = $rows[$idx];
    $b = $rows[$swap_idx];
    $ord_a = intval($a['ord_val']);
    $ord_b = intval($b['ord_val']);

    if ($ord_a === $ord_b) {
        if ($dir === 'up') {
            $ord_a = max(1, $ord_b - 1);
        } else {
            $ord_a = $ord_b + 1;
        }
        $DB->update($shop_goods, "{$order_field}='{$ord_a}' WHERE No='{$no}'");
        return array('ok' => true, 'message' => '순서가 변경되었습니다.');
    }

    $no_a = intval($a['No']);
    $no_b = intval($b['No']);
    $DB->update($shop_goods, "{$order_field}='{$ord_b}' WHERE No='{$no_a}'");
    $DB->update($shop_goods, "{$order_field}='{$ord_a}' WHERE No='{$no_b}'");

    return array('ok' => true, 'message' => '순서가 변경되었습니다.');
}

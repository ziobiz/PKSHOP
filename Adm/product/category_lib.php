<?php
/**
 * 카테고리 관리 공통 함수 (분류등록/수정)
 */

if (!function_exists('pkshop_cate_show_field')) {
    function pkshop_cate_show_field($level) {
        return 'show' . intval($level);
    }
}

if (!function_exists('pkshop_cate_name_field')) {
    function pkshop_cate_name_field($level) {
        return 'cate' . intval($level);
    }
}

if (!function_exists('pkshop_cate_code_field')) {
    function pkshop_cate_code_field($level) {
        return 'code' . intval($level);
    }
}

if (!function_exists('pkshop_cate_list_sql')) {
    function pkshop_cate_list_sql($shop_cate, $level, $code1, $code2, $code3) {
        $level = intval($level);
        $code1 = addslashes($code1);
        $code2 = addslashes($code2);
        $code3 = addslashes($code3);
        $name_f = pkshop_cate_name_field($level);
        $code_f = pkshop_cate_code_field($level);
        $show_f = pkshop_cate_show_field($level);

        switch ($level) {
            case 1:
                return "SELECT uid, {$name_f} AS cate_name, {$code_f} AS cate_code, rank, {$show_f} AS cate_show, order_rank "
                    . "FROM {$shop_cate} WHERE code2='00' AND code3='00' AND code4='00' ORDER BY order_rank";
            case 2:
                return "SELECT uid, {$name_f} AS cate_name, {$code_f} AS cate_code, rank, {$show_f} AS cate_show, order_rank "
                    . "FROM {$shop_cate} WHERE code1='{$code1}' AND code2!='00' AND code3='00' AND code4='00' ORDER BY order_rank";
            case 3:
                return "SELECT uid, {$name_f} AS cate_name, {$code_f} AS cate_code, rank, {$show_f} AS cate_show, order_rank "
                    . "FROM {$shop_cate} WHERE code1='{$code1}' AND code2='{$code2}' AND code3!='00' AND code4='00' ORDER BY order_rank";
            case 4:
                return "SELECT uid, {$name_f} AS cate_name, {$code_f} AS cate_code, rank, {$show_f} AS cate_show, order_rank "
                    . "FROM {$shop_cate} WHERE code1='{$code1}' AND code2='{$code2}' AND code3='{$code3}' AND code4!='00' ORDER BY order_rank";
            default:
                return '';
        }
    }
}

if (!function_exists('pkshop_db_cell')) {
    function pkshop_db_cell($row, $key, $index) {
        if (is_array($row) && array_key_exists($key, $row) && $row[$key] !== null && $row[$key] !== '') {
            return $row[$key];
        }
        if (is_array($row) && array_key_exists($index, $row)) {
            return $row[$index];
        }
        return '';
    }
}

if (!function_exists('pkshop_cate_fetch_list')) {
    function pkshop_cate_fetch_list($DB, $shop_cate, $level, $code1, $code2, $code3) {
        $sql = pkshop_cate_list_sql($shop_cate, $level, $code1, $code2, $code3);
        if ($sql === '') {
            return array();
        }
        $DB->get($sql, $rs, $rn);
        $items = array();
        for ($i = 0; $i < $rn; $i++) {
            $row = $rs[$i];
            $items[] = array(
                'uid'         => pkshop_db_cell($row, 'uid', 0),
                'cate_name'   => pkshop_db_cell($row, 'cate_name', 1),
                'cate_code'   => pkshop_db_cell($row, 'cate_code', 2),
                'rank'        => pkshop_db_cell($row, 'rank', 3),
                'cate_show'   => pkshop_db_cell($row, 'cate_show', 4),
                'order_rank'  => pkshop_db_cell($row, 'order_rank', 5),
                'index'       => $i + 1,
            );
        }
        return $items;
    }
}

if (!function_exists('pkshop_cate_load_by_uid')) {
    function pkshop_cate_load_by_uid($DB, $shop_cate, $uid) {
        $uid = addslashes($uid);
        if ($uid === '') {
            return null;
        }
        $DB->get("SELECT uid,cate1,cate2,cate3,cate4,code1,code2,code3,code4 FROM {$shop_cate} WHERE uid='{$uid}'", $rs, $rn);
        if ($rn < 1) {
            return null;
        }
        $row = $rs[0];
        return array(
            'uid'   => pkshop_db_cell($row, 'uid', 0),
            'cate1' => pkshop_db_cell($row, 'cate1', 1),
            'cate2' => pkshop_db_cell($row, 'cate2', 2),
            'cate3' => pkshop_db_cell($row, 'cate3', 3),
            'cate4' => pkshop_db_cell($row, 'cate4', 4),
            'code1' => pkshop_db_cell($row, 'code1', 5),
            'code2' => pkshop_db_cell($row, 'code2', 6),
            'code3' => pkshop_db_cell($row, 'code3', 7),
            'code4' => pkshop_db_cell($row, 'code4', 8),
        );
    }
}

if (!function_exists('pkshop_cate_init_selection')) {
    function pkshop_cate_init_selection($DB, $shop_cate, $uids) {
        $data = array(
            'cate1' => '', 'cate2' => '', 'cate3' => '', 'cate4' => '',
            'code1' => '', 'code2' => '', 'code3' => '', 'code4' => '',
            'cateuid1' => isset($uids['cateuid1']) ? $uids['cateuid1'] : '',
            'cateuid2' => isset($uids['cateuid2']) ? $uids['cateuid2'] : '',
            'cateuid3' => isset($uids['cateuid3']) ? $uids['cateuid3'] : '',
            'cateuid4' => isset($uids['cateuid4']) ? $uids['cateuid4'] : '',
        );

        for ($lv = 1; $lv <= 4; $lv++) {
            $uid_key = 'cateuid' . $lv;
            if ($data[$uid_key] === '') {
                continue;
            }
            $row = pkshop_cate_load_by_uid($DB, $shop_cate, $data[$uid_key]);
            if ($row === null) {
                $data[$uid_key] = '';
                continue;
            }
            for ($j = 1; $j <= $lv; $j++) {
                $data['cate' . $j] = htmlspecialchars(stripslashes($row['cate' . $j]), ENT_QUOTES, 'UTF-8');
                $data['code' . $j] = $row['code' . $j];
            }
        }

        return $data;
    }
}

if (!function_exists('pkshop_cate_next_code')) {
    function pkshop_cate_next_code($DB, $shop_cate, $level, $code1, $code2, $code3) {
        $level = intval($level);
        $code1 = addslashes($code1);
        $code2 = addslashes($code2);
        $code3 = addslashes($code3);

        if ($level === 1) {
            $DB->get("SELECT code1 FROM {$shop_cate} ORDER BY code1 DESC", $rs, $rn);
            $ncode = ($rn > 0 && $rs[0][0] !== '') ? intval($rs[0][0]) + 1 : 1;
            return sprintf('%02d', $ncode);
        }

        if ($level === 2) {
            $DB->get("SELECT code2 FROM {$shop_cate} WHERE code1='{$code1}' ORDER BY code2 DESC", $rs, $rn);
            $ncode = ($rn > 0 && $rs[0][0] !== '' && $rs[0][0] !== '00') ? intval($rs[0][0]) + 1 : 1;
            return sprintf('%02d', $ncode);
        }

        if ($level === 3) {
            $DB->get("SELECT code3 FROM {$shop_cate} WHERE code1='{$code1}' AND code2='{$code2}' ORDER BY code3 DESC", $rs, $rn);
            $ncode = ($rn > 0 && $rs[0][0] !== '' && $rs[0][0] !== '00') ? intval($rs[0][0]) + 1 : 1;
            return sprintf('%02d', $ncode);
        }

        $DB->get("SELECT code4 FROM {$shop_cate} WHERE code1='{$code1}' AND code2='{$code2}' AND code3='{$code3}' ORDER BY code4 DESC", $rs, $rn);
        $ncode = ($rn > 0 && $rs[0][0] !== '' && $rs[0][0] !== '00') ? intval($rs[0][0]) + 1 : 1;
        return sprintf('%02d', $ncode);
    }
}

if (!function_exists('pkshop_cate_parent_ready')) {
    function pkshop_cate_parent_ready($level, $code1, $code2, $code3) {
        if ($level === 1) {
            return true;
        }
        if ($level === 2) {
            return $code1 !== '';
        }
        if ($level === 3) {
            return $code1 !== '' && $code2 !== '' && $code2 !== '00';
        }
        return $code1 !== '' && $code2 !== '' && $code2 !== '00' && $code3 !== '' && $code3 !== '00';
    }
}

if (!function_exists('pkshop_cate_move')) {
    function pkshop_cate_move($DB, $shop_cate, $level, $uid, $dir, $code1, $code2, $code3) {
        $items = pkshop_cate_fetch_list($DB, $shop_cate, $level, $code1, $code2, $code3);
        $idx = -1;
        foreach ($items as $i => $item) {
            if ((string)$item['uid'] === (string)$uid) {
                $idx = $i;
                break;
            }
        }
        if ($idx < 0) {
            return array('ok' => false, 'message' => '카테고리를 찾을 수 없습니다.');
        }

        $swap_idx = -1;
        if ($dir === 'up' && $idx > 0) {
            $swap_idx = $idx - 1;
        } elseif ($dir === 'down' && $idx < count($items) - 1) {
            $swap_idx = $idx + 1;
        } else {
            return array('ok' => false, 'message' => '더 이상 이동할 수 없습니다.');
        }

        $a = $items[$idx];
        $b = $items[$swap_idx];
        $rank_a = $a['order_rank'];
        $rank_b = $b['order_rank'];

        $uid_a = addslashes($a['uid']);
        $uid_b = addslashes($b['uid']);
        $DB->update($shop_cate, "rank='{$rank_b}', order_rank={$rank_b} WHERE uid='{$uid_a}'");
        $DB->update($shop_cate, "rank='{$rank_a}', order_rank={$rank_a} WHERE uid='{$uid_b}'");

        return array('ok' => true, 'message' => '순서가 변경되었습니다.');
    }
}

if (!function_exists('pkshop_cate_toggle_show')) {
    function pkshop_cate_toggle_show($DB, $shop_cate, $level, $uid) {
        $level = intval($level);
        $uid = addslashes($uid);
        $field = pkshop_cate_show_field($level);
        $DB->get("SELECT {$field} FROM {$shop_cate} WHERE uid='{$uid}'", $rs, $rn);
        if ($rn < 1) {
            return array('ok' => false, 'message' => '카테고리를 찾을 수 없습니다.');
        }
        $current = intval($rs[0][0]);
        $new = ($current === 1) ? 0 : 1;
        $DB->update($shop_cate, "{$field}='{$new}' WHERE uid='{$uid}'");
        return array('ok' => true, 'hidden' => $new, 'message' => ($new === 1 ? '숨김 처리되었습니다.' : '노출 처리되었습니다.'));
    }
}

if (!function_exists('pkshop_cate_delete_one')) {
    function pkshop_cate_delete_one($DB, $shop_cate, $level, $uid) {
        $row = pkshop_cate_load_by_uid($DB, $shop_cate, $uid);
        if ($row === null) {
            return array('ok' => false, 'message' => '카테고리를 찾을 수 없습니다.');
        }

        $level = intval($level);
        $code1 = addslashes($row['code1']);
        $code2 = addslashes($row['code2']);
        $code3 = addslashes($row['code3']);
        $code4 = addslashes($row['code4']);

        if ($level === 1) {
            $where = " code1 = '{$code1}'";
        } elseif ($level === 2) {
            $where = " code1 = '{$code1}' AND code2 = '{$code2}'";
        } elseif ($level === 3) {
            $where = " code1 = '{$code1}' AND code2 = '{$code2}' AND code3 = '{$code3}'";
        } else {
            $where = " code1 = '{$code1}' AND code2 = '{$code2}' AND code3 = '{$code3}' AND code4 = '{$code4}'";
        }

        $DB->delete($shop_cate, $where);
        return array('ok' => true, 'message' => '삭제되었습니다.');
    }
}

if (!function_exists('pkshop_cate_redirect_params')) {
    function pkshop_cate_redirect_params($cateuid1, $cateuid2, $cateuid3, $cateuid4) {
        return 'cateuid1=' . urlencode($cateuid1)
            . '&cateuid2=' . urlencode($cateuid2)
            . '&cateuid3=' . urlencode($cateuid3)
            . '&cateuid4=' . urlencode($cateuid4);
    }
}

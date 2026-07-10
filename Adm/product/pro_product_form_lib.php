<?php
/**
 * 상품 등록/수정 — PG 카드형 폼 공통 헬퍼
 */

function pro_form_country_options() {
    return array(
        '82' => 'KOREA',
        '66' => 'THAILAND',
        '91' => 'INDIA',
        '1'  => 'USA',
        '81' => 'JAPAN',
        '86' => 'CHINA',
        '84' => 'VIETNAM',
        '62' => 'INDONESIA',
    );
}

function pro_form_country_select_html($country) {
    if ($country === '' || $country === null) {
        $country = '1';
    }
    $html = '<select name="country" id="country" class="pg-select pg-select--w-country">';
    foreach (pro_form_country_options() as $code => $label) {
        $sel = ((string) $country === (string) $code) ? ' selected' : '';
        $html .= '<option value="' . adm_ui_h($code) . '"' . $sel . '>' . adm_ui_h($label) . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function pro_form_cate_select_html($DB, $shop_cate, $level, $code1, $code2, $code3, $selected) {
    $labels = array(1 => '1차 카테고리', 2 => '2차 카테고리', 3 => '3차 카테고리', 4 => '4차 카테고리');
    $names  = array(1 => 'code1', 2 => 'code2', 3 => 'code3', 4 => 'code4');
    $label = $labels[$level];
    $name  = $names[$level];

    if ($level === 1) {
        $query = "SELECT cate1,code1 FROM $shop_cate WHERE code2='00' and code3='00' and code4='00' ORDER BY order_rank";
    } elseif ($level === 2) {
        $query = "SELECT cate2,code2 FROM $shop_cate WHERE code1='$code1' and code2!='00' and code3='00' and code4='00' ORDER BY order_rank";
    } elseif ($level === 3) {
        $query = "SELECT cate3,code3 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3!='00' and code4='00' ORDER BY order_rank";
    } else {
        $query = "SELECT cate4,code4 FROM $shop_cate WHERE code1='$code1' and code2='$code2' and code3='$code3' and code4!='00' ORDER BY order_rank";
    }

    $DB->get($query, $rs, $rn);
    $placeholders = array(1 => '1차 카테고리', 2 => '2차 카테고리', 3 => '3차 카테고리', 4 => '4차 카테고리');
    $html = '<select name="' . $name . '" class="pg-select pg-select--w-cate" onchange="go_select(\'' . $level . '\');">';
    $html .= '<option value="00">' . adm_ui_h($placeholders[$level]) . '</option>';
    for ($i = 0; $i < $rn; $i++) {
        $cate = htmlspecialchars(stripslashes($rs[$i][0]), ENT_QUOTES, 'UTF-8');
        $g_code = $rs[$i][1];
        $oselect = ((string) $selected === (string) $g_code) ? ' selected' : '';
        $html .= '<option value="' . adm_ui_h($g_code) . '"' . $oselect . '>' . $cate . '</option>';
    }
    $html .= '</select>';
    return $html;
}

function pro_form_compute_code($DB, $shop_goods, $sel_cate, $code1, $code2, $code3, $code4, $code_copy) {
    if ($code_copy == '') {
        if ($sel_cate == '1') {
            $code = $code1 . '000000';
        } elseif ($sel_cate == '2') {
            $code = $code1 . $code2 . '0000';
        } elseif ($sel_cate == '3') {
            $code = $code1 . $code2 . $code3 . '00';
        } elseif ($sel_cate == '4') {
            $code = $code1 . $code2 . $code3 . $code4;
        } else {
            $code = '';
        }

        if ($code != '') {
            $DB->get("SELECT max(code) FROM $shop_goods WHERE code LIKE '$code%'", $row, $ros);
            if ($row[0][0]) {
                $new_code = substr($row[0][0], -3);
                $new_code = $new_code + 1;
                $new_code = sprintf('%03d', $new_code);
            } else {
                $new_code = '001';
            }
            $code = $code . $new_code;
        }
    } else {
        $new_code = substr($code_copy, -3);
        $new_code = $new_code + 1;
        $new_code = sprintf('%03d', $new_code);
        $code_copy_tmp = substr($code_copy, 0, 6);
        $code = $code_copy_tmp . $new_code;
    }
    return $code;
}

function pro_form_theme_checkboxes_html($theme_g, $theme_n, $theme_r, $theme_f) {
    $g_checked = ($theme_g == 'g' || ($theme_g == '' && $theme_n == '' && $theme_r == '' && $theme_f == ''));
    $html = '<div class="pg-check-group">';
    $html .= '<label class="pg-check-item"><input type="checkbox" name="theme_g" value="g"' . ($g_checked ? ' checked' : '') . '> 기본상품</label>';
    $html .= '<label class="pg-check-item"><input type="checkbox" name="theme_n" value="n"' . ($theme_n == 'n' ? ' checked' : '') . '> 추천상품</label>';
    $html .= '<label class="pg-check-item"><input type="checkbox" name="theme_r" value="r"' . ($theme_r == 'r' ? ' checked' : '') . '> BEST제품</label>';
    $html .= '<label class="pg-check-item"><input type="checkbox" name="theme_f" value="f"' . ($theme_f == 'f' ? ' checked' : '') . '> HOT제품</label>';
    $html .= '</div>';
    return $html;
}

function pro_form_dis_radios_html($dis) {
    $html = '<div class="pg-radio-group">';
    $html .= '<label class="pg-radio-item"><input type="radio" name="dis" value="0"' . ($dis != '1' ? ' checked' : '') . '> 일반제품</label>';
    $html .= '<label class="pg-radio-item"><input type="radio" name="dis" value="1"' . ($dis == '1' ? ' checked' : '') . '> 재구매제품</label>';
    $html .= '</div>';
    return $html;
}

function pro_form_option_block_html($num, $option_t, $option_n, $option_p) {
    $n = (int) $num;
    $html = '<div class="pg-option-block">';
    $html .= '<div class="pg-option-block-title">추가옵션' . $n . '</div>';
    $html .= '<div class="pg-form-field pg-form-field--stacked"><label class="pg-form-label">옵션명' . $n . '</label>';
    $html .= '<div class="pg-form-control"><input type="text" name="option_t' . $n . '" value="' . adm_ui_h($option_t) . '" class="pg-input pg-input--w-md" maxlength="100"></div></div>';
    $html .= '<div class="pg-option-pair-grid">';
    $html .= '<div class="pg-form-field pg-form-field--stacked"><label class="pg-form-label">옵션사항</label><div class="pg-form-control"><textarea name="option_n' . $n . '" rows="7" class="pg-input">' . adm_ui_h($option_n) . '</textarea></div></div>';
    $html .= '<div class="pg-form-field pg-form-field--stacked"><label class="pg-form-label">증/차감가격</label><div class="pg-form-control"><textarea name="option_p' . $n . '" rows="7" class="pg-input">' . adm_ui_h($option_p) . '</textarea></div></div>';
    $html .= '</div></div>';
    return $html;
}

function pro_form_image_slot_html($name, $label, $dims, $img, $shop_img, $copy_val) {
    $display_id = $name . '_display';
    $file_id = $name . '_file';
    $display_val = ($img !== '') ? basename($img) : '';

    if ($img) {
        $preview = '<img src="' . adm_ui_h($shop_img . $img) . '" alt="" class="pg-product-image-preview">';
    } else {
        $preview = '<div class="pg-product-image-placeholder">' . adm_ui_h($dims) . '</div>';
    }

    $html = '<div class="pg-product-image-slot">';
    $html .= '<div class="pg-product-image-head"><strong>' . adm_ui_h($label) . '</strong><span>' . adm_ui_h($dims) . '</span></div>';
    $html .= '<div class="pg-product-image-body">' . $preview . '</div>';
    $html .= '<div class="pg-product-image-foot">';
    $html .= '<div class="pg-file-attach-picker pg-product-image-picker">';
    $html .= '<input type="text" id="' . adm_ui_h($display_id) . '" class="pg-input pg-file-attach-name" readonly placeholder="선택된 파일 없음" value="' . adm_ui_h($display_val) . '">';
    $html .= '<label for="' . adm_ui_h($file_id) . '" class="pg-btn pg-btn-outline pg-btn-file-browse">파일 선택</label>';
    $html .= '<input type="file" name="' . adm_ui_h($name) . '" id="' . adm_ui_h($file_id) . '" class="pg-file-attach-hidden" accept="image/*" onchange="onProductImageChange(this, \'' . adm_ui_h($display_id) . '\');">';
    $html .= '<input type="hidden" name="' . adm_ui_h($name) . '_copy" value="' . adm_ui_h($copy_val) . '">';
    $html .= '</div></div></div>';
    return $html;
}

function pro_form_infer_sel_cate($code2, $code3, $code4) {
    if ($code4 !== '' && $code4 !== '00') {
        return '4';
    }
    if ($code3 !== '' && $code3 !== '00') {
        return '3';
    }
    if ($code2 !== '' && $code2 !== '00') {
        return '2';
    }
    return '1';
}

function pro_form_load_product_by_no(&$DB, $shop_goods, $No) {
    $No = intval($No);
    if ($No <= 0) {
        return false;
    }

    $query = "SELECT No,code1,code2,code3,code4,code,title,info,company,color,size,home,shelf,theme,event,event_str,new,pricec,prices,priced,point,point_dis,currnum,warnnum,imgl,imgm,imgb1,imgb2,imgb3,imgb4,imgb5,detail,feature,signdate,soldout,rank,option_t1,option_n1,option_p1,option_k1,option_t2,option_n2,option_p2,option_k2,option_t3,option_n3,option_p3,option_k3,option_t4,option_n4,option_p4,option_k4,option_t5,option_n5,option_p5,option_k5,order1,order2,order3,order4,color_opt,size_opt,add_opt1,add_opt2,add_opt3,add_opt4,add_opt5,relation,price_dis,best,cut,recommend,theme_g,theme_n,theme_r,theme_f,theme_x,theme_y,theme_z,rank_g,rank_n,rank_r,rank_f,rank_x,rank_y,rank_z,opt_num,opt_num_str,theme_s,rank_s,p_id,esigndate,coin,pr_kind,c_pv,country,onlypoint,c_dis FROM $shop_goods WHERE No='$No' LIMIT 1";
    $DB->get($query, $rs, $rn);
    if ($rn < 1) {
        return false;
    }

	$row = $rs[0];
    $prices = isset($row['prices']) ? $row['prices'] : (isset($row[18]) ? $row[18] : '');
    $priced = isset($row['priced']) ? $row['priced'] : (isset($row[19]) ? $row[19] : '');
    if ($prices === '' && $priced !== '') {
        $prices = $priced;
    }

    return array(
        'No'         => isset($row['No']) ? $row['No'] : $row[0],
        'code1'      => isset($row['code1']) ? $row['code1'] : $row[1],
        'code2'      => isset($row['code2']) ? $row['code2'] : $row[2],
        'code3'      => isset($row['code3']) ? $row['code3'] : $row[3],
        'code4'      => isset($row['code4']) ? $row['code4'] : $row[4],
        'code'       => isset($row['code']) ? $row['code'] : $row[5],
        'title'      => stripslashes(isset($row['title']) ? $row['title'] : $row[6]),
        'company'    => stripslashes(isset($row['company']) ? $row['company'] : $row[8]),
        'color'      => stripslashes(isset($row['color']) ? $row['color'] : $row[9]),
        'size'       => stripslashes(isset($row['size']) ? $row['size'] : $row[10]),
        'home'       => stripslashes(isset($row['home']) ? $row['home'] : $row[11]),
        'pricec'     => isset($row['pricec']) ? $row['pricec'] : $row[17],
        'prices'     => $prices,
        'priced'     => $priced,
        'c_pv'       => isset($row['c_pv']) ? $row['c_pv'] : $row[95],
        'onlypoint'  => isset($row['onlypoint']) ? $row['onlypoint'] : $row[97],
        'currnum'    => isset($row['currnum']) ? $row['currnum'] : $row[22],
        'warnnum'    => isset($row['warnnum']) ? $row['warnnum'] : $row[23],
        'imgl'       => isset($row['imgl']) ? $row['imgl'] : $row[24],
        'imgm'       => isset($row['imgm']) ? $row['imgm'] : $row[25],
        'imgb1'      => isset($row['imgb1']) ? $row['imgb1'] : $row[26],
        'imgb2'      => isset($row['imgb2']) ? $row['imgb2'] : $row[27],
        'imgb3'      => isset($row['imgb3']) ? $row['imgb3'] : $row[28],
        'detail'     => stripslashes(isset($row['detail']) ? $row['detail'] : $row[31]),
        'soldout'    => isset($row['soldout']) ? $row['soldout'] : $row[34],
        'theme_g'    => isset($row['theme_g']) ? $row['theme_g'] : $row[72],
        'theme_n'    => isset($row['theme_n']) ? $row['theme_n'] : $row[73],
        'theme_r'    => isset($row['theme_r']) ? $row['theme_r'] : $row[74],
        'theme_f'    => isset($row['theme_f']) ? $row['theme_f'] : $row[75],
        'dis'        => isset($row['c_dis']) ? $row['c_dis'] : $row[98],
        'country'    => isset($row['country']) ? $row['country'] : $row[96],
        'p_id'       => isset($row['p_id']) ? $row['p_id'] : $row[90],
        'pr_kind'    => isset($row['pr_kind']) ? $row['pr_kind'] : $row[93],
        'option_t1'  => stripslashes(isset($row['option_t1']) ? $row['option_t1'] : $row[36]),
        'option_n1'  => stripslashes(isset($row['option_n1']) ? $row['option_n1'] : $row[37]),
        'option_p1'  => stripslashes(isset($row['option_p1']) ? $row['option_p1'] : $row[38]),
        'option_t2'  => stripslashes(isset($row['option_t2']) ? $row['option_t2'] : $row[40]),
        'option_n2'  => stripslashes(isset($row['option_n2']) ? $row['option_n2'] : $row[41]),
        'option_p2'  => stripslashes(isset($row['option_p2']) ? $row['option_p2'] : $row[42]),
        'option_t3'  => stripslashes(isset($row['option_t3']) ? $row['option_t3'] : $row[44]),
        'option_n3'  => stripslashes(isset($row['option_n3']) ? $row['option_n3'] : $row[45]),
        'option_p3'  => stripslashes(isset($row['option_p3']) ? $row['option_p3'] : $row[46]),
        'option_t4'  => stripslashes(isset($row['option_t4']) ? $row['option_t4'] : $row[48]),
        'option_n4'  => stripslashes(isset($row['option_n4']) ? $row['option_n4'] : $row[49]),
        'option_p4'  => stripslashes(isset($row['option_p4']) ? $row['option_p4'] : $row[50]),
        'option_t5'  => stripslashes(isset($row['option_t5']) ? $row['option_t5'] : $row[52]),
        'option_n5'  => stripslashes(isset($row['option_n5']) ? $row['option_n5'] : $row[53]),
        'option_p5'  => stripslashes(isset($row['option_p5']) ? $row['option_p5'] : $row[54]),
    );
}

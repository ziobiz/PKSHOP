<?php

if (!function_exists('pkshop_ai_split_editor_note_lines')) {
    function pkshop_ai_split_editor_note_lines($text) {
        $text = trim((string)$text);
        if ($text === '') {
            return array();
        }

        $lines = array();
        foreach (preg_split('/\r?\n+/', $text) as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            if (preg_match('/^(.+?\.\s+)([A-Z"\'\x{201C}].+)$/us', $chunk, $m)) {
                $lines[] = rtrim(trim($m[1]));
                $lines[] = trim($m[2]);
            } else {
                $lines[] = $chunk;
            }
        }

        return $lines;
    }
}

if (!function_exists('pkshop_fix_editors_notes_linebreaks_in_detail')) {
    function pkshop_fix_editors_notes_linebreaks_in_detail($detail) {
        $detail = (string)$detail;
        $pattern = '/(<p[^>]*>\s*<strong>Editor(?:&#039;|\'|\')s Notes<\/strong>\s*<\/p>)\s*(<p[^>]*>)([^<]+)(<\/p>)/iu';

        return preg_replace_callback($pattern, function ($m) {
            $text = html_entity_decode($m[3], ENT_QUOTES, 'UTF-8');
            $lines = pkshop_ai_split_editor_note_lines($text);
            if (count($lines) <= 1) {
                return $m[0];
            }
            $html = $m[1];
            foreach ($lines as $line) {
                $html .= $m[2] . htmlspecialchars($line, ENT_QUOTES, 'UTF-8') . $m[4];
            }
            return $html;
        }, $detail, 1);
    }
}

if (!function_exists('pkshop_ai_resolve_image_filename')) {
    function pkshop_ai_resolve_image_filename($val) {
        if (is_array($val)) {
            if (isset($val['filename']) && $val['filename'] !== '') {
                return trim((string)$val['filename']);
            }
            if (isset($val['file']) && $val['file'] !== '') {
                return trim((string)$val['file']);
            }
            if (isset($val[0]) && !is_array($val[0])) {
                return trim((string)$val[0]);
            }
            return '';
        }
        $val = trim((string)$val);
        if ($val === '' || strcasecmp($val, 'Array') === 0) {
            return '';
        }
        return $val;
    }
}

if (!function_exists('pkshop_ai_detail_image_html')) {
    function pkshop_ai_detail_image_html($filename) {
        $filename = pkshop_ai_resolve_image_filename($filename);
        if ($filename === '') {
            return '';
        }
        $upload_base = '//pentakleva.shop/upload/';
        return '<p class="view_detail_img" align="center" style="margin:0;padding:0;line-height:0;">'
            . '<img src="' . $upload_base . htmlspecialchars($filename, ENT_QUOTES, 'UTF-8') . '" alt=""'
            . ' style="width:100%;max-width:100%;max-height:3000px;vertical-align:bottom;"></p>';
    }
}

if (!function_exists('pkshop_ai_collect_product_detail_images')) {
    function pkshop_ai_collect_product_detail_images($image_files = array(), $product = array()) {
        $images = array();

        if (is_array($image_files)) {
            foreach ($image_files as $img) {
                $img = pkshop_ai_resolve_image_filename($img);
                if ($img !== '' && !in_array($img, $images, true)) {
                    $images[] = $img;
                }
            }
        }

        if (count($images) === 0 && is_array($product)) {
            foreach (array('imgl', 'imgm', 'imgb1', 'imgb2', 'imgb3', 'imgb4', 'imgb5') as $field) {
                $img = isset($product[$field]) ? pkshop_ai_resolve_image_filename($product[$field]) : '';
                if ($img !== '' && !in_array($img, $images, true)) {
                    $images[] = $img;
                }
            }
        }

        return $images;
    }
}

if (!function_exists('pkshop_ai_append_detail_images_html')) {
    function pkshop_ai_append_detail_images_html($image_files = array(), $product = array()) {
        $html = '';
        foreach (pkshop_ai_collect_product_detail_images($image_files, $product) as $img) {
            $html .= pkshop_ai_detail_image_html($img);
        }
        return $html;
    }
}

if (!function_exists('pkshop_sanitize_product_detail_html')) {
    function pkshop_sanitize_product_detail_html($detail, $product = array()) {
        $detail = (string)$detail;
        $detail = pkshop_fix_editors_notes_linebreaks_in_detail($detail);

        $detail = preg_replace(
            '/<p[^>]*class="view_detail_img"[^>]*>\s*<img[^>]+upload\/Array[^>]*>\s*<\/p>/is',
            '',
            $detail
        );
        $detail = preg_replace(
            '/<p[^>]*>\s*<img[^>]+upload\/Array[^>]*>\s*<\/p>/is',
            '',
            $detail
        );

        if (!preg_match('/class="view_detail_img"[^>]*>\s*<img[^>]+upload\/[^"\'\s>]+\.(jpg|jpeg|png|gif|webp)/i', $detail)) {
            $detail = rtrim($detail);
            $detail .= pkshop_ai_append_detail_images_html(array(), $product);
        }

        return $detail;
    }
}

if (!function_exists('pkshop_main_product_has_image')) {
    function pkshop_main_product_has_image($product) {
        return count(pkshop_ai_collect_product_detail_images(array(), $product)) > 0;
    }
}

if (!function_exists('pkshop_main_product_image_url')) {
    function pkshop_main_product_image_url($product, $upload_base = '//pentakleva.shop/upload/') {
        $images = pkshop_ai_collect_product_detail_images(array(), $product);
        if (count($images) === 0) {
            return '';
        }
        return $upload_base . $images[0];
    }
}

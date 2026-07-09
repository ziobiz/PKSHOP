<?
include "../common/dbconn.php";
include "../inc/top_menu.php";

if (!isset($_SESSION['admin_id']) || $_SESSION['admin_id'] == '') {
    echo '관리자 로그인이 필요합니다.';
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$DB->get("SELECT No, code, title, theme_g, theme_n, theme_r, theme_f FROM $shop_goods WHERE p_id='admin_ai' ORDER BY No", $rows, $rn);

echo '<h3>AI 상품 테마 플래그 정리</h3>';
echo '<p>대상: ' . intval($rn) . '건 (p_id=admin_ai)</p>';

if ($rn > 0) {
    echo '<ul>';
    for ($i = 0; $i < $rn; $i++) {
        $r = $rows[$i];
        $flags = array();
        if ($r['theme_r'] === 'r') $flags[] = 'BEST';
        if ($r['theme_n'] === 'n') $flags[] = '추천';
        if ($r['theme_f'] === 'f') $flags[] = 'HOT';
        echo '<li>' . htmlspecialchars($r['code']) . ' — ' . htmlspecialchars($r['title']);
        if (count($flags) > 0) {
            echo ' <strong>[' . implode(', ', $flags) . ']</strong>';
        }
        echo '</li>';
    }
    echo '</ul>';
}

$DB->update($shop_goods, "theme_g='g', theme_n='', theme_r='', theme_f='' WHERE p_id='admin_ai'");
echo '<p style="color:green;">완료: 모든 AI 상품을 기본상품(theme_g=g)으로 변경했습니다.</p>';

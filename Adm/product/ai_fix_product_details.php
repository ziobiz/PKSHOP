<?
include '../common/dbconn.php';
include '../common/user_function.php';
include '../../include/product_detail_helper.php';

if (session_id() === '') {
    @session_start();
}
if (!isset($_SESSION['idok']) || $_SESSION['idok'] !== 'yes') {
    header('Content-Type: text/html; charset=utf-8');
    echo '관리자 로그인이 필요합니다.';
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$code1 = isset($_GET['code1']) ? trim($_GET['code1']) : '';
$code = isset($_GET['code']) ? trim($_GET['code']) : '';
$scope = isset($_GET['scope']) ? trim($_GET['scope']) : '';

$where = '1=1';
if ($code !== '') {
    $where = "code='" . addslashes($code) . "'";
} elseif ($code1 !== '') {
    $where = "code1='" . addslashes($code1) . "'";
} elseif ($scope === 'all') {
    $where = '1=1';
} else {
    $where = "p_id='admin_ai' AND code1 IN ('17','18','19')";
}

$DB->get("SELECT No, code, title, detail, imgl, imgm, imgb1, imgb2, imgb3, imgb4, imgb5 FROM $shop_goods WHERE $where ORDER BY code", $rows, $rn);

echo '<h3>상품 상세(Product Details) 이미지 복구</h3>';
echo '<p>대상: ' . intval($rn) . '건';
if ($code !== '') {
    echo ' (code=' . htmlspecialchars($code) . ')';
} elseif ($code1 !== '') {
    echo ' (code1=' . htmlspecialchars($code1) . ')';
} elseif ($scope === 'all') {
    echo ' (전체 상품)';
} else {
    echo ' (AI 상품 code1=17,18,19)';
}
echo '</p>';

$fixed = 0;
for ($i = 0; $i < $rn; $i++) {
    $r = $rows[$i];
    $product = array(
        'imgm'  => $r['imgm'],
        'imgb1' => $r['imgb1'],
        'imgb2' => $r['imgb2'],
        'imgb3' => $r['imgb3'],
        'imgb4' => $r['imgb4'],
        'imgb5' => $r['imgb5'],
    );

    $old_detail = stripslashes($r['detail']);
    $new_detail = pkshop_sanitize_product_detail_html($old_detail, $product);

    if ($new_detail === $old_detail) {
        continue;
    }

    $no = intval($r['No']);
    $detail_sql = addslashes($new_detail);
    $DB->update($shop_goods, "detail='$detail_sql' WHERE No='$no'");
    $fixed++;
    echo '<p style="color:green;">수정: ' . htmlspecialchars($r['code']) . ' — ' . htmlspecialchars($r['title']) . '</p>';
}

echo '<p><strong>완료: ' . $fixed . '건 상세 이미지를 복구했습니다.</strong></p>';
echo '<p>실행 링크: ';
echo '<a href="ai_fix_product_details.php?code=17000000022">code 17000000022</a> | ';
echo '<a href="ai_fix_product_details.php?code1=17">SUMMER TOPS (17)</a> | ';
echo '<a href="ai_fix_product_details.php?code1=18">SUMMER PANTS (18)</a> | ';
echo '<a href="ai_fix_product_details.php?code1=19">SHORTS (19)</a> | ';
echo '<a href="ai_fix_product_details.php?scope=all">전체 상품</a>';
echo '</p>';

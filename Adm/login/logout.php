<?
include "../common/dbconn.php";

unset($_SESSION['idok']);
unset($_SESSION['admin_id']);

if (ini_get('session.use_cookies')) {
	$params = session_get_cookie_params();
	setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

@session_destroy();

SetCookie("admin_id", "", time() - 3600, "/");
SetCookie("idok", "", time() - 3600, "/");

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title>로그아웃</title>
<script>
try {
	localStorage.removeItem('pkshop-nav-tabs');
} catch (e) {}
location.replace('../login/login.php');
</script>
</head>
<body>
<p>로그아웃 중… <a href="../login/login.php">로그인 화면으로 이동</a></p>
</body>
</html>

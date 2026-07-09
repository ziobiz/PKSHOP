<?php
if (!isset($_SESSION['member_id']) || $_SESSION['member_id'] === '') {
?>
<script type="text/javascript">
<!--
	alert("Only members can complete a purchase. Please log in to continue.");
	location.href = "../member/login.php?from=buy";
//-->
</script>
<?php
	exit;
}
?>

<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function delclsrm()
	{
		// 验证和读取会话中的用户名
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$clsrmid=$_GET['classroomid'];
		$mysql=connect_db($username);
		$result=sql_query($mysql, "delete from classrooms where ClassroomID='$clsrmid'");
		if(!$result) 
		{
			$mysql->close();
			return false;
		}

		clean_useless_clsrmtype($mysql);
		$mysql->close();
		return true;
	}
	
	echo delclsrm();
?>

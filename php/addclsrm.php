<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function add_clsrm()
	{
		// 验证和读取会话中的用户名
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$classroom=$_GET['classroom'];
		$type=$_GET['type'];

		if(empty($classroom) || empty($type))
		{
			wrong_info('Required Infomation is Empty.');
			return false;
		}

		$mysql=connect_db($username);
		update_absence($mysql, "classroom_types", $type);

		$result=sql_query($mysql, "select ClassroomTypeID from classroom_types where Name='$type'");
		$ctid=$result->fetch_row()[0];
		$result->free();

		if(sql_query($mysql, "insert into classrooms(Name, ClassroomTypeID) 
			values('$classroom', '$ctid')"))
		{
			$mysql->close();
			return true;
		}
		$mysql->close();
		return false;
	}
	
	echo add_clsrm();
?>

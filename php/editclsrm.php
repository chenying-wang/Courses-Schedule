<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function edit_clsrm()
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$id=$_GET['classroomid'];
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

		if(sql_query($mysql, "update classrooms set Name='$classroom', ClassroomTypeID='$ctid' 
			where ClassroomID='$id'"))
		{
			clean_useless_clsrmtype($mysql);
			$mysql->close();
			return true;
		}

		clean_useless_clsrmtype($mysql);
		$mysql->close();
		return false;
	}

	echo edit_clsrm();
?>

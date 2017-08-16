<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function add()
	{
		// 验证和读取会话中的用户名
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		// 读取前端GET请求的信息
		$course=$_GET['course'];
		$instructor=$_GET['instructor'];
		$class=$_GET['class'];
		$tpw=$_GET['timesperweek'];
		$clsrm_type=$_GET['classroomtype'];

		// 验证信息不为空
		if(empty($course) || empty($instructor) || empty($class) || empty($tpw) || empty($clsrm_type))
		{
			return false;
		}

		// 补充缺少的教师、教室及教室类型
		$mysql=connect_db($username);
		update_absence($mysql, "instructors", $instructor);
		update_absence($mysql, "classes", $class);
		update_absence($mysql, "classroom_types", $clsrm_type);

		// 分别查找教师、教室及教室类型的ID
		$result=sql_query($mysql, "select InstructorID from instructors where Name='$instructor'");
		$insid=$result->fetch_row()[0];
		$result->free();

		$result=sql_query($mysql, "select ClassID from classes where Name='$class'");
		$clsid=$result->fetch_row()[0];
		$result->free();

		$result=sql_query($mysql, "select ClassroomTypeID from classroom_types where Name='$clsrm_type'");
		$clsrmtypeid=$result->fetch_row()[0];
		$result->free();

		// 插入信息到courses表
		if(sql_query($mysql, "insert into courses(Name, InstructorID, ClassID, Timesperweek, ClassroomTypeID) 
			values('$course', '$insid', '$clsid', '$tpw', '$clsrmtypeid')"))
		{
			$mysql->close();
			return true;
		}
		$mysql->close();
		return false;
	}
	
	echo add();
?>

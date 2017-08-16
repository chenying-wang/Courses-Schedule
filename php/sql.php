<?php
	define(CLASS_TABLE, 0);
	define(INSTRUCTOR_TABLE, 1);

	function connect_db($db_name)
	{
		$mysql=new mysqli("localhost", "chen", "chen", $db_name);
		if(mysqli_connect_errno())
		{
			wrong_info('Cannot connect to database.');
			exit;
		}
		$db=$mysql->select_db($db_name);
		if(!$db)
		{
			wrong_info('Cannot select database.');
			exit;
		}
		return $mysql;
	}
	
	function sql_query($mysql, $query)
	{
		if(!$result=$mysql->query($query))
		{
			wrong_info("Cannot run query $query");
		}
		return $result;
	}
	
	function get_name_by_id($mysql, $table, $id)
	{
		if(empty($id)) return "null";
		switch($table)
		{
			case "courses": $query="select * from $table where CourseID=$id"; break;
			case "instructors": $query="select * from $table where InstructorID=$id"; break;
			case "classes": $query="select * from $table where ClassID=$id"; break;
			case "classrooms": $query="select * from $table where ClassroomID=$id"; break;
			case "classroom_types": $query="select * from $table where ClassroomTypeID=$id"; break;
			default: echo "There is not a table with a name of \"$table\".\n"; exit;
		}
		$result=sql_query($mysql, $query);
		if(!$result->num_rows)
		{
			return -1;
		}
		else
		{
			$row=$result->fetch_object();
			return $row->Name;
		}
	}
	
	function update_absence($mysql, $table, $name)
	{
		$result=sql_query($mysql, "select count(*) from $table where Name='$name'");

		$row=$result->fetch_row();
		$result->free();

		if(!$row[0])
		{
			return sql_query($mysql, "insert into $table(Name) values('$name')");
		}
		return true;
	}
	
	function get_course($mysql, $wno, $cno, $id, $type, $for="name")
	{
		$query="select * from courses_schedule where WeekNo=$wno and ClassNo=$cno";
		$result=sql_query($mysql, $query);
		while ($row=$result->fetch_object())
		{
			$query="select * from courses where CourseID='$row->CourseID'";
			$result2=sql_query($mysql, $query);
			$row2=$result2->fetch_object();
			if($type==INSTRUCTOR_TABLE&$id==$row2->InstructorID) 
				return ($for!='id')?$row2->Name:$row2->CourseID;
			else if($type==CLASS_TABLE&$id==$row2->ClassID) 
				return ($for!='id')?$row2->Name:$row2->CourseID;
		}
		return ($for!='id')?"----":-1;
	}

	function get_classroom($mysql, $wno, $cno, $id, $type, $for="name")
	{
		$crs_id=get_course($mysql, $wno, $cno, $id, $type, "id");
		if($crs_id!=-1)
		{
			$clsrm="@";
			$query="select * from courses_schedule where CourseID='$crs_id' and ";
			$query.="WeekNo='$wno' and ClassNo='$cno'";
			$result=sql_query($mysql, $query);
			$clsrmid=$result->fetch_object()->ClassroomID;
			$clsrm.=get_name_by_id($mysql, "classrooms", $clsrmid);
			return $for=="id"?$clsrmid:$clsrm;
		}
		return null;
	}

	function clean_useless_clsrmtype($mysql)
	{
		$query="select * from classroom_types";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			$query="select count(*) from classrooms where ClassroomTypeID='$row->ClassroomTypeID'";
			$result_i1=sql_query($mysql, $query);
			$query="select count(*) from courses where ClassroomTypeID='$row->ClassroomTypeID'";
			$result_i2=sql_query($mysql, $query);
			if(!($result_i1->fetch_row()[0]|$result_i2->fetch_row()[0]))
				sql_query($mysql, "delete from classroom_types where ClassroomTypeID='$row->ClassroomTypeID'");
		}
		return;
	}
?>

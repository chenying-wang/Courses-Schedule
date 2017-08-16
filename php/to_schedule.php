<?php
	require_once("sql.php");
	require_once("output.php");
?>

<?php
	function array_union($a1, $a2)
	{
		$union=array_merge($a1, array_diff($a2, $a1));
		return $union;
	}

	function push(&$a, $value)
	{
		if(!isset($a)) $a=array();
		array_push($a, $value);
		return count($a);
	}

	function build_array(&$crs, &$ins, &$cls, &$clsrm)
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];

		$mysql=connect_db($username);
		$query="select * from courses";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			for($j=0; $j<$row->Timesperweek; $j++)
			{
				push($crs[$row->InstructorID][$row->ClassID], array($row->CourseID, $row->ClassroomTypeID));
			}
			$ins=array_union((array)$ins, array($row->InstructorID));
			$cls=array_union((array)$cls, array($row->ClassID));
		}
		$query="select * from classrooms";
		$result=sql_query($mysql, $query);
		for($i=0; $i<$result->num_rows; $i++)
		{
			$row=$result->fetch_object();
			push($clsrm[$row->ClassroomTypeID], $row->ClassroomID);
		}
		
		$result->free();
		$mysql->close();
		return;
	}

	function schedule($week, $day, $offset, $crs, $ins, $cls, $clsrm)
	{
		session_start();
		if(!isset($_SESSION['valid_user'])) exit;
		$username=$_SESSION['valid_user'];
		
		$mysql=connect_db($username);
		$query="update info set Day=$day, Offset=$offset where ID=0";
		sql_query($mysql, $query);
		$query="delete from courses_schedule";
		sql_query($mysql, $query);
		$ins_bak=$ins;
		$cls_bak=$cls;
		$clsrm_bak=$clsrm;
		$ins_num=count($ins);
		$cls_num=count($cls);
		$ins_sch_num=0;

		for($i=0; $i<$week*$day & $ins_sch_num<$ins_num; $i++)
		{
			for($j=0; $j<$ins_num; $j++)
			{
				if(!isset($crs[$ins[$j]])) continue;
				$max=0;
				for($k=0; $k<$cls_num; $k++)
				{
					if(isset($crs[$ins[$j]][$cls[$k]])&count($crs[$ins[$j]][$cls[$k]])>$max)
					{
						$max=count($crs[$ins[$j]][$cls[$k]]);
						$max_cls=$k;
					}
				}

				if($max==0)
				{
					$empty=1;
					foreach($crs[$ins[$j]] as $crs_ins)
					{
						foreach($crs_ins as $crs_ins_cls)
						{
							if(count($crs_ins_cls))
							{
								$empty=0;
								break;
							}
							if(!$empty) break;
						}
					}
					if($empty)
					{
						$ins_sch_num++;
						$ins[$j]=-1;
					}
					continue;
				}

				while(count($crs[$ins[$j]][$cls[$max_cls]]))
				{
					$temp=array_pop($crs[$ins[$j]][$cls[$max_cls]]);
					if(count($clsrm[$temp[1]])) break;
					push($sch_temp, $temp);
					$temp=null;
				}

				while(count($sch_temp))
				{
					push($crs[$ins[$j]][$cls[$max_cls]], array_pop($sch_temp));
				}
				if(!isset($temp)) continue;
				
				$wno=$i%$week;
				$cno=($i/$week+$wno)%$day;
				$schedule[$i][$ins[$j]][$cls[$max_cls]]=$temp;
				$query="insert into courses_schedule (CourseID, WeekNo, ClassNo, ClassroomID) ";
				$query.="values (".$schedule[$i][$ins[$j]][$cls[$max_cls]][0].", ";
				$query.=$wno.", ".$cno.", ".array_pop($clsrm[$temp[1]]).")";
				sql_query($mysql, $query);
				$cls[$max_cls]=-1;
			}
			$cls=$cls_bak;
			$clsrm=$clsrm_bak;
		}
		$mysql->close();
		if($ins_sch_num<$ins_num) return false;
		return true;
	}

	$week=$_GET['week'];
	$day=$_GET['day'];
	$offset=$_GET['offset'];
	build_array($crs, $ins, $cls, $clsrm);
	echo schedule($week, $day, $offset, $crs, $ins, $cls, $clsrm);
?>

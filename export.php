<?php 
	require_once("php/sql.php");
	require_once("php/output.php");

	include "php/PHPExcel.php";
	include "php/PHPExcel/Writer/Excel2007.php";

	session_start();
	if(!isset($_SESSION['valid_user'])) exit;
	$username=$_SESSION['valid_user'];
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment; filename="courses_scheudle_'.$username.'.xlsx"');

	$WEEK = array("周一", "周二", "周三", "周四", "周五", "周六", "周日");

	$objPHPExcel=new PHPExcel();
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10); 

	$raw_cls=$_GET['cls'];
	$raw_ins=$_GET['ins'];
	$mysql=connect_db($username);
	$query="select * from info where ID=0";
	$result=sql_query($mysql, $query);
	$row=$result->fetch_object();
	$day=$row->Day;
	$offset=$row->Offset;	

	function doSheet($objPHPExcel, $type, $id)
	{
		global $WEEK, $mysql, $day, $offset;
		$objPHPExcel->getActiveSheet()->mergeCells("A1:H1"); 
		$objPHPExcel->getActiveSheet()->getStyle('A1:H'.($day+2))->
			getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$objPHPExcel->getActiveSheet()->getStyle('A1:H'.($day+2))->
			getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$name=get_name_by_id($mysql, $type?"instructors":"classes", $id);
		$objPHPExcel->getActiveSheet()->setTitle(($type?"教师":"班级 ").$name);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', ($type?"教师":"班级 ").$name);
		$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

		for ($i=-1; $i<$day; $i++)
		{
			$objPHPExcel->getActiveSheet()->getRowDimension($i+3)->setRowHeight(18);
			if($i==-1)
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A'.($i+3), '');
				if(!$offset)
				{
					$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24); 
					$objPHPExcel->getActiveSheet()->setCellValue('B'.($i+3), $WEEK[0]);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.($i+3), $WEEK[1]);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.($i+3), $WEEK[2]);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+3), $WEEK[3]);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+3), $WEEK[4]);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+3), $WEEK[5]);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+3), $WEEK[6]);
				}
				else
				{
					$objPHPExcel->getActiveSheet()->setCellValue('B'.($i+3), $WEEK[6]);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.($i+3), $WEEK[0]);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.($i+3), $WEEK[1]);
					$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+3), $WEEK[2]);
					$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+3), $WEEK[3]);
					$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+3), $WEEK[4]);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+3), $WEEK[5]);
				}
			}
			else
			{
				$objPHPExcel->getActiveSheet()->setCellValue('A'.($i+3), $i+1);
				$objPHPExcel->getActiveSheet()->setCellValue('B'.($i+3),
					get_course($mysql, 0, $i, $id, $type).get_classroom($mysql, 0, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('C'.($i+3),
					get_course($mysql, 1, $i, $id, $type).get_classroom($mysql, 1, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('D'.($i+3),
					get_course($mysql, 2, $i, $id, $type).get_classroom($mysql, 2, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('E'.($i+3),
					get_course($mysql, 3, $i, $id, $type).get_classroom($mysql, 3, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('F'.($i+3),
					get_course($mysql, 4, $i, $id, $type).get_classroom($mysql, 4, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('G'.($i+3),
					get_course($mysql, 5, $i, $id, $type).get_classroom($mysql, 5, $i, $id, $type));
				$objPHPExcel->getActiveSheet()->setCellValue('H'.($i+3),
					get_course($mysql, 6, $i, $id, $type).get_classroom($mysql, 6, $i, $id, $type));
			}
		}
		return $objPHPExcel;
	}
	
	$sheet_no=0;
	$cls=preg_split("/,/", $raw_cls);
	$i=0;
	while(isset($cls[$i])&$cls[$i]!=null)
	{
		$objPHPExcel->createSheet($sheet_no);
		$objPHPExcel->setActiveSheetIndex($sheet_no);
		doSheet($objPHPExcel, 0, $cls[$i]);
		$sheet_no++;
		$i++;
	}
	$ins=preg_split("/,/", $raw_ins);
	$i=0;
	while(isset($ins[$i])&$ins[$i]!=null)
	{
		$objPHPExcel->createSheet($sheet_no);
		$objPHPExcel->setActiveSheetIndex($sheet_no);
		doSheet($objPHPExcel, 1, $ins[$i]);
		$sheet_no++;
		$i++;
	}
	$mysql->close();

	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	$objWriter->save("php://output");
?>

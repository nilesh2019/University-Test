<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once APPPATH."/third_party/PHPExcel.php"; 
 
class Excel extends PHPExcel { 
    public function __construct() {  
        parent::__construct(); 
        $CI =& get_instance();
    } 


    function demo_excel($demo_excel)
    {
    	$CI =& get_instance(); 
    	/*date_default_timezone_set('Asia/kolkata');*/
    	$CI->load->library('excel');
    	PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		// Set document properties
		$CI->excel->getProperties()->setCreator("demo")
							 	   ->setLastModifiedBy("demo")
							 	   ->setTitle("demo Report")
							 	   ->setSubject("demoe Report")
							 	   ->setDescription("System Generated File.")
							 	   ->setKeywords("office 2007")
							 	   ->setCategory("Confidential");

		$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );


		//activate worksheet number 1
		$CI->excel->setActiveSheetIndex(0);
		$CI->excel->getActiveSheet()->getStyle("A1:C3")->getAlignment()->setWrapText(true);
		$CI->excel->getActiveSheet()->setTitle('demo Report');
		$CI->excel->getActiveSheet()->mergeCells('A1:C1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A1:C1')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('A2', 'demo Report');
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Bookman Old Style');
        $CI->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$CI->excel->getActiveSheet()->mergeCells('A2:C2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A2:C3')->applyFromArray($allborders);	
		$CI->excel->getActiveSheet()->getStyle('A2:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
 		$CI->excel->getActiveSheet()->setCellValue('A3', 'Sr. No.');
		$CI->excel->getActiveSheet()->setCellValue('B3', 'col1');		
		$CI->excel->getActiveSheet()->setCellValue('C3', 'co2');

		$CI->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(20);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(40);	
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(40);
		$CI->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->setName('Bookman Old Style');
		$CI->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->setSize(10);
		$CI->excel->getActiveSheet()->getStyle('A2:C3')->getFont()->setBold(true);															
		$CI->excel->getActiveSheet()->getStyle('A3:C3')->getFont()->getColor()->setRGB('FFFFFFFF');
		$CI->excel->getActiveSheet()->getStyle('A3:C3') ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('FF428bca');
		$CI->excel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A3:C3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		if(isset($demo_excel) && !empty($demo_excel))
		{
			$i=3;			
			$sr=0;
			foreach ($demo_excel as $key ) 
			{
				$sr++;
				$i++;
				$CI->excel->getActiveSheet()->setCellValue('A'.$i, $sr);
				$CI->excel->getActiveSheet()->setCellValue('B'.$i, $key->col);
				$CI->excel->getActiveSheet()->setCellValue('C'.$i, $key->col1);
											
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':C'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) ->setWrapText(true);
			}
		}

		//$filename='due_date.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="demo_excel.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save(str_replace(__FILE__,'./upload/report',__FILE__));
		$objWriter->save('php://output'); 
    } 

    function exportregionwisedata($active_institute)
    {
    	$CI =& get_instance(); 
    	/*date_default_timezone_set('Asia/kolkata');*/
    	$CI->load->library('excel');
    	PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		// Set document properties
		$CI->excel->getProperties()->setCreator("Emmermisive Tech")
							 	   ->setLastModifiedBy("Emmermisive Tech")
							 	   ->setTitle("Region Wise Data")
							 	   ->setSubject("Region Wise Data")
							 	   ->setDescription("System Generated File.")
							 	   ->setKeywords("office 2007")
							 	   ->setCategory("Confidential");

		$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );


		//activate worksheet number 1
		$CI->excel->setActiveSheetIndex(0);
		$CI->excel->getActiveSheet()->getStyle("A1:G3")->getAlignment()->setWrapText(true);
		$CI->excel->getActiveSheet()->setTitle('Region Wise Data');
		$CI->excel->getActiveSheet()->mergeCells('A1:G1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A1:G1')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('A2', 'Region Wise Data');
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Bookman Old Style');
        $CI->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$CI->excel->getActiveSheet()->mergeCells('A2:G2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A2:G3')->applyFromArray($allborders);	
		$CI->excel->getActiveSheet()->getStyle('A2:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
 		$CI->excel->getActiveSheet()->setCellValue('A3', 'Sr. No.');
		$CI->excel->getActiveSheet()->setCellValue('B3', 'Region Name');		
		$CI->excel->getActiveSheet()->setCellValue('C3', 'Total Active Institute');
		$CI->excel->getActiveSheet()->setCellValue('D3', 'Total Enrolled Students');	
		$CI->excel->getActiveSheet()->setCellValue('E3', 'Total Students Logged In');
		$CI->excel->getActiveSheet()->setCellValue('F3', 'Total Students Projects');
		$CI->excel->getActiveSheet()->setCellValue('G3', 'Total Pending Projects');

		$CI->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(20);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(40);	
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(40);							
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(40);	
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(40);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(40);
		$CI->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setName('Bookman Old Style');
		$CI->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->setSize(10);
		$CI->excel->getActiveSheet()->getStyle('A2:G3')->getFont()->setBold(true);															
		$CI->excel->getActiveSheet()->getStyle('A3:G3')->getFont()->getColor()->setRGB('FFFFFFFF');
		$CI->excel->getActiveSheet()->getStyle('A3:G3') ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('FF428bca');
		$CI->excel->getActiveSheet()->getStyle('A3:G3')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A3:G3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		if(isset($active_institute) && !empty($active_institute))
		{
			$i=3;			
			$sr=0;
			$total_activ=0;
			$total_enroll=0;
			$total_loged=0;
			$total_project=0;
			$totalpending_project=0;
			foreach ($active_institute as $key) 
			{
				$sr++;
				$i++;
				$total_activ=$total_activ+$key->active_cnt;
				$total_enroll=$total_enroll+$key->enroll_cnt;
				$total_loged=$total_loged+$key->loged_cnt;
				$total_project=$total_project+$key->project_cnt;
				$totalpending_project=$totalpending_project+$key->pendingproject_cnt;

				$CI->excel->getActiveSheet()->setCellValue('A'.$i, $sr);
				$CI->excel->getActiveSheet()->setCellValue('B'.$i, $key->region_name);
				$CI->excel->getActiveSheet()->setCellValue('C'.$i, $key->active_cnt);
				$CI->excel->getActiveSheet()->setCellValue('D'.$i, $key->enroll_cnt);		
				$CI->excel->getActiveSheet()->setCellValue('E'.$i, $key->loged_cnt);
				$CI->excel->getActiveSheet()->setCellValue('F'.$i, $key->project_cnt);
				$CI->excel->getActiveSheet()->setCellValue('G'.$i, $key->pendingproject_cnt);
				
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($allborders);				
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('Bookman Old Style');
		        $CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setSize(10);
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($allborders);							
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) ->setWrapText(true);
				
			}
				$i++;
				$CI->excel->getActiveSheet()->setCellValue('A'.$i, '');
				$CI->excel->getActiveSheet()->setCellValue('B'.$i, "Total");
				$CI->excel->getActiveSheet()->setCellValue('C'.$i, $total_activ);
				$CI->excel->getActiveSheet()->setCellValue('D'.$i, $total_enroll);		
				$CI->excel->getActiveSheet()->setCellValue('E'.$i, $total_loged);
				$CI->excel->getActiveSheet()->setCellValue('F'.$i, $total_project);
				$CI->excel->getActiveSheet()->setCellValue('G'.$i, $totalpending_project);
				
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($allborders);				
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setName('Bookman Old Style');
		        $CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setBold(true);
		        $CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getFont()->setSize(11);
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->applyFromArray($allborders);							
				$CI->excel->getActiveSheet()->getStyle('A'.$i.':G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) ->setWrapText(true);

		}

		//$filename='due_date.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="Region Wise Data.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save(str_replace(__FILE__,'./upload/report',__FILE__));
		$objWriter->save('php://output'); 
    }

    function export_topstudent_regionwise($top_student)
    {	
    	$CI =& get_instance(); 
    	/*date_default_timezone_set('Asia/kolkata');*/
    	$CI->load->library('excel');
    	PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
		// Set document properties
		$CI->excel->getProperties()->setCreator("Emmermisive Tech")
							 	   ->setLastModifiedBy("Emmermisive Tech")
							 	   ->setTitle("Top 5 Student")
							 	   ->setSubject("Top 5 Student")
							 	   ->setDescription("System Generated File.")
							 	   ->setKeywords("office 2007")
							 	   ->setCategory("Confidential");

		$allborders = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN, ), ), );


		//activate worksheet number 1
		$CI->excel->setActiveSheetIndex(0);
		$CI->excel->getActiveSheet()->getStyle("A1:E3")->getAlignment()->setWrapText(true);
		$CI->excel->getActiveSheet()->setTitle('Top 5 Student Region Wise');
		$CI->excel->getActiveSheet()->mergeCells('A1:E1') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$CI->excel->getActiveSheet()->setCellValue('A2', 'Top 5 Student Region Wise');
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setName('Bookman Old Style');
        $CI->excel->getActiveSheet()->getRowDimension('2')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(20);
		$CI->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$CI->excel->getActiveSheet()->mergeCells('A2:E2') ->getStyle() ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('EEEEEEEE');
		$CI->excel->getActiveSheet()->getStyle('A2:E3')->applyFromArray($allborders);	
		$CI->excel->getActiveSheet()->getStyle('A2:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
 		$CI->excel->getActiveSheet()->setCellValue('A3', 'Sr. No.');
		$CI->excel->getActiveSheet()->setCellValue('B3', 'Institute Name');		
		$CI->excel->getActiveSheet()->setCellValue('C3', 'Student Name');
		$CI->excel->getActiveSheet()->setCellValue('D3', 'Email');	
		$CI->excel->getActiveSheet()->setCellValue('E3', 'Project Count');

		$CI->excel->getActiveSheet()->getRowDimension('3')->setRowHeight(40);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(1)->setWidth(20);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(2)->setWidth(40);	
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(3)->setWidth(40);							
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(4)->setWidth(40);	
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(5)->setWidth(40);
		$CI->excel->getActiveSheet()->getColumnDimensionByColumn(6)->setWidth(40);
		$CI->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setName('Bookman Old Style');
		$CI->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->setSize(10);
		$CI->excel->getActiveSheet()->getStyle('A2:E3')->getFont()->setBold(true);															
		$CI->excel->getActiveSheet()->getStyle('A3:E3')->getFont()->getColor()->setRGB('FFFFFFFF');
		$CI->excel->getActiveSheet()->getStyle('A3:E3') ->getFill() ->setFillType(PHPExcel_Style_Fill::FILL_SOLID) ->getStartColor()->setARGB('FF428bca');
		$CI->excel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($allborders);
		$CI->excel->getActiveSheet()->getStyle('A3:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

		if(isset($top_student) && !empty($top_student))
		{
			$i=3;			
			foreach ($top_student as $key1) 
			{
				$stddata=$key1['std_data'];
                $region=$key1['region'];
				$sr=0;		
						
               	if(isset($stddata) && !empty($stddata))
                {    
	                $i++;
					$CI->excel->getActiveSheet()->setCellValue('A'.$i, '');
					$CI->excel->getActiveSheet()->setCellValue('B'.$i, $region->region_name);
					$CI->excel->getActiveSheet()->setCellValue('C'.$i, '');
					$CI->excel->getActiveSheet()->setCellValue('D'.$i, '');		
					$CI->excel->getActiveSheet()->setCellValue('E'.$i, '');
									
					$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($allborders);				
					$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setName('Bookman Old Style');
			        $CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setSize(14);
			        $CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setBold(true);					
					$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($allborders);							
					$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) ->setWrapText(true);
			
	                foreach ($stddata as $key) 
	                {
		                $sr++;
						$i++;
						$CI->excel->getActiveSheet()->setCellValue('A'.$i, $sr);
						$CI->excel->getActiveSheet()->setCellValue('B'.$i, $key->instituteName);
						$CI->excel->getActiveSheet()->setCellValue('C'.$i, $key->name);
						$CI->excel->getActiveSheet()->setCellValue('D'.$i, $key->email);		
						$CI->excel->getActiveSheet()->setCellValue('E'.$i, $key->project_cnt);
										
						$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($allborders);				
						$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setName('Bookman Old Style');
				        $CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getFont()->setSize(10);
						$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($allborders);							
						$CI->excel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER) ->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER) ->setWrapText(true);
					}
				}
			}				
		}

		//$filename='due_date.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="Top 5 Student Region Wise.xls"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		             
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($CI->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		//$objWriter->save(str_replace(__FILE__,'./upload/report',__FILE__));
		$objWriter->save('php://output'); 
    
    }
}
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_Creation
{

	function _construct() 
	{
	    $CI =& get_instance();     
		$CI->load->database();     
		$CI->load->library("session");
	}

	function create_pdf($html,$pdfname)
	{
		/*
		 * Required files 
		 * 1. A folder name dompdf which contain classes should be placed in thirdparty folder.
		 * 2. A library with name dompdf_gen.php in library folder.
		 * 
		 * 
		 * 
		 * Input Data 
		 * 1.  	html file with data.
		 * 2.  	filename
		 * 
		 * Way to call this function 
		 * 
		 * 	$filename = 'file name';
			$html = $this->load->view('view path','$data_to_view',TRUE);
		 * 
		 * */
		 
		$pdfname = $pdfname.'.pdf';
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A4', 'portrait');
		$dompdf->render();
		$dompdf->stream($pdfname);
	}
	

	function create_pdf1($html,$pdfname)
	{
		$stream = true;
		/*
		 * Required files 
		 * 1. A folder name dompdf which contain classes should be placed in thirdparty folder.
		 * 2. A library with name dompdf_gen.php in library folder.
		 * 
		 * 
		 * 
		 * Input Data 
		 * 1.  	html file with data.
		 * 2.  	filename
		 * 
		 * Way to call this function 
		 * 
		 * 	$filename = 'file name';
			$html = $this->load->view('view path','$data_to_view',TRUE);
		 * 
		 * */
		 
		$pdfname = $pdfname.'.pdf';
		require_once APPPATH.'third_party/dompdf/dompdf_config.inc.php';
		$dompdf = new DOMPDF();
		$dompdf->load_html($html);
		$dompdf->set_paper('A5', 'portrait');
		$dompdf->render();
		  	if ($stream) {
			    $dompdf->stream($pdfname);
			  } else {
			    return $dompdf->output();
			  }
	}

	function create_excel($title,$description,$inputdata,$filename)
	{
		/*
		 * Required files 
		 * 1. A folder name PHPExcel which contain classes should be placed in thirdparty folder.
		 * 2. A file name PHPExcel.php will be in thirdparty folder.
		 * 3. A library with name excel.php in library folder.
		 * 
		 * 
		 * 
		 * Input Data should be in format like 
		 * 1.  	$inputdata = array(array('No','Name'),array('1','Aakash'),array('2','Tehra'));
		 * 2.  	$inputdata[] =  array('No','Name');
				$inputdata[] =  array('1','Aakash');
				$inputdata[] =  array('2','Tehra');
		 * 
		 * Way to call this function 
		 * 
		 * 	$title = 'Excel Title';
		 *  $description = 'Excel Description';
			$filename = 'file name';
			$this->report_creation->create_excel($title,$description,$inputdata,$filename);
		 * 
		 * */
		
		$CI =& get_instance();     
		$CI->load->library('excel');
		$sheet = new PHPExcel();
		$sheet->getProperties()->setTitle($title)->setDescription($description);
		$sheet->setActiveSheetIndex(0);
		$col = 0;
		foreach ($inputdata[0] as $field=>$value)
		{
			$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 0, $field);
			$col++;
		}
		$row = 1;
		foreach ($inputdata as $data)
		{
			$col = 0;
			foreach ($data as $field_val)
			{
				$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $field_val);
				$col++;
			}
			$row++;
		}
		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'_'.date('dMy').'.xls"');
		header('Cache-Control: max-age=0');
		$sheet_writer->save('php://output');
	}

	function create_plain_excel($filename)
	{
		/* Way to call this function ..
		 * 
		 * 	$filename = 'filename';
			$this->report_creation->create_plain_excel($filename);
			$this->load->view('view_file_path',$datatoviewfile);
		 * 
		 * */
		// We change the headers of the page so that the browser will know what sort of file is dealing with. Also, we will tell the browser it has to treat the file as an attachment which cannot be cached.
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=".$filename.'_'.date('dMy').".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
	
	function create_csv_with_excel($title,$description,$inputdata,$filename)
	{
		/*
		 * Required files 
		 * 1. A folder name PHPExcel which contain classes should be placed in thirdparty folder.
		 * 2. A file name PHPExcel.php will be in thirdparty folder.
		 * 3. A library with name excel.php in library folder.
		 * 
		 * 
		 * 
		 * Input Data should be in format like 
		 * 1.  	$inputdata = array(array('No','Name'),array('1','Aakash'),array('2','Tehra'));
		 * 2.  	$inputdata[] =  array('No','Name');
				$inputdata[] =  array('1','Aakash');
				$inputdata[] =  array('2','Tehra');
		 * 
		 * Way to call this function 
		 * 
		 * 	$title = 'Excel Title';
		 *  $description = 'Excel Description';
			$filename = 'file name';
			$this->report_creation->create_excel($title,$description,$inputdata,$filename);
		 * 
		 * */
		
		$CI =& get_instance();     
		$CI->load->library('excel');
		$sheet = new PHPExcel();
		$sheet->getProperties()->setTitle($title)->setDescription($description);
		$sheet->setActiveSheetIndex(0);
		$col = 0;$fieldnamearray = array();$fielddataarray = array();
		foreach ($inputdata[0] as $field=>$value)
		{
			$fieldnamearray[] = $value;
		}
		$fieldnamestring = implode(';', $fieldnamearray);
		$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, 0, $fieldnamestring);
		$row = 1;
		foreach ($inputdata as $data)
		{
			$col = 0;$fielddataarray = array();
			foreach ($data as $field=>$value)
			{
				$fielddataarray[] = $value;
				
			}
			$fielddatastring = implode(';', $fielddataarray);
			$sheet->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $fielddatastring);
			$row++;
		}
		$sheet_writer = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'_'.date('dMy').'.csv"');
		header('Cache-Control: max-age=0');
		$sheet_writer->save('php://output');
	}

	function create_csv($inputdata,$filename)
	{
		/*
		 * Required files 
		 *  
		 * Input Data should be in format like 
		 * 1.  	$inputdata = array(array('No','Name'),array('1','Aakash'),array('2','Tehra'));
		 * 2.  	$inputdata[] =  array('No','Name');
				$inputdata[] =  array('1','Aakash');
				$inputdata[] =  array('2','Tehra');
		 * 
		 * Way to call this function 
		 * 
		 * 	
			$filename = 'file name';
			$this->report_creation->create_csv($inputdata,$filename);
		 * 
		 * */
		$tempfilename = tempnam(sys_get_temp_dir(), "csv");
		$file = fopen($tempfilename,"w");
		foreach ($inputdata as $fields)
		{
    		fputcsv($file, $fields);
		}
		fclose($file);
		header("Content-Type: application/csv");
		header("Content-Disposition: attachment;Filename=".$filename.'_'.date('dMy').".csv");
		readfile($tempfilename);
		unlink($tempfilename);
	}



}
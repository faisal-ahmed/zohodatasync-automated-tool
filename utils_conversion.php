<?php

require_once dirname(__FILE__) . '/PHPExcel.php';

class CsvConversion
{
    public function __construct()
    {
    }

	private function create_array_2_csv_local_file(array &$csv_array)
	{
		if (count($csv_array) == 0) {
			return null;
		}
		
		$csv = '';
		$csv_handler = fopen ( dirname(__FILE__) . '/uploads/convertedFile.csv','w');
		foreach ($csv_array as $key => $value){
			foreach ($value as $key1 => $value1){
				$value1 = '"' . $value1 . '"';
				if (!$key1) $csv .= $value1;
				else $csv .= ",$value1";
			}
			$csv .= "\n";
		}
				
		fwrite ($csv_handler, $csv);
		fclose ($csv_handler);
	}
	
	public function download_file() {
		if (file_exists( dirname(__FILE__) . '/uploads/convertedFile.csv')) {
			ob_start();
			header('Content-Description: File Transfer');
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header('Content-Disposition: attachment; filename='.date("Y-m-d_H.i.s_").'convertedFile.csv');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize( dirname(__FILE__) . '/uploads/convertedFile.csv'));
			ob_clean();
			flush();
			readfile( dirname(__FILE__) . '/uploads/convertedFile.csv');
			ob_end_flush
		}
	}
	
	public function convert_excel_to_csv($extention, $filename) {
		$csvArray = array();
		
		$objPHPExcel = new PHPExcel();
		
		if ($extention === 'xls') $objReader = new PHPExcel_Reader_Excel5();
		else if ($extention === 'xlsx') $objReader = new PHPExcel_Reader_Excel2007();
		
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load( dirname(__FILE__) . "/uploads/$filename" );
		$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();

		$csvArray = array();
		foreach($rowIterator as $row){
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false);
			$rowIndex = $row->getRowIndex() - 1;
			$csvArray[$rowIndex] = array();
			 
			foreach ($cellIterator as $cell) {
				$csvArray[$rowIndex][] = $cell->getCalculatedValue();
			}
		}
		
		$this->create_array_2_csv_local_file($csvArray);
	}
}
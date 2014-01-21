<?php

if (isset($_REQUEST['get_my_csv']) && $_REQUEST['get_my_csv'] === 'download_now') {
    $parser = new CsvConversion();
    $parser->download_file();
    die;
}

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
		ob_start();
		if (file_exists( dirname(__FILE__) . '/uploads/convertedFile.csv')) {
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
		}
		ob_end_flush();
		die;
	}
	
	public function convert_excel_to_csv($extention, $filename) {
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

    public function parse_csv_column(){
        $fp = fopen(dirname(__FILE__) . '/uploads/convertedFile.csv', 'r') or die("can't open file");
        $return = array();

        while ($csv_line = fgetcsv($fp)) {
            for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                $temp_string = trim($csv_line[$i]);
                $return[str_replace(' ', '_', $temp_string)] = $temp_string;
            }
            break;
        }

        fclose($fp);

        return $return;
    }

    public function parse_csv_to_array($keys) {
        $fp = fopen(dirname(__FILE__) . '/uploads/convertedFile.csv', 'r') or die("can't open file");
        $return = array();
        $keys_index = array();
        $count = 0;

        while ($csv_line = fgetcsv($fp)) {
            if ($count++ == 0) {
                for ($i = 0, $j = count($csv_line); $i < $j; $i++) {
                    $keys_index[$csv_line[$i]] = $i;
                }
                continue;
            }
            if ($count == 5) break;
            $ret = array();
            foreach ($keys as $key => $csvColumn) {
                $temp_string = $key;
                $ret[str_replace('_', ' ', $temp_string)] = trim($csv_line[$keys_index[$csvColumn]]);
            }
            $return[$count-1] = $ret;
        }

        fclose($fp);

        return $return;
    }
}

?>
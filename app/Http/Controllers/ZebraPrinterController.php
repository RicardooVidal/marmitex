<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

//TODO: Increase code for Linux and MacOS.

class ZebraPrinterController extends Controller {

	private $os;
	private $print;
	private $prints = [];

	public function __construct(){
		$this->os = $this->supportedOs();
		$this->supportedModels();
	}

	public function print($printer = false, $path){
		try{
			if($printer === false){
				$printer = $this->print;
			}else{
				//print_r($printer);
				if(!in_array($printer, $this->prints)){
					//print_r($this->prints);
					array_push($this->prints, $printer);
					//throw new \Exception("Invalid Printer! Availables: ". join(", ", $this->prints));
				}else{
					$printer = '-print-to "'.$printer.'"';
				}
			}

			if(!isset($path) || empty($path)){
				throw new \Exception("Required PDF path parameter");
			}

			if(!file_exists($path)){
				throw new \Exception("PDF not found in {$path}");
			}

			if(_mime_content_type($path) !== "application/pdf"){
				throw new \Exception("Invalid file: your file is not a PDF");
			}

			shell_exec(''.__DIR__ . "/bin/pdf.exe".' '.$printer.' -silent "'.$path.'"');
			return true;
		}catch(\Exception $e){
			die($e->getMessage());
		}
	}

	private function mime_content_type($filename)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filename);
        finfo_close($finfo);

        return $mimeType;
    }

	private function supportedOs(){
		try{
			$os = php_uname("s");
			if(!preg_match("/^Windows/mi", $os)){
				throw new \Exception("Your operating system is not supported");
			}
			return "Windows";
		}catch(\Exception $e){
			die($e->getMessage());
		}
	}

	public function list(){
		return $this->prints;
	}

	private function supportedModels(){
		$path = __DIR__."/bin/models.json";
		try{
			if(!file_exists($path)){
				throw new \Exception("Required File models.json in bin/");
			}

			$models = file_get_contents($path);
			$models = json_decode($models, true);

			if(is_null($models)){
				throw new \Exception("Invalid File models.json in {$path}");
			}else{
				if($this->os === "Windows"){
					$prints = shell_exec("wmic printer get name");
					if(strlen($prints) >= 1){
						$prints = explode("\n", $prints);
						$data = [];
						foreach($models as $model){
							for($i = 0; $i < count($prints); $i++){
								//echo $model;
								$print = trim($prints[$i]);
								//	echo $print;
								//if(preg_match("/^".$model."/mi", preg_replace("/(ZDesigner\s+)/mi", "", $print))){
								if(preg_match("/ZDesigner.*/mi", $print)){
									//echo $print;
									array_push($data, $print);
								}
							}
						}
						if(count($data) == 1){
							$this->prints = $data;
							$this->print = '-print-to "'.array_shift($data).'"';
						}elseif(count($data) >= 2){
							$this->prints = $data;
							$this->print = '-print-to "'.array_shift($data).'"';
						}else{
							throw new \Exception("No printers supported");
						}
					}else{
						throw new \Exception("No printers found");
					}
				}
			}
		}catch(\Exception $e){
			die($e->getMessage());
		}
	}


}
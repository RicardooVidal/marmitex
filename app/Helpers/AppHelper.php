<?php
namespace App\Helpers;
use App\Employee;
use App\Restaurant;
use Carbon\Carbon;
use Exception;
use mikehaertl\wkhtmlto\Pdf;

class AppHelper
{

    public static function instance()
    {
        return new AppHelper();
    }
    
    public function convertToMoney($value) : string
    {
        $value = (float) $value;
        $valueConverted = str_replace(',','.',$value); 
        $valueConverted = number_format($valueConverted,2);

        return $valueConverted;
    }

    public function generateTxt($name, $value) :bool
    {
        $content = $value;
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/".$name.".txt","wb");
        if(fwrite($fp,$content)) {
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    public function parseHtml2PDF($htmlPath, $content, $pdfPath, $print)
    {
        try {
            //$fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/$name","wb");
            $value = $this->removeAcentuacao(utf8_decode($content));
            $file = "/tmp/$htmlPath";
            file_put_contents($file, $value);

            if(!$file)
                throw new Exception('Unable to create file. Please check app permissions!');
            
            @chmod ($file, 0777); 

            $pdf = new Pdf($file);
            $pdf->saveAs($pdfPath);

            if ($print) {
                $pdf->send($pdfPath);
            }

        } catch (Exception $e) {
            throw new Exception($e);
        }
    }

    public function removeAcentuacao($word): string
    {
        return strtr($word,'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); 
    }

    public function openExternalSite($address) {
        $url = $address;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        $data = curl_exec($curl);
        curl_close($curl);
    
    }

    public function generateHtmlName() {
        return 'html_'.uniqid().'.html';
    }


    static function getEmployeeName($id) 
    {
        $id = (integer) $id;
        $employee = Employee::where('id', $id)->get();
        $name = '';
        foreach($employee as $e) {
            $name = $e->nome;
        }

        return $name;
    }

    static function getEmployeeSurname($id) 
    {
        $employee = Employee::where('id', $id)->get();
        $surname = '';
        foreach($employee as $e) {
            $surname = $e->sobrenome;
        }
        return $surname;
    }

    static function getRestaurantName($id) 
    {
        $restaurant = Restaurant::where('id', $id)->get();
        foreach($restaurant as $r) {
            $nome = $r->nome;
        }
        return $nome;
    }

    public function exportToPdf($content, $name, $htmlPath)
    {
        $htmlPath = $this->generateHtmlName();
        $path = "cobrancas/".trim($name).".pdf";
        $this->parseHtml2PDF($htmlPath,$content,$path, true);
    }

    public static function checkLicense()
    {
        $company = env('COMPANY');
        
        $today = Carbon::now()->toDateString();

        try {
            $billing = \DB::connection('mysql_billing')->select('SELECT * FROM billing_marmitex WHERE company = ' . "'" . $company . "'");
            
            $billing = $billing[0];

            // Verifica se está ativo
            if (!$billing->active == 1) {
                return [
                    'msg' => "Licenca do company {$company} nao encontrado",
                    'status' => 'error'
                ];
            }

            return [
                'msg' => 'Licença Ok.',
                'status' => 'ok'
            ];

        } catch (Exception $e) {
            return [
                'msg' => 'Não foi possível validar a licença. Verifique sua conexão com a internet. Se o erro persistir, entre em contato em contato@ricardovidal.xyz',
                'status' => 'error'
            ];
        }
    }
}
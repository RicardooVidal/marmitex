<?php
namespace App\Helpers;
class AppHelper
{

    public static function instance()
    {
        return new AppHelper();
    }
    
    public function convertToMoney($value) : string
    {
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

    public function generateHtml2PDF($name, $value)
    {
        echo $name;
        echo $value;
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/".$name.".html","wb");
        $value = $this->removeAcentuacao(utf8_decode($value));
        fwrite($fp,$value);
        fclose($fp);
        $file = fopen("cobranca.html", "r") or die("Unable to open file!");
        $content = fread($file,filesize("cobranca.html"));

        try {

        } catch (Html2PdfException $e) {
            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
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
}
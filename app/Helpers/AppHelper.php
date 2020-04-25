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
        return strtr($word,'àáâãäçèéêëìíîïñòóôõöùúûüıÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜİ','aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY'); 
    }
}
<?php

// ****************************** CsvFile class  *******************************************************
class CsvFile
{
    var $strPathName;
    var $file;
                     
    function CsvFile($strPathName) 
    {
        $this->strPathName = $strPathName;
        $this->file = false;
    }
    
    function WriteArray($ar)
    {
    	if ($this->file == false)
    	{
    		$this->file = fopen($this->strPathName, 'w');
    	}
    	
    	$strLine = '';
    	foreach ($ar as $str)
    	{
    		$strLine .= $str.',';
    	}
    	$strLine = rtrim($strLine, ',');
    	fputs($this->file, $strLine."\n");
    }
    
    function Close()
    {
    	if ($this->file)
    	{
    		fclose($this->file);
    	}
    }
    
    function GetPathName()
    {
    	return $this->strPathName;
    }
}

class PageCsvFile extends CsvFile
{
    function PageCsvFile() 
    {
        parent::CsvFile(DebugGetCsvName(UrlGetTitle()));
    }
}

?>

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
    
    function GetPathName()
    {
    	return $this->strPathName;
    }
    
    function _open($strMode)
    {
    	if ($this->file == false)
    	{
    		$this->file = fopen($this->strPathName, $strMode);
    	}
    }
    
    function WriteArray($ar)
    {
    	$this->_open('w');
    	
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
    		$this->file = false;
    	}
    }
    
    function ReadColumn($iColumn)
    {
    	$ar = array();
    	$this->_open('r');
    	while (!feof($this->file))
    	{	
    		$strLine = fgets($this->file);
    		$arWord = explode(',', $strLine);
    		if (count($arWord) > $iColumn)
    		{
    			$ar[$arWord[0]] = floatval($arWord[$iColumn]);
    		}
        }
    	$this->Close();
    	return $ar;
    }
}

class PageCsvFile extends CsvFile
{
    function PageCsvFile() 
    {
        parent::CsvFile(DebugGetCsvName(UrlGetUniqueString()));
    }
}

?>

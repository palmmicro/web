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
    
    function GetLink()
    {
    	return GetFileLink($this->strPathName);
    }
    
    function HasFile()
    {
    	return file_exists($this->strPathName);
    }
    
    function _open($strMode)
    {
    	if ($this->file == false)
    	{
    		$this->file = fopen($this->strPathName, $strMode);
    	}
    }
    
    function Write()
    {
    	$this->_open('w');
    	if ($this->file == false)	return;
    	
    	$strLine = '';
    	foreach (func_get_args() as $str)
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
    
    function OnLineArray($arWord)
    {
    	DebugArray($arWord);
    }
    
    function Read()
    {
    	$this->_open('r');
    	if ($this->file)
    	{
    		while (!feof($this->file))
    		{	
    			if ($strLine = fgets($this->file))
    			{
    				$arWord = explode(',', $strLine);
    				$this->OnLineArray($arWord);
    			}
    		}
    		$this->Close();
    	}
    }
}

class PageCsvFile extends CsvFile
{
	var $arColumn = array();
	var $iColumn;
	
    function PageCsvFile() 
    {
        parent::CsvFile(DebugGetCsvName(UrlGetUniqueString()));
    }

    function OnLineArray($arWord)
    {
    	if (count($arWord) > $this->iColumn)
    	{
    		$this->arColumn[$arWord[0]] = floatval($arWord[$this->iColumn]);
    	}
    }
    
    function ReadColumn($iColumn)
    {
    	unset($this->arColumn);	// array_splice($this->arColumn, 0);
    	
    	$this->arColumn = array();
    	$this->iColumn = $iColumn;
    	$this->Read();
    	return $this->arColumn;
    }
}

?>

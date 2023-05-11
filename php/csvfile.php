<?php

class CsvFile
{
    var $strPathName;
    var $file;
    
    var $strSeparator;
    var $strReport;
    
    function CsvFile($strPathName) 
    {
        $this->strPathName = $strPathName;
        $this->file = false;
        
        $this->strSeparator = ',';
    }

    function SetSeparator($strSeparator)
    {
        $this->strSeparator = $strSeparator;
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
    	clearstatcache();
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
    
    public function OnLineArray($arWord)
    {
    	DebugPrint($arWord);
    }
    
    function DebugReport($str)
    {
    	$this->strReport .= $str.' ';
    }
    
    function Read()
    {
    	if ($this->HasFile() === false)		return;
    	
        $this->strReport = '';
    	$this->_open('r');
    	if ($this->file)
    	{
    		while (!feof($this->file))
    		{	
    			if ($strLine = fgets($this->file))
    			{
    				$strLine = trim($strLine);
    				if ($strLine != '')
    				{
    					$arWord = str_getcsv($strLine, $this->strSeparator);		// 跟explode比，str_getcsv会去掉双引号。
    					$this->OnLineArray($arWord);
    				}
    			}
    		}
    		$this->Close();
    	}
    	if ($this->strReport != '')	trigger_error($this->strReport);
    }
}

class DebugCsvFile extends CsvFile
{
    function DebugCsvFile($strFileName) 
    {
    	$strPath = DebugGetPath('csv');				// test.php calls DebugClearPath('csv') to delete all DebugCsvFile
        parent::CsvFile("$strPath/$strFileName");
    }
}

class PageCsvFile extends DebugCsvFile
{
	var $arColumn = array();
	var $iColumn;
	
    function PageCsvFile() 
    {
        parent::DebugCsvFile(UrlGetUniqueString().'.csv');
    }

    public function OnLineArray($arWord)
    {
    	if (count($arWord) > $this->iColumn)
    	{
    		if ($strKey = $arWord[0])
    		{
    			$this->arColumn[$strKey] = floatval($arWord[$this->iColumn]);
    		}
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

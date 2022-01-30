<?php

// ****************************** CsvFile class  *******************************************************
class CsvFile
{
    var $strFileName;
    var $file;
    
    var $strSeparator;
    var $strError;
                     
    function CsvFile($strFileName) 
    {
        $this->strFileName = $strFileName;
        $this->file = false;
        
        $this->strSeparator = ',';
    }
    
    function SetSeparator($strSeparator)
    {
        $this->strSeparator = $strSeparator;
    }
    
    function GetName()
    {
    	return $this->strFileName;
    }
    
    function GetLink()
    {
    	return GetFileLink($this->strFileName);
    }
    
    function HasFile()
    {
    	clearstatcache();
    	return file_exists($this->strFileName);
    }
    
    function GetModifiedSeconds()
    {
    	$iSeconds = time();
    	if ($this->HasFile())
    	{
    		$iSeconds -= filemtime($this->strFileName);
    	}
   		return $iSeconds;
    }
    
    function _open($strMode)
    {
    	if ($this->file == false)
    	{
    		$this->file = fopen($this->strFileName, $strMode);
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
    
    function ErrorReport($str)
    {
		DebugString($str);
    	$this->strError .= $str.'<br />';
    }
    
    function Read()
    {
    	if ($this->HasFile() === false)		return;
    	
        $this->strError = '';
    	$this->_open('r');
    	if ($this->file)
    	{
    		while (!feof($this->file))
    		{	
    			if ($strLine = fgets($this->file))
    			{
    				$arWord = str_getcsv($strLine, $this->strSeparator);
    				$this->OnLineArray($arWord);
    			}
    		}
    		$this->Close();
    	}
    	if ($this->strError != '')	trigger_error($this->strError);
    }
}

class DebugCsvFile extends CsvFile
{
    function DebugCsvFile($strDebug) 
    {
    	$strPath = DebugGetPath('csv');				// test.php calls DebugClearPath('csv') to delete all DebugCsvFile
        parent::CsvFile("$strPath/$strDebug.csv");
    }
}

class PageCsvFile extends DebugCsvFile
{
	var $arColumn = array();
	var $iColumn;
	
    function PageCsvFile() 
    {
        parent::DebugCsvFile(UrlGetUniqueString());
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

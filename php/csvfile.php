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

class PriceGoal
{
    var $iTotal;
    
    var $iHigher;
    var $iUnchanged;
    var $iLower;

    function PriceGoal() 
    {
        $this->iTotal = 0;
        
        $this->iHigher = 0;
        $this->iUnchanged = 0;
        $this->iLower = 0;
    }
    
    function AddData($fVal)
    {
   		if (empty($fVal))
   		{
   			$this->iUnchanged ++;
   		}
   		else if ($fVal > 0.0)
    	{
    		$this->iHigher ++;
    	}
    	else
    	{
    		$this->iLower ++;
    	}
        $this->iTotal ++;
    }
}

class PricePool
{
	var $h_goal;
	var $u_goal;
	var $l_goal;

    function PricePool() 
    {
        $this->h_goal = new PriceGoal();
        $this->u_goal = new PriceGoal();
        $this->l_goal = new PriceGoal();
    }
    
    function OnData($fVal, $fCompare)
    {
    	if (empty($fVal))
    	{
   			$this->u_goal->AddData($fCompare);
    	}
    	else if ($fVal > 0.0)
    	{
   			$this->h_goal->AddData($fCompare);
    	}
    	else
    	{
  			$this->l_goal->AddData($fCompare);
     	}
    }
}

class PricePoolCsvFile extends PageCsvFile
{
	var $pool;
	
    function PricePoolCsvFile() 
    {
        parent::PageCsvFile();
        $this->pool = new PricePool();
    }
}

?>

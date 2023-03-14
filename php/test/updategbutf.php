<?php
require_once('../account.php');
require_once('../sql/sqlgb2312.php');

class _AdminGbUtfAccount extends Account
{
    public function AdminProcess()
    {
    	$strFileName = 'gbkuni30.txt'; 
    	$file = fopen($strFileName, 'r');
    	if ($file == false)
    	{
    		DebugString('Can not read file '.$strFileName);
    		return;
    	}
    
    	$iTotal = 0;
    	$iCount = 0;
    	$sql = new GB2312Sql();
    	while (!feof($file))
    	{
    		$strLine = fgets($file);
    		$arWord = explode(':', $strLine);
    		if (count($arWord) == 2)
    		{
    			$strUtf = $arWord[0];
    			$strGb = $arWord[1];
    			if (strlen($strGb) >= 4)
    			{
    				$strGb = substr($strGb, 0, 4);
    				if ($strOld = $sql->GetUTF($strGb))
    				{
    					if ($strOld != $strUtf)	DebugString($strGb.'?'.$strOld.':'.$strUtf);
    				}
    				else
    				{
    					$sql->Insert($strGb, $strUtf);
    					$iCount ++;
    				}
    				$iTotal ++;
    			}
    		}
    	}
    	fclose($file);
    
    	DebugVal($iTotal, ' read');
    	DebugVal($iCount, ' updated');
    }
}

   	$acct = new _AdminGbUtfAccount();
	$acct->AdminRun();

?>

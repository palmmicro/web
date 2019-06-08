<?php
require_once('/php/account.php');
require_once('/php/sql/sqlgb2312.php');

function _updateGbUtf()
{
    $file = fopen('gbkuni30.txt', 'r');
    if ($file == false)
    {
    	DebugString('Can not open read file');
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
        		if ($strOld = $sql->Get($strGb))
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
	
	AcctAdminCommand('_updateGbUtf');

?>

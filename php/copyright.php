<?php
// Provide enhanced function replacement of /js/copyright.js
// CopyRight functions

function _getCopyright($strCn, $strUs, $bChinese, $strBeginYear = false)
{
	$strName = $bChinese ? $strCn : $strUs;
    if ($strBeginYear)
    {
        $ymd = GetNowYMD();
        $strYear = $strBeginYear.'-'.strval($ymd->GetYear());
    }
    else	$strYear = '';
    return $bChinese ? "$strYear {$strName}版权所有&copy;，保留所有权利。" : "Copyright &copy; $strYear $strName. All Rights Reserved.";
}

function EchoCopyRight($bMobile, $bChinese)
{
	$str = _getCopyright('Palmmicro', 'Palmmicro Communications Inc', $bChinese, '2006');
	$str = GetHtmlElement($str); 
	if ($bMobile)
	{
	    $str .= GetSwitchLanguageLink($bChinese);
	}
	
    echo <<<END

<div id="copyright">
$str
</div>
END;
}

?>

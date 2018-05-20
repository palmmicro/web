<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

function EchoPageImage($str, $strPathName, $strPageTitle)
{
	$strRand = strval(rand());
	echo <<< END
	<p>$str
	<br /><img src=$strPathName?$strRand alt="$strPageTitle automatical generated image" />
    </p>
END;
}

function _echoAhHistoryGraph($bChinese)
{
   	$csv = new PageCsvFile();
    $jpg = new PageImageFile();
    $jpg->DrawDateArray($csv->ReadColumn(4));
    $jpg->SaveFile();
    EchoPageImage(GetFileLink($csv->GetPathName()), $jpg->GetPathName(), UrlGetTitle());
}

function _echoAhHistoryItem($csv, $history, $sql_pair, $sql_hkcny, $fRatio)
{
	$strDate = $history['date'];
	$fClose = floatval($history['close']);
	$strClose = round_display($fClose);
	
	if ($fHKCNY = $sql_hkcny->GetClose($strDate))		$strHKCNY = round_display($fHKCNY);
	else													$strHKCNY = '';
	
	$strAH = '';
	$strHA = '';
	if ($fPairClose = $sql_pair->GetClose($strDate))
	{
		$strPairClose = round_display($fPairClose);
		if ($fHKCNY)
		{
			$fAh = $fClose / HShareEstToCny($fPairClose, $fRatio, $fHKCNY);
			$strAH = GetRatioDisplay($fAh);
			$strHA = GetRatioDisplay(1.0 / $fAh);
			$csv->WriteArray(array($strDate, $strClose, $strPairClose, $strHKCNY, round_display($fAh)));
		}
	}
	else
	{
		$strPairClose = '';
	}
	
    echo <<<END
    <tr>
        <td class=c1>$strDate</td>
        <td class=c1>$strClose</td>
        <td class=c1>$strPairClose</td>
        <td class=c1>$strHKCNY</td>
        <td class=c1>$strAH</td>
        <td class=c1>$strHA</td>
    </tr>
END;
}

function _echoAhHistoryData($sql, $strPairId, $fRatio, $iStart, $iNum)
{
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
    	$sql_hkcny = new SqlHkcnyHistory();
    	$sql_pair = new SqlStockHistory($strPairId);
     	$csv = new PageCsvFile();
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($csv, $history, $sql_pair, $sql_hkcny, $fRatio);
        }
        $csv->Close();
        @mysql_free_result($result);
    }
}

function _echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $fRatio, $iStart, $iNum, $bChinese)
{
    if ($bChinese)  $arColumn = array('日期');
    else              $arColumn = array('Date');
    $arColumn[] = GetMyStockLink($strSymbol, $bChinese);
    $strPairSymbol = SqlGetStockSymbol($strPairId);
    $arColumn[] = GetMyStockLink($strPairSymbol, $bChinese);
	$arColumn = array_merge($arColumn, GetAhCompareTableColumn($bChinese));
    $arColumn[3] = GetMyStockLink('HKCNY', $bChinese);
	
    $strUpdateLink = ''; 
    if (AcctIsAdmin() && $bChinese)
    {
        $strUpdateLink = GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strStockId, "确认更新$strSymbol历史记录?", $strSymbol);
        $strUpdateLink .= ' '.GetOnClickLink(STOCK_PHP_PATH.'_submithistory.php?id='.$strPairId, "确认更新$strPairSymbol历史记录?", $strPairSymbol);
    }

	$sql = new SqlStockHistory($strStockId);
    $strNavLink = _GetStockNavLink($strSymbol, $sql->Count(), $iStart, $iNum, $bChinese);
 
    EchoParagraphBegin($strNavLink.' '.$strUpdateLink);
    echo <<<END
    <TABLE borderColor=#cccccc cellSpacing=0 width=530 border=1 class="text" id="ahhistory">
    <tr>
        <td class=c1 width=100 align=center>{$arColumn[0]}</td>
        <td class=c1 width=80 align=center>{$arColumn[1]}</td>
        <td class=c1 width=80 align=center>{$arColumn[2]}</td>
        <td class=c1 width=80 align=center>{$arColumn[3]}</td>
        <td class=c1 width=80 align=center>{$arColumn[4]}</td>
        <td class=c1 width=110 align=center>{$arColumn[5]}</td>
    </tr>
END;
   
    _echoAhHistoryData($sql, $strPairId, $fRatio, $iStart, $iNum);
    EchoTableParagraphEnd($strNavLink);

    _echoAhHistoryGraph($bChinese);
}

function EchoAhHistory($bChinese)
{
    if ($strSymbol = UrlGetQueryValue('symbol'))
    {
    	if ($strStockId = SqlGetStockId($strSymbol))
    	{
    		$sql = new SqlStockPair($strStockId, TABLE_AH_STOCK);
    		if ($strPairId = $sql->GetPairId())
    		{
    			$iStart = UrlGetQueryInt('start', 0);
    			$iNum = UrlGetQueryInt('num', DEFAULT_NAV_DISPLAY);
    			_echoAhHistoryParagraph($strSymbol, $strStockId, $strPairId, $sql->GetRatio(), $iStart, $iNum, $bChinese);
    		}
    	}
    }
    EchoPromotionHead('', $bChinese);
}

function EchoTitle($bChinese)
{
    EchoUrlSymbol();
    if ($bChinese)  echo '历史AH价格比较';
    else              echo ' AH History Compare';
}

    AcctAuth();

?>

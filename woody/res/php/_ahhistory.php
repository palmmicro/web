<?php
require_once('_stock.php');
require_once('/php/csvfile.php');
require_once('/php/imagefile.php');

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
			$fHa = 1.0 / $fAh;
			$strAH = GetRatioDisplay($fAh);
			$strHA = GetRatioDisplay($fHa);
			$csv->WriteArray(array($strDate, $strClose, $strPairClose, $strHKCNY, round_display($fAh), round_display($fHa)));
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

function _echoAhHistoryData($csv, $sql, $strPairId, $fRatio, $iStart, $iNum)
{
	$sql_hkcny = new SqlHkcnyHistory();
	$sql_pair = new SqlStockHistory($strPairId);
    if ($result = $sql->GetAll($iStart, $iNum)) 
    {
        while ($history = mysql_fetch_assoc($result)) 
        {
            _echoAhHistoryItem($csv, $history, $sql_pair, $sql_hkcny, $fRatio);
        }
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
 
    $csv = new PageCsvFile();
//    $csv->WriteArray($arColumn);
    $strFileLink = GetFileLink($csv->GetPathName());
    
    EchoParagraphBegin($strNavLink.' '.$strFileLink.' '.$strUpdateLink);
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
   
    _echoAhHistoryData($csv, $sql, $strPairId, $fRatio, $iStart, $iNum);
    $csv->Close();
    EchoTableEnd();
    EchoParagraphEnd();
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

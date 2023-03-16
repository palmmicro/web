<?php
require_once('_commonupdatestock.php');
require_once('../csvfile.php');

// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCount?node=hs_a
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCount?node=hs_b

// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page=1&num=100&sort=symbol&asc=1&node=hs_a
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page=1&num=100&sort=symbol&asc=1&node=hs_b

function GetSinaMarketJsonUrl()
{
	return GetSinaVipStockUrl().'/quotes_service/api/json_v2.php';
}

function GetSinaMarketCountUrl($strNode)
{
	return GetSinaMarketJsonUrl().'/Market_Center.getHQNodeStockCount?node='.$strNode;
}

function GetSinaMarketDataUrl($strNode, $iPage, $iNum)
{
	return GetSinaMarketJsonUrl().'/Market_Center.getHQNodeData?page='.strval($iPage).'&num='.strval($iNum).'&sort=symbol&asc=1&node='.$strNode;
}

function GetSinaMarketCount($strNode)
{
	$strUrl = GetSinaMarketCountUrl($strNode);
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString('read '.$strUrl.' as '.$str);
   		$ar = json_decode($str, true);
   		DebugPrint($ar);
		return intval($ar);
   	}
   	return 0;
}

/*
            [symbol] => sz300225
            [code] => 300225
            [name] => 金力泰
            [trade] => 7.250
            [pricechange] => 1.21
            [changepercent] => 20.033
            [buy] => 7.250
            [sell] => 0.000
            [settlement] => 6.040
            [open] => 5.980
            [high] => 7.250
            [low] => 5.850
            [volume] => 67297354
            [amount] => 446749739
            [ticktime] => 15:35:00
            [per] => -31.522
            [pb] => 4.466
            [mktcap] => 354673.8425
            [nmc] => 343465.554925
            [turnoverratio] => 14.20538
*/

function GetSinaMarketData($strNode, $iPage, $iNum)
{
	$strUrl = GetSinaMarketDataUrl($strNode, $iPage, $iNum);
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString('read '.$strUrl);
   		$ar = json_decode($str, true);
//   		DebugPrint($ar);
		return $ar;
   	}
   	return false;
}

class _AdminChinaStockAccount extends TitleAccount
{
    function _AdminChinaStockAccount() 
    {
        parent::TitleAccount('node');
    }
    
    public function AdminProcess()
    {
    	$strNode = $this->GetQuery();	// 'hs_a';
		$iCount = GetSinaMarketCount($strNode);
		if ($iCount == 0)		return;
		
    	$iNum = 100;
    	$iPage = 1;
    	$iTotal = 0;
    	$iChanged = 0;
    	$sql = GetStockSql();
    	do
    	{
			if ($ar = GetSinaMarketData($strNode, $iPage, $iNum))
			{
				$iStockNum = count($ar);
				if ($iStockNum == 0)		break;
				
				$iTotal += $iStockNum;
				$iPage ++;
				foreach ($ar as $arStock)
				{
					$strSymbol = strtoupper($arStock['symbol']);
					$strName = $arStock['name'];
					if ($sql->WriteSymbol($strSymbol, $strName))
					{
						DebugString($strSymbol.' '.$strName);
						$iChanged ++;
					}
				}
			}
		} while ($iTotal < $iCount);

		DebugVal($iChanged);
		DebugVal($iTotal);
    }
}

   	$acct = new _AdminChinaStockAccount();
	$acct->AdminRun();
	
?>

<?php
require_once('_commonupdatestock.php');
require_once('../csvfile.php');

function GetSinaMarketJsonUrl()
{
	return GetSinaVipStockUrl().'/quotes_service/api/json_v2.php';
}

// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCount?node=hs_a
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCountSimple?node=hs_s
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCountSimple?node=etf_hq_fund
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeStockCountSimple?node=lof_hq_fund
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHKStockCount?node=qbgg_hk
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getUSCount?node=china_us
function GetSinaMarketCount($strNode)
{
	switch ($strNode)
	{
	case 'hs_a':
	case 'hs_b':
		$strCode = 'HQNodeStockCount';
		break;
		
	case 'hs_s':
	case 'etf_hq_fund':
	case 'lof_hq_fund':
		$strCode = 'HQNodeStockCountSimple';
		break;
	}
	
	$strUrl = GetSinaMarketJsonUrl().'/Market_Center.get'.$strCode.'?node='.$strNode;
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


// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeData?page=1&num=100&sort=symbol&asc=1&node=hs_a
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeDataSimple?page=1&num=80&sort=symbol&asc=1&node=hs_s&_s_r_a=init
// {"symbol":"sh000001","name":"\u4e0a\u8bc1\u6307\u6570","trade":"3255.6505","pricechange":"20.740","changepercent":"0.641","buy":"0","sell":"0","settlement":"3234.9103","open":"3240.8388","high":"3255.9997","low":"3237.8934","volume":301810779,"amount":388047055875,"code":"000001","ticktime":"15:30:39"},
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeDataSimple?page=1&num=80&sort=symbol&asc=1&node=etf_hq_fund&_s_r_a=init
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHQNodeDataSimple?page=1&num=80&sort=symbol&asc=1&node=lof_hq_fund&_s_r_a=init
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getHKStockData?page=1&num=80&sort=symbol&asc=1&node=qbgg_hk&_s_r_a=init
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getUSList?page=1&num=80&sort=chg&asc=0&node=china_us&_s_r_a=init
function GetSinaMarketData($strNode, $iPage, $iNum)
{
	switch ($strNode)
	{
	case 'hs_a':
	case 'hs_b':
		$strCode = 'HQNodeData';
		break;
		
	case 'hs_s':
	case 'etf_hq_fund':
	case 'lof_hq_fund':
		$strCode = 'HQNodeDataSimple';
		break;
	}
	
	$strUrl = 	GetSinaMarketJsonUrl().'/Market_Center.get'.$strCode.'?page='.strval($iPage).'&num='.strval($iNum).'&sort=symbol&asc=1&node='.$strNode;
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString('read '.$strUrl);
   		$ar = json_decode($str, true);
//   		DebugPrint($ar);
		return $ar;
   	}
   	return false;
}

function GetChinaStockSymbolId($strNode)
{
	switch ($strNode)
	{
	case 'hs_a':
		$strWhere = "symbol LIKE 'SZ0_____' OR symbol LIKE 'SZ3_____' OR symbol LIKE 'BJ4_____' OR symbol LIKE 'SH6_____' OR symbol LIKE 'BJ8_____'";
		break;
		
	case 'hs_b':
		$strWhere = "symbol LIKE 'SZ2_____' OR symbol LIKE 'SH9_____'";
		break;
		
	case 'hs_s':
		$strWhere = "symbol LIKE 'SZ399___' OR symbol LIKE 'SH000___' OR symbol LIKE 'BJ899___'";		// hs_s
		break;
		
	case 'etf_hq_fund':
		$strWhere = "symbol LIKE 'SZ15____' OR symbol LIKE 'SH51____' OR symbol LIKE 'SH56____' OR symbol LIKE 'SH58____'";
		break;
		
	case 'lof_hq_fund':
		$strWhere = "symbol LIKE 'SZ16____' OR symbol LIKE 'SH50____'";
		break;
	}
	
	return SqlGetStockSymbolAndId($strWhere);
}

// 已知问题：GetChinaStockSymbolId会把深市指数包括在深市股票中，然后在DeleteOldChinaStock误删除掉所有深市指数。临时解决方法是先更新A股股票，再更新A股指数数据。
function DeleteOldChinaStock($arSymbolId)
{
	$ab_sql = new AbPairSql();
	$ah_sql = new AhPairSql();
	foreach ($arSymbolId as $strSymbol => $strStockId)
	{
		if ($ab_sql->DeletePair($strStockId))	DebugString($strSymbol.' had ab_pair');
		if ($ah_sql->DeleteById($strStockId))	DebugString($strSymbol.' had ah_pair');
		if (SqlDeleteStockGroupItemByStockId($strStockId))
		{
			SqlDeleteStockEma($strStockId);
			SqlDeleteStockHistory($strStockId);
			SqlDeleteNavHistory($strStockId);
			SqlDeleteStock($strStockId);
			DebugString($strSymbol.' deleted');
		}
	}
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
		
		$arSymbolId = GetChinaStockSymbolId($strNode);		
		
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
					if (isset($arSymbolId[$strSymbol]))	unset($arSymbolId[$strSymbol]);
				}
			}
			else	break;
		} while ($iTotal < $iCount);

		DebugVal($iChanged, 'Changed');
		DebugVal($iTotal, 'All');
		DeleteOldChinaStock($arSymbolId);
    }
}

   	$acct = new _AdminChinaStockAccount();
	$acct->AdminRun();
	
?>

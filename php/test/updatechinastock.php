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
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getANHCount?node=aplush
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
		
	case 'qbgg_hk':
		$strCode = 'HKStockCount';
		break;
		
	case 'aplush':
		$strCode = 'ANHCount';
		break;
	}
	
	$strUrl = GetSinaMarketJsonUrl().'/Market_Center.get'.$strCode.'?node='.$strNode;
   	if ($str = url_get_contents($strUrl))
   	{
   		DebugString('read '.$strUrl.' as '.$str);
   		$ar = json_decode($str, true);
//   		DebugPrint($ar);
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
// {"symbol":"00001","name":"\u957f\u548c","engname":"CKH HOLDINGS","tradetype":"EQTY","lasttrade":"48.650","prevclose":"49.150","open":"49.250","high":"49.250","low":"48.350","volume":"5901354","currentvolume":"1221500","amount":"286995867","ticktime":"2023-03-23 16:08:38","buy":"48.650","sell":"48.700","high_52week":"56.525","low_52week":"38.550","eps":"1.227","dividend":"0.000","stocks_sum":"3830044500","pricechange":"-0.500","changepercent":"-1.0172940","market_value":"186331664925.000","pe_ratio":"39.6495518"},
// https://vip.stock.finance.sina.com.cn/quotes_service/api/json_v2.php/Market_Center.getANHData?page=1&num=80&sort=hrap&asc=0&node=aplush&_s_r_a=init
// [{"a":"sh600011","h":"00902"},{"a":"sh600012","h":"00995"},{"a":"sh600016","h":"01988"},
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
		
	case 'qbgg_hk':
		$strCode = 'HKStockData';
		break;
		
	case 'aplush':
		$strCode = 'ANHData';
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
		$strWhere = "symbol REGEXP '^(SH6|BJ[48]|SZ[03])[0-9]{5}$' AND symbol NOT REGEXP '^SZ399'";
		break;
		
	case 'hs_b':
		$strWhere = "symbol REGEXP '^(SH9|SZ2)[0-9]{5}$'";
		break;
		
	case 'hs_s':
		$strWhere = "symbol REGEXP '^(SH000|SZ399|BJ899)[0-9]{3}$'";
		break;
		
	case 'etf_hq_fund':
		$strWhere = "symbol REGEXP '^(SH5[168]|SZ15)[0-9]{4}$'";
		break;
		
	case 'lof_hq_fund':	
		$strWhere = "symbol REGEXP '^(SH50|SZ16)[0-9]{4}$'";;
		break;
		
	case 'qbgg_hk':
		$strWhere = "symbol REGEXP '^[0-9]{5}$'";
		break;
	}
	
	return SqlGetStockSymbolAndId($strWhere);
}

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
		else	DebugString($strSymbol.' NOT deleted');
	}
}

class _AdminChinaStockAccount extends TitleAccount
{
    function _AdminChinaStockAccount() 
    {
        parent::TitleAccount('node');
    }

    function _updateAhPairSql($strNode, $iCount)
    {
    	$ah_sql = new AhPairSql();
		$arOld = $ah_sql->GetAllIdVal();
		DebugVal(count($arOld), 'Original '.$strNode);
		
    	$iNum = 100;
    	$iPage = 1;
    	$iTotal = 0;
    	$iChanged = 0;
    	$sql = GetStockSql();
    	do
    	{
			if ($ar = GetSinaMarketData($strNode, $iPage, $iNum))
			{
				$iPairNum = count($ar);
				if ($iPairNum == 0)		break;
				
				$iTotal += $iPairNum;
				$iPage ++;
				foreach ($ar as $arPair)
				{
					$strSymbolA = strtoupper($arPair['a']);
					if ($strStockIdA = $sql->GetId($strSymbolA))
					{
						$strSymbolH = $arPair['h'];
						if ($strStockIdH = $sql->GetId($strSymbolH))
						{
							if ($ah_sql->WritePair($strStockIdA, $strStockIdH))
							{
								DebugString($strSymbolA.' vs '.$strSymbolH);
								$iChanged ++;
							}
							if (isset($arOld[$strStockIdA]))	unset($arOld[$strStockIdA]);
						}
					}
				}
			}
			else	break;
		} while ($iTotal < $iCount);

		DebugVal($iTotal, 'All');
		DebugVal($iChanged, 'Changed');
		DebugVal(count($arOld), 'To be deleted old '.$strNode);
		foreach ($arOld as $strId => $strPairId)	$ah_sql->DeleteById($strId);
    }
    
    function _updateStockSql($strNode, $iCount)
    {
		$arSymbolId = GetChinaStockSymbolId($strNode);
		DebugVal(count($arSymbolId), 'Original '.$strNode);
		
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

		DebugVal($iTotal, 'All');
		DebugVal($iChanged, 'Changed');
		DebugVal(count($arSymbolId), 'To be deleted old '.$strNode);
		DeleteOldChinaStock($arSymbolId);
    }
    
    public function AdminProcess()
    {
    	$strNode = $this->GetQuery();	// 'hs_a';
		$iCount = GetSinaMarketCount($strNode);
		if ($iCount > 0)
		{
			if ($strNode == 'aplush')		$this->_updateAhPairSql($strNode, $iCount);
			else							$this->_updateStockSql($strNode, $iCount);
		}
    }
}

   	$acct = new _AdminChinaStockAccount();
	$acct->AdminRun();
	
?>

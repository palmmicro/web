<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/stock/etfholdingsref.php');
require_once('/php/sql/sqldate.php');
require_once('/php/ui/referenceparagraph.php');

function _echoEtfHoldingItem($ref, $arRatio, $strDate, $his_sql)
{
	$strStockId = $ref->GetStockId();
	$strClose = $his_sql->GetClose($strStockId, $strDate);
	$strPrice = $ref->GetPrice();
	$fRatio = floatval($arRatio[$strStockId]);
	$fChange = $fRatio * $ref->GetPercentage($strClose, $strPrice) / 100.0;
	
	$ar = array();
	$ar[] = RefGetMyStockLink($ref);
    $ar[] = strval($fRatio);
    $ar[] = $strClose;
    $ar[] = $ref->GetPercentageDisplay($strClose, $strPrice);
    $ar[] = strval_round($fChange, 4);
    EchoTableColumn($ar);
    
    return $fChange;
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
    	$strStockId = $ref->GetStockId();
    	$date_sql = new EtfHoldingsDateSql();
    	if ($strDate = $date_sql->ReadDate($strStockId))
    	{
    		$strSymbol = $ref->GetSymbol();
    		$ref = new EtfHoldingsReference($strSymbol);
    		$arHoldingRef = $ref->GetHoldingRefArray();
    		EchoReferenceParagraph($arHoldingRef);
    	
    		$nav_sql = GetNavHistorySql();
    		$strNav = $nav_sql->GetClose($strStockId, $strDate);
    		$str = '更新日期'.$strDate.'当日净值'.$strNav;
    		EchoTableParagraphBegin(array(new TableColumnSymbol(),
										   new TableColumn('百分比'),
										   new TableColumnPrice('当日'),
										   new TableColumnChange('此后'),
										   new TableColumn('影响比例')
										   ), TABLE_ETF_HOLDINGS, $str);
	
			$holdings_sql = GetEtfHoldingsSql();
			$arRatio = $holdings_sql->GetHoldingsArray($strStockId);
			$his_sql = GetStockHistorySql();
			$fTotal = 0.0;
			foreach ($arHoldingRef as $holding_ref)
			{
				$fTotal += _echoEtfHoldingItem($holding_ref, $arRatio, $strDate, $his_sql);
			}
			EchoTableParagraphEnd();
			
			$str = '全部影响比例'.strval_round($fTotal, 2).'%';
			$fRealtime = floatval($strNav) * (1.0 + $fTotal / 100.0);
			$str .= '<br />实时净值'.strval_round($fRealtime, 2);
			EchoParagraph($str);
		}
    }
    $acct->EchoLinks(TABLE_ETF_HOLDINGS);
}

function EchoMetaDescription()
{
	global $acct;
	
  	$str = $acct->GetStockDisplay().ETF_HOLDINGS_DISPLAY;
    $str .= '页面. 用于显示ETF基金的成分股持仓情况, 以及各个成分股最新的价格. 基于成分股价格测算基金的官方估值和实时估值.';
    EchoMetaDescriptionText($str);
}

function EchoTitle()
{
	global $acct;
	
  	$str = $acct->GetSymbolDisplay().ETF_HOLDINGS_DISPLAY;
  	echo $str;
}

    $acct = new SymbolAccount();
   	$acct->Create();
?>


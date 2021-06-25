<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/fundestparagraph.php');

function _echoEtfHoldingItem($ref, $arRatio, $strDate, $his_sql, $fAdjustH)
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
    if ($ref->IsSymbolH())
    {
    	$ar[] = strval_round($fAdjustH, 4);
    	$fChange *= $fAdjustH;
    }
    EchoTableColumn($ar);
    
    return $fChange;
}

function EchoAll()
{
	global $acct;
	
    if ($ref = $acct->EchoStockGroup())
    {
   		$strSymbol = $ref->GetSymbol();
   		$ref = new EtfHoldingsReference($strSymbol);
    	if ($strDate = $ref->GetHoldingsDate())
    	{
    		$arHoldingRef = $ref->GetHoldingRefArray();
    		$arSelf = array($ref);
		    EchoFundArrayEstParagraph($arSelf, GetTableColumnNetValue().'和持仓比例更新日期'.$strDate);
    		EchoReferenceParagraph($arSelf + $arHoldingRef);
    		EchoTableParagraphBegin(array(new TableColumnSymbol(),
										   new TableColumn('百分比'),
										   new TableColumnPrice('当日'),
										   new TableColumnChange('此后'),
										   new TableColumn('影响比例'),
										   new TableColumn('H股调整')
										   ), TABLE_ETF_HOLDINGS, '持仓和测算示意');
	
			$arRatio = $ref->GetHoldingsRatioArray();
			$his_sql = GetStockHistorySql();
			$fTotal = 0.0;
			foreach ($arHoldingRef as $holding_ref)
			{
				$fTotal += _echoEtfHoldingItem($holding_ref, $arRatio, $strDate, $his_sql, $ref->GetAdjustH());
			}
			EchoTableParagraphEnd();
			
			$str = '全部影响比例'.strval_round($fTotal, 2).'%';
			$fRealtime = floatval($ref->GetNetValue()) * (1.0 + $fTotal / 100.0);
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


<?php
require_once('_stock.php');
require_once('_emptygroup.php');
require_once('/php/ui/referenceparagraph.php');
require_once('/php/ui/fundestparagraph.php');

function _echoEtfHoldingItem($ref, $arRatio, $strDate, $his_sql, $fTotalChange, $fAdjustH)
{
	$bHk = $ref->IsSymbolH() ? true : false;
	
	$strStockId = $ref->GetStockId();
	$strClose = $his_sql->GetAdjClose($strStockId, $strDate);
	$strPrice = $ref->GetPrice();
	$fRatio = floatval($arRatio[$strStockId]);
	$fChange = $ref->GetPercentage($strClose, $strPrice) / 100.0;
    if ($bHk)	$fChange *= $fAdjustH;
	
	$ar = array();
	$ar[] = RefGetMyStockLink($ref);
    $ar[] = strval($fRatio);
    $ar[] = $strClose;
    $ar[] = $ref->GetPercentageDisplay($strClose, $strPrice);
    $ar[] = strval_round($fRatio * (1 + $fChange) / $fTotalChange, 2);
    $ar[] = strval_round($fRatio * $fChange, 4);
    if ($bHk)	$ar[] = strval_round($fAdjustH, 4);
    
    EchoTableColumn($ar);
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
    		EchoReferenceParagraph(array_merge($arSelf, $arHoldingRef));
    		EchoTableParagraphBegin(array(new TableColumnSymbol(),
										   new TableColumnPercentage('旧'),
										   new TableColumnPrice('旧'),
										   new TableColumnChange('此后'),
										   new TableColumnPercentage('新'),
										   new TableColumnPercentage('影响'),
										   new TableColumn('H股汇率调整', 100)
										   ), TABLE_ETF_HOLDINGS, '持仓和测算示意');
	
			$arRatio = $ref->GetHoldingsRatioArray();
			$his_sql = GetStockHistorySql();
			foreach ($arHoldingRef as $holding_ref)
			{
				_echoEtfHoldingItem($holding_ref, $arRatio, $strDate, $his_sql, $ref->GetNavChange(), $ref->GetAdjustH());
			}
			EchoTableParagraphEnd();
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


<?php
require_once('sqlstocksymbol.php');
require_once('sqlkeytable.php');

// ****************************** FundEstSql class *******************************************************
class FundEstSql extends DailyTimeSql
{
    function FundEstSql() 
    {
        parent::DailyTimeSql(TABLE_FUND_EST);
    }
}

// ****************************** StockSplitSql class *******************************************************
class StockSplitSql extends DailyCloseSql
{
    function StockSplitSql() 
    {
        parent::DailyCloseSql(TABLE_STOCK_SPLIT);
    }
}

// ****************************** SharesHistorySql class *******************************************************
class SharesHistorySql extends DailyCloseSql
{
    function SharesHistorySql() 
    {
        parent::DailyCloseSql('etfshareshistory');
    }
}

// ****************************** SharesDiffSql class *******************************************************
class SharesDiffSql extends DailyCloseSql
{
    function SharesDiffSql() 
    {
        parent::DailyCloseSql('etfsharesdiff');
    }
}

// ****************************** EtfCnhSql class *******************************************************
class EtfCnhSql extends DailyCloseSql
{
    function EtfCnhSql() 
    {
        parent::DailyCloseSql('etfcnh');
    }
}

// ****************************** AnnualIncomeSql class *******************************************************
class AnnualIncomeSql extends DailyStringSql
{
    function AnnualIncomeSql() 
    {
        parent::DailyStringSql('annualincomestr');
    }
}

// ****************************** QuarterIncomeSql class *******************************************************
class QuarterIncomeSql extends DailyStringSql
{
    function QuarterIncomeSql() 
    {
        parent::DailyStringSql('quarterincomestr');
    }
}

?>

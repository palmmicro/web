<?php

function GradedFundGetSymbolArray()
{
    return array('sh502004', 'sz150022', 'sz150152', 'sz150169', 'sz150175', 'sz150181', 'sz150186', 'sz150200', 'sz150205', 'sz150209', 'sz150223', 'sz150277', 'sz150287'); 
}

function GradedFundGetSymbolA($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        return $sym->strPrefixA.strval($sym->iDigitA - 1);
    }
    return $strSymbol;
}

function GradedFundGetSymbolB($strSymbol)
{
    $sym = new StockSymbol($strSymbol);
    if ($sym->IsFundA())
    {
        return $sym->strPrefixA.strval($sym->iDigitA + 1);
    }
    return $strSymbol;
}

function in_arrayGradedFund($strSymbol)
{
    return in_array(strtolower($strSymbol), GradedFundGetSymbolArray());
}

function in_arrayGradedFundB($strSymbol)
{
    $strSymbolA = GradedFundGetSymbolA($strSymbol);
    if (in_arrayGradedFund($strSymbolA))
    {
        return $strSymbolA;
    }
    return false;
}

function GradedFundGetArrayM()
{
    $ar = array('SZ150022' => 'SZ163109',
                  'SZ150152' => 'SZ161022',
                  'SZ150169' => 'SZ164705',
                  'SZ150175' => 'SZ161831',
                  'SZ150181' => 'SZ161024',
                  'SZ150186' => 'SZ163115',
                  'SZ150200' => 'SZ161720',
                  'SZ150205' => 'SZ160630',
                  'SZ150209' => 'SZ161026',
                  'SZ150223' => 'SZ161027',
                  'SZ150277' => 'SZ160639',
                  'SZ150287' => 'SZ168203',
                  'SH502004' => 'SH502003',
                 );
    return $ar;
}

function GradedFundGetSymbolM($strSymbol)
{
    $ar = GradedFundGetArrayM();
    return $ar[$strSymbol];
}

function in_arrayGradedFundM($strSymbol)
{
    $ar = GradedFundGetArrayM();
    if ($strSymbolA = array_search(strtoupper($strSymbol), $ar))
    {
        return $strSymbolA;
    }
    return false;
}

function GradedFundGetIndexSymbol($strSymbol)
{
    $ar = array('SZ150022' => 'SZ399001',
                  'SZ150152' => 'SZ399006',
                  'SZ150169' => '^HSI',
                  'SZ150175' => '^HSCE',
                  'SZ150181' => 'SZ399967',
                  'SZ150186' => 'SZ399967',
                  'SZ150200' => 'SZ399975',
                  'SZ150205' => 'SZ399973',
                  'SZ150209' => 'SZ399974',
                  'SZ150223' => 'SZ399975',
                  'SZ150277' => 'SZ399807',
                  'SZ150287' => 'SZ399440',
                  'SH502004' => 'SZ399967',
                 );
    return $ar[$strSymbol];
}

function GradedFundGetAllSymbolArray($strSymbol)
{
    return array($strSymbol, GradedFundGetSymbolB($strSymbol), GradedFundGetSymbolM($strSymbol), GradedFundGetIndexSymbol($strSymbol));
}

function GradedFundGetInterest($strSymbol)
{
    $fBase = 1.5;
    if ($strSymbol == 'SZ150152' || $strSymbol == 'SZ150175')   $fVal = 3.5;
    else if ($strSymbol == 'SZ150223')   $fVal = 6.0 - $fBase;
    else if ($strSymbol == 'SZ150287')   $fVal = 4.0;
    else                              $fVal = 3.0;
    return ($fBase + $fVal) / 100.0 / 365.0;
}

class MyGradedFundReference extends MyFundReference
{
    var $b_ref = false;
    var $m_ref = false;
    
    // constructor 
    function MyGradedFundReference($strSymbol)
    {
        parent::MyFundReference($strSymbol);
        $this->b_ref = new MyFundReference(GradedFundGetSymbolB($strSymbol));
        $this->m_ref = new MyFundReference(GradedFundGetSymbolM($strSymbol));
        $this->est_ref = new MyStockReference(GradedFundGetIndexSymbol($strSymbol));
        $this->EstNetValue();
    }

    function _isTurningPoint()
    {
        $strSymbol = $this->GetStockSymbol();
        if ($strSymbol == 'SZ150022')
        {
            if ($this->b_ref->fPrevPrice < 0.1)
            {
                return true;
            }
        }
        else if ($strSymbol == 'SZ150175')
        {
            if ($this->b_ref->fPrevPrice < 0.2) 
            {
                return true;
            }
        }
        return false;
    }
    
    function EstNetValue()
    {
        $strDate = $this->est_ref->strDate; 
        if ($strDate == $this->m_ref->strDate)
        {
            $this->fPrice = $this->fPrevPrice;
            $this->b_ref->fPrice = $this->b_ref->fPrevPrice;
            $this->m_ref->fPrice = $this->m_ref->fPrevPrice;
            
            $this->UpdateOfficialNetValue();
            $this->b_ref->UpdateOfficialNetValue();
            $this->m_ref->UpdateOfficialNetValue();
        }
        else
        {
            $this->m_ref->fPrice = $this->m_ref->fPrevPrice * $this->est_ref->fPercentage;
            if ($this->_isTurningPoint())
            {
                $this->b_ref->fPrice = $this->b_ref->fPrevPrice * $this->est_ref->fPercentage;
                $this->fPrice = $this->m_ref->fPrice * 2.0 - $this->b_ref->fPrice;
            }
            else
            {
                $this->fPrice = $this->fPrevPrice + GradedFundGetInterest($this->GetStockSymbol());
                $this->b_ref->fPrice = $this->m_ref->fPrice * 2.0 - $this->fPrice;
            }
            
            $this->UpdateEstNetValue();
            $this->b_ref->UpdateEstNetValue();
            $this->m_ref->UpdateEstNetValue();
        }
        $this->strOfficialDate = $strDate;
        $this->b_ref->strOfficialDate = $strDate;
        $this->m_ref->strOfficialDate = $strDate;

        $this->EstFairNetValue();
    }
    
    function EstFairNetValue()
    {
        if ($this->m_ref->stock_ref->bHasData)
        {
            $fPrice = $this->m_ref->stock_ref->fPrice;
        }
        else
        {
            $fPrice = $this->m_ref->fPrice;
        }
        
        $this->m_ref->fFairNetValue = ($this->stock_ref->fPrice + $this->b_ref->stock_ref->fPrice) / 2.0;
        $this->fFairNetValue = $fPrice * 2.0 - $this->b_ref->stock_ref->fPrice;
        $this->b_ref->fFairNetValue = $fPrice * 2.0 - $this->stock_ref->fPrice;
    }
}

?>

<?php
require_once('imagefile.php');

class DateImageFile extends PageImageFile
{
	var $strText;
	
    public function __construct($strIndex = '1') 
    {
        parent::__construct($strIndex);
        $this->strText = '';
    }
    
    function _textDateVal($str, $strDate, $fVal)
    {
		$this->strText .= $str.'：'.$strDate.' '.GetFontElement(strval_round($fVal, 2), $this->strLineColor).'<br />';
    }
    
    function _textCurDateVal($str, $ar)
    {
    	$this->_textDateVal($str, key($ar), current($ar));
    }
    
    function _textSearchDateVal($str, $ar, $fVal)
    {
    	$this->_textDateVal($str, array_search($fVal, $ar), $fVal);
    }
    
    function Draw($arFocus, $arBase)
    {
    	if (count($arFocus) < 2)		return false;

    	$iCount = count($arBase);
    	if ($iCount < 2)		return false;
    	
    	$this->fMaxX = $iCount;
    	$this->fMaxY = max($arBase);

    	for ($i = 1; $i < 10; $i ++)		$this->DrawAxisY($i * $iCount / 10.0);
    	
    	$arBase = array_reverse($arBase);
    	$this->DrawComparePolyLine($arBase);

    	$arFocus = array_reverse($arFocus);	// ksort($arFocus);
    	reset($arFocus);
    	$this->_textCurDateVal('开始日期', $arFocus);
    	end($arFocus);
    	$this->_textCurDateVal('结束日期', $arFocus);

    	$this->fMaxY = max($arFocus);
		$this->_textSearchDateVal('最大值', $arFocus, $this->fMaxY);
    	if ($this->fMaxY < 0.0)		$this->fMaxY = 0.0;
    	$this->fMinY = min($arFocus);
		$this->_textSearchDateVal('最小值', $arFocus, $this->fMinY);
    	if ($this->fMinY > 0.0)		$this->fMinY = 0.0;
    	$this->DrawAxisX();
    	$this->DrawAxisX(1.0);
    	$this->DrawAxisX(-1.0);

    	$iCur = 0;
    	$bFirst = true;
    	foreach ($arBase as $strDate => $fVal)
    	{
    		if (isset($arFocus[$strDate]))
    		{
    			$x = $this->GetPosX($iCur);
    			$y = $this->GetPosY($arFocus[$strDate]);
    		
    			if ($bFirst == false)
    			{
    				$this->Line($x1, $y1, $x, $y);
    			}
    			$x1 = $x;
    			$y1 = $y;
    			$bFirst = false;
    		}
   			$iCur ++;
    	}
    	
    	return true;
    }

    function GetAll($strName, $strCompare)
    {
    	$str = $this->strText;
    	$str .= GetFontElement($strName, $this->strLineColor).' '.GetFontElement($strCompare, $this->strCompareColor);
    	$str .= '<br />'.$this->GetLink();
    	return $str;
	}
}

?>

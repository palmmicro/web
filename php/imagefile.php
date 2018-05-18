<?php

// ****************************** ImageFile class  *******************************************************
class ImageFile
{
    var $strPathName;
    var $iWidth;
    var $iHeight;
    
    var $iTextHeight;
    
    var $image;
    
    var $textcolor;
    var $linecolor;
    var $pixelcolor;
    
    var $iFont;
    
    function ImageFile($strPathName, $iWidth, $iHeight) 
    {
        $this->strPathName = $strPathName;
        $this->iWidth = $iWidth;
        $this->iHeight = $iHeight;
        
        $this->iTextHeight = 20;
        
        $this->image = imagecreatetruecolor($iWidth, $iHeight);
        $this->iFont = 20;
        $this->textcolor = imagecolorallocate($this->image, 255, 255, 255);
        $this->linecolor = imagecolorallocate($this->image, 255, 0, 0);
        $this->pixelcolor = imagecolorallocate($this->image, 0, 255, 0);
    }
    
    function Text($x, $y, $strText)
    {
        imagestring($this->image, $this->iFont, $x, $y, $strText, $this->textcolor);
    }
    
    function Line($x1, $y1, $x, $y)
    {
    	imageline($this->image, $x1, $y1, $x, $y, $this->linecolor);
    }
    
    function Pixel($x, $y)
    {
    	imagesetpixel($this->image, $x, $y, $this->pixelcolor);
    }
    
    function _textFromDateArray($x, $y, $fVal, $ar)
    {
    	$this->Text($x, $y, strval($fVal).' '.array_search($fVal, $ar));
    }
    
    function DrawDateArray($ar)
    {
    	ksort($ar);
    	reset($ar);
    	$iBottom = $this->iHeight - $this->iTextHeight;
    	$this->Text(0, $iBottom, key($ar));
    	end($ar);
    	$this->Text($this->iWidth - 100, $iBottom, key($ar));
    	
    	$fMax = max($ar);
    	$this->_textFromDateArray(0, 0, $fMax, $ar);
    	$fMin = min($ar);
    	$iBottom -= $this->iTextHeight;
    	$this->_textFromDateArray(0, $iBottom, $fMin, $ar);
    	
//    	reset($ar);
    	$iCount = count($ar);
    	$iCur = 0;
    	foreach ($ar as $strDate => $fVal)
    	{
    		$x = intval($this->iWidth * $iCur / $iCount);
    		$y = intval(($iBottom - $this->iTextHeight) * ($fVal - $fMax) / ($fMin - $fMax)) + $this->iTextHeight;
/*    		if ($iCount > $this->iWidth)
    		{
    			$this->Pixel($x, $y);
    		}
    		else
    		{*/
    			if ($iCur != 0)
    			{
    				$this->Line($x1, $y1, $x, $y);
    			}
    			$x1 = $x;
    			$y1 = $y;
//    		}
    		$iCur ++;
    	}
    }
                                             
    function SaveFile()
    {
//    	unlinkEmptyFile($this->strPathName);
        imagejpeg($this->image, $this->strPathName);  
        imagedestroy($this->image);
    }
    
    function GetPathName()
    {
    	return $this->strPathName;
    }
}

class PageImageFile extends ImageFile
{
    function PageImageFile() 
    {
        parent::ImageFile(DebugGetImageName(UrlGetTitle()), 640, 480);
    }
}

?>

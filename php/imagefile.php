<?php

// ****************************** ImageFile class  *******************************************************
class ImageFile
{
    var $strPathName;
    var $iWidth;
    var $iHeight;
    
    var $image;
    
    var $textcolor;
    var $linecolor;
    
    var $iFont;
    
    function ImageFile($strPathName, $iWidth, $iHeight) 
    {
        $this->strPathName = $strPathName;
        $this->iWidth = $iWidth;
        $this->iHeight = $iHeight;
        
        $this->image = imagecreatetruecolor($iWidth, $iHeight);
        $this->textcolor = imagecolorallocate($this->image, 255, 255, 255);
        $this->linecolor = imagecolorallocate($this->image, 255, 0, 0);
        $this->iFont = 20;
    }
    
    function Text($x, $y, $strText)
    {
        imagestring($this->image, $this->iFont, $x, $y, $strText, $this->textcolor);
    }
    
    function Line($x1, $y1, $x2, $y2)
    {
    	imageline($this->image, $x1, $y1, $x2, $y2, $this->linecolor);
    }
    
    function DrawDateArray($ar)
    {
    	ksort($ar);
    	reset($ar);
    	$this->Text(0, $this->iHeight - 20, key($ar));
    	end($ar);
    	$this->Text($this->iWidth - 100, $this->iHeight - 20, key($ar));
    	
    	$fMax = max($ar);
    	$this->Text(0, 0, strval($fMax).' '.array_search($fMax, $ar));
    	$fMin = min($ar);
    	$this->Text(0, $this->iHeight - 40, strval($fMin).' '.array_search($fMin, $ar));
    	
    	reset($ar);
    	$iCount = count($ar);
    	$iCur = 0;
    	foreach ($ar as $strDate => $fVal)
    	{
    		$x2 = intval($this->iWidth * $iCur / $iCount);
    		$y2 = intval(($this->iHeight - 60) * ($fVal - $fMax) / ($fMin - $fMax) + 20);
    		if ($iCur != 0)
    		{
    			$this->Line($x1, $y1, $x2, $y2);
    		}
    		$iCur ++;
    		$x1 = $x2;
    		$y1 = $y2;
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

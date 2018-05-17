<?php

// ****************************** ImageFile class  *******************************************************
class ImageFile
{
    var $strPathName;
    var $iWidth;
    var $iHeight;
    
    var $image;
    var $textcolor;
                     
    function ImageFile($strPathName, $iWidth, $iHeight) 
    {
        $this->strPathName = $strPathName;
        $this->iWidth = $iWidth;
        $this->iHeight = $iHeight;
        
        $this->image = imagecreatetruecolor($iWidth, $iHeight);
        $this->textcolor = imagecolorallocate($this->image, 255, 255, 255);
    }
    
    function Text($iFont, $x, $y, $strText)
    {
        imagestring($this->image, $iFont, $x, $y, $strText, $this->textcolor);
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

<?php
require_once('_woody.php');

function _getPhotoDir()
{
	global $acct;
	
	$strDate = $acct->GetQuery();
	if (IsDigitDate($strDate))
	{
		$strDir = 'image/'.$strDate;
		if (is_dir($strDir))		return $strDir;
	}
	return false;
}
	
function _getPhotoDirYmd($bChinese)
{
	if ($strDir = _getPhotoDir())		return GetBlogYmd(substr($strDir, -8, 8), $bChinese);
	return $bChinese ? '未知' : 'Unknown';
}

function GetTitle($bChinese)
{
	return _getPhotoDirYmd($bChinese).($bChinese ? '相片' : ' Photos');
}

function GetMetaDescription($bChinese)
{
	$str = _getPhotoDirYmd($bChinese).($bChinese ? '相片全部显示页面，按文件名a-z排序。每张相片都根据刚好满屏显示调整了大小，未调整文件在原图链接中。' : ' photos all display page, each photo is adjusted to the screen display size');
	return CheckMetaDescription($str);
}

function EchoAll($bChinese)
{
	$str = '';
	if ($strDir = _getPhotoDir())
	{
		$strSuffix = GetImgAutoSuffix();
		$iLen = strlen($strSuffix);
		
		// Get all files and directories in the specified directory
		$arFiles = scandir($strDir);

		// Iterate through the files and exclude directories
		foreach ($arFiles as $strFile) 
		{    // Exclude current directory (".") and parent directory ("..")
			if ($strFile !== '.' && $strFile !== '..' && substr($strFile, -$iLen, $iLen) !== $strSuffix) 
			{	// Check if the entry is a file
				$strPathName = $strDir.'/'.$strFile;
				if (is_file($strPathName)) 
				{	// Process the file
					$str .= GetHtmlElement(ImgAutoQuote($strPathName, '', $bChinese));
				}
			}
		}
	}
	
    echo <<<END

$str
END;
}

?>

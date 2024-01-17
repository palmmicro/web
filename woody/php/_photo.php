<?php
require_once('_woody.php');

function _getPhotoDir()
{
	global $acct;
	
	$strDate = $acct->GetQuery();
	if (IsDigitDate($strDate))
	{
//		$strDir = UrlGetRootDir().'woody/image/'.$strDate;
		$strDir = 'image/'.$strDate;
		if (is_dir($strDir))		return $strDir;
	}
	return false;
}
	
function _getPhotoDirYmd($bChinese)
{
	if ($strDir = _getPhotoDir())		return GetBlogYmd(substr($strDir, -8, 8), $bChinese);
	return false;
}

function GetTitle($bChinese)
{
	$strDate = _getPhotoDirYmd($bChinese);
	if ($strDate == false)	$strDate = $bChinese ? '未知' : 'Unknown';
	return $strDate.($bChinese ? '相片' : ' Photos');
}

function GetMetaDescription($bChinese)
{
	if ($strDate = _getPhotoDirYmd($bChinese))	$str = $strDate.($bChinese ? '相片全部显示页面，按文件名排序。每张相片都根据刚好满屏显示调整了大小，未调整文件在原图链接中。' : ' photoes all display page, each photo is adjusted to the screen display size');
	else											$str = $bChinese ? '无法显示的未知相片' : 'Can not display unknown photos';
	return CheckMetaDescription($str);
}

function EchoAll($bChinese)
{
	$str = '';
	if ($strDir = _getPhotoDir())
	{
		// Get all files and directories in the specified directory
		$arFiles = scandir($strDir);

		// Iterate through the files and exclude directories
		foreach ($arFiles as $strFile) 
		{    // Exclude current directory (".") and parent directory ("..")
			if ($strFile !== '.' && $strFile !== '..' && substr($strFile, -6, 6) !== '__.jpg') 
			{	// Check if the entry is a file
				$strPathName = $strDir.'/'.$strFile;
				if (is_file($strPathName)) 
				{	// Process the file
					$str .= GetHtmlElement(ImgAutoQuote($strPathName, '', '', $bChinese));
				}
			}
		}
	}
	
    echo <<<END

$str
END;
}

?>

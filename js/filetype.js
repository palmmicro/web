// File functions

var _strHtml = ".html";
var _strCnHtml = "cn.html";

var _strPhp = ".php";
var _strCnPhp = "cn.php";

function FileTypeHtml()
{
	return _strHtml;
}

function FileTypeCnHtml()
{
	return _strCnHtml;
}

function FileTypePhp()
{
	return _strPhp;
}

function FileTypeCnPhp()
{
	return _strCnPhp;
}

function FileGetCurType()
{
    var strType;
    var str = window.location.pathname;
    
    if (str.indexOf(_strCnHtml) != -1)
    {
        strType = _strCnHtml;    
    }
    else if (str.indexOf(_strCnPhp) != -1)
    {
        strType = _strCnPhp;
    }
    else if (str.indexOf(_strPhp) != -1)
    {
        strType = _strPhp;
    }
    else
    {
        strType = _strHtml;
    }
    return strType;
}

function FileTypeIsEnglish(strType)
{
    if (strType == _strHtml || strType == _strPhp)  return true;
    return false;
}

function FileIsEnglish()
{
	return FileTypeIsEnglish(FileGetCurType());
}

function FileGetCurTitle(strType)
{
    var str = window.location.pathname;
    var strCur;
    var iPos;
    var iPos2;
    
    iPos = str.lastIndexOf("/");
    iPos2 = str.indexOf(strType);
    
    if (iPos != -1 && iPos2 != -1)
    {
        strCur = str.substring(iPos + 1, iPos2);    
    }
    else
    {
        strCur = "index";
    }
    return strCur;
}

function FileSwitchLanguage()
{
    var strType = FileGetCurType();
    var strCur = FileGetCurTitle(strType);
    
    if (FileTypeIsEnglish(strType))
    {
    	if (strType == _strHtml)	strCur += _strCnHtml;
    	if (strType == _strPhp)	strCur += _strCnPhp;
    }
    else
    {
    	if (strType == _strCnHtml)	strCur += _strHtml;
    	if (strType == _strCnPhp)	strCur += _strPhp;
    }
    
    return strCur;
}


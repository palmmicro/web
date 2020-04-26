// CopyRight functions

var _strCopyRightBegin = "<table><tr><td><small>";
var _strCopyRightEnd = "</small></td></tr></table>";

function _BuildCopyRight(strCopyRight)
{
	return _strCopyRightBegin + strCopyRight + _strCopyRightEnd;
}

function CopyRightDisplay()
{
    var str;
    
    if (FileIsEnglish())
    {
        str = _BuildCopyRight("Copyright &copy; 2006-2020 Palmmicro Communications Inc. All Rights Reserved.");
    }
    else
    {
        str = _BuildCopyRight("2006-2020 深圳迪迈特版权所有&copy;, 保留所有权利.");
    }
   	document.write(str);
}

function CopyRightDisplayWoody()
{
    var str;
    
    if (FileIsEnglish())
    {
        str = _BuildCopyRight("Copyright &copy; 1973-2020 Woody. All Rights Reserved.");
    }
    else
    {
        str = _BuildCopyRight("1973-2020 林蓉榕版权所有&copy;, 保留所有权利.");
    }
   	document.write(str);
}


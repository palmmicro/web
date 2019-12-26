var _arPa3288s = new Array("20130831"); 
var _iTotalPa3288s = 1;

function NavigatePa3288()
{
    var iLevel = 2;
    
	NavBegin();
	WoodyMenuItem(iLevel, "index");
	NavContinueNewLine();
	BlogMenuItem(iLevel - 1, "pa3288");
	NavContinueNewLine();
    NavDirFirstLast(_iTotalPa3288s, _arPa3288s);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}


var _arPa1688s = new Array("20070607", "20080806", "20091215", "20100606", "20100907", "20110225", "20110420", "20110427", "20110814", "20111104", "20111113", "20120210", "20130210", "20140405"); 
var _iTotalPa1688s = 14;

function NavigatePa1688()
{
    var iLevel = 2;
    
	NavBegin();
	WoodyMenuItem(iLevel, "index");
	NavContinueNewLine();
	BlogMenuItem(iLevel - 1, "pa1688");
	NavContinueNewLine();
    NavDirFirstLast(_iTotalPa1688s, _arPa1688s);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}

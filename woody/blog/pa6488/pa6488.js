var _arPa6488s = new Array("20090808", "20090811", "20090816", "20090819", "20090825", "20090901", "20090927", "20100109", "20100211", "20101213", "20101225", "20110411", "20110516", "20110524", "20111120"); 
var _iTotalPa6488s = 15;

function NavigatePa6488()
{
    var iLevel = 2;
    
	NavBegin();
	WoodyMenuItem(iLevel, "blog");
	NavContinueNewLine();
	BlogMenuItem(iLevel - 1, "pa6488");
	NavContinueNewLine();
    NavDirFirstLast(_iTotalPa6488s, _arPa6488s);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}


var _arEntertainments = new Array("20070722", "20070813", "20090219", "20090303", "20100529", "20100726", "20100905", "20101107", "20110323", "20110509", "20110608", "20111112", "20120329", "20120719", "20120811", "20140615", "20141016", "20141204", "20150818", "20151225", "20160101", "20160615", "20161020", "20170305", "20170309"); 
var _iTotalEntertainments = 25;

function NavigateEntertainment()
{
    var iLevel = 2;
    
	NavBegin();
	WoodyMenuItem(iLevel, "blog");
	NavContinueNewLine();
	BlogMenuItem(iLevel - 1, "entertainment");
	NavContinueNewLine();
    NavDirFirstLast(_iTotalEntertainments, _arEntertainments);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}


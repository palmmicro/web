var _arMyPhotos = new Array("photo2006", "photo2007", "photo2008", "photo2009", "photo2010", "photo2011", "photo2012", "photo2014", "photo2015"); 
var _iTotalMyPhotos = 9;

function NavigateMyPhoto()
{
    var iLevel = 1;
    
	NavBegin();
	WoodyMenuItem(iLevel, "image");
	NavContinueNewLine();
    NavDirFirstLast(_iTotalMyPhotos, _arMyPhotos);
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}

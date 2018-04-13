function ResMenu(iTotal, arLoops)
{
    var iLevel = 0;
    
	NavBegin();
	NavMenu0(iLevel + 1);
    NavContinue();
	NavMenu1(iLevel, "res");
	if (iTotal)
	{
		NavContinueNewLine();
		NavDirLoop(iTotal, arLoops);
	}
	NavContinueNewLine();
    NavSwitchLanguage(iLevel + 1);
    NavEnd();
}


var _arImages = new Array("20030111", "20081024"); 
var _iTotalImages = 2;

function NavLoopImage()
{
    ResMenu(_iTotalImages, _arImages);
}


var _arServices = new Array("sip2sip", "sipphone", "voipdiscount", "voiptalk"); 
var _iTotalServices = 4;

function NavLoopService()
{
    ResMenu(_iTotalServices, _arServices);
}


var _arWebs = new Array("translation", "format"); 
var _iTotalWebs = 2;

function NavLoopWeb()
{
    ResMenu(_iTotalWebs, _arWebs);
}

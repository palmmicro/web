var _arCamMans = new Array("quickstart", "viewer", "camera", "rawdata", "theend"); 
var _iTotalCamMans = 5;

function NavigateCamMan()
{
	NavBegin();
	NavMenu0(3);
    NavContinue();
	NavMenu1(2, "pa6488");
	NavContinueNewLine();
	Pa6488MenuItem(2, "software");
	NavContinueNewLine();
	SoftwareMenuItem(1, "camman");
	NavContinueNewLine();
	NavDirFirstLast(_iTotalCamMans, _arCamMans);
	NavContinueNewLine();
    NavSwitchLanguage(3);
    NavEnd();
}

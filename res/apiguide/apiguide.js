var _arApiGuides = new Array("datatype", "list"); 
var _iTotalApiGuides = 2;

function NavigateApiGuide()
{
	NavBegin();
	NavMenu0(2);
    NavContinue();
	NavMenu1(1, "res");
	NavContinueNewLine();
    if (FileIsEnglish())
    {
       	NavWriteItemLink(1, "apiguide", FileTypePhp(), "API Guide");
    }
    else
    {
       	NavWriteItemLink(1, "apiguide", FileTypeCnPhp(), "开发指南");
    }
	NavContinueNewLine();
    NavDirFirstLast(_iTotalApiGuides, _arApiGuides);
	NavContinueNewLine();
    NavSwitchLanguage(2);
    NavEnd();
}

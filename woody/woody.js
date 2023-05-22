var _iTotalMenu0 = 3;
var _arMenu0 = new Array("index", "image", "blog"); 
var _arMenu0Names = new Array("Resource", "Image", "Blog"); 
var _arMenu0CnNames = new Array("资源共享", "相片", "网络日志"); 

function WoodyMenu()
{
	NavBegin();
    NavMenuSet(_iTotalMenu0, _arMenu0, _arMenu0Names, _arMenu0CnNames);
	NavContinueNewLine();
    NavSwitchLanguage(1);
    NavEnd();
}
              
function WoodyMenuItem(iLevel, strItem)
{
	var i;
	
    for (i = 0; i < _iTotalMenu0; i ++)
    {
        if (strItem == _arMenu0[i])
        {
            if (FileIsEnglish())
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeHtml(), _arMenu0Names[i]);
            }
            else
            {
            	NavWriteItemLink(iLevel, strItem, FileTypeCnHtml(), _arMenu0CnNames[i]);
            }
        	break;
        }
    }
}

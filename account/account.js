var _iTotalMenus = 3;
var _arMenus = new Array("login", "profile", "closeaccount"); 
var _arNames = new Array("Login", "Profile", "Close Account"); 
var _arCnNames = new Array("登录", "资料", "关闭账号"); 

function AccountMenu()
{
	NavBegin();
	NavMenu0(1);
    NavContinue();
	NavMenu1(0, "account");
	NavContinueNewLine();
    NavMenuSet(_iTotalMenus, _arMenus, _arNames, _arCnNames);
	NavContinueNewLine();
    NavSwitchLanguage(1);
    NavEnd();
}

<?php
require_once('../php/layout.php');
require_once('../php/visitorlogin.php');
require_once('../php/_palmmicromenu.php');

function _getAccountMenuArray($bChinese)
{
    if ($bChinese)
    {
        return array('login' => '登录',
                      'profile' => '资料',
                     );
    }
    else
    {
         return array('login' => 'Login',
                      'profile' => 'Profile',
                     );
    }
}

function AccountMenu($bChinese)
{
	MenuBegin();
	PalmmicroMenu('account', $bChinese);
	MenuContinueNewLine();
    MenuSet(_getAccountMenuArray($bChinese));
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('AccountMenu', true, $bChinese, $bAdsense);
}

function _LayoutBottom($bChinese = true, $bAdsense = true)
{
    VisitorLogin($bChinese);
    LayoutTail($bChinese, $bAdsense);
}

?>

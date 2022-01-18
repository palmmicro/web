<?php
require_once('/php/layout.php');
require_once('/php/_navpalmmicro.php');

function _getMenuArray($bChinese)
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
	NavMenu1('account', $bChinese);
	MenuContinueNewLine();
    MenuSet(_getMenuArray($bChinese));
	MenuContinueNewLine();
    MenuSwitchLanguage($bChinese);
    MenuEnd();
}

function _LayoutTopLeft($bChinese = true, $bAdsense = true)
{
    LayoutTopLeft('AccountMenu', true, $bChinese, $bAdsense);
}

?>

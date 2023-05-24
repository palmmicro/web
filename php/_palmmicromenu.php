<?php
// Provide enhanced function replacement of ../palmmicro.js

function _getPalmmicroMenuArray($bChinese)
{
    if ($bChinese)
    {
		return array('contactus' => '联系我们',
                       'pa6488' => 'PA6488',
                       'pa3288' => 'PA3288',
                       'ar1688' => 'AR1688',
                       'pa1688' => 'PA1688',
                       'res' => '资源共享',
                       'blank' => '',
                       'account' => '我的帐号');
    }
    else
    {
		return array('contactus' => 'Contact us',
                       'pa6488' => 'PA6488',
                       'pa3288' => 'PA3288',
                       'ar1688' => 'AR1688',
                       'pa1688' => 'PA1688',
                       'res' => 'Resource',
                       'blank' => '',
                       'account' => 'My Account');
    }
}

// <A class=A2 HREF="/ar1688/index.html">AR1688</A>
// <A class=A2 HREF="/ar1688/indexcn.html">AR1688</A>
function PalmmicroMenu($strItem, $bChinese)
{
    $arMenu = _getPalmmicroMenuArray($bChinese);
    $strCn = $bChinese ? 'cn' : '';
    echo MenuGetLink("/$strItem/index{$strCn}.html", $arMenu[$strItem]);
}

?>

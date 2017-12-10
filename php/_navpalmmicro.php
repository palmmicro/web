<?php
// Provide enhanced function replacement of ../palmmicro.js
require_once('nav.php');

//<TR><TD><A class=A2 HREF="/ar1688/index.html">AR1688</A></TD></TR>
//<TR><TD><A class=A2 HREF="/ar1688/indexcn.html">AR1688</A></TD></TR>
function NavMenu1($strMenu1, $bChinese)
{
    $arMenu1 = array(       'aboutus',  'pa6488', 'pa3288', 'ar1688', 'pa1688', 'res',        '', 'account',    'contactus'); 
    $arMenu1Names = array(  'About us', 'PA6488', 'PA3288', 'AR1688', 'PA1688', 'Resources',  '', 'My Account', 'Contact us'); 
    $arMenu1CnNames = array('关于我们', 'PA6488', 'PA3288', 'AR1688', 'PA1688', '资源共享',   '', '我的帐号',   '联系方式');
    
   	for ($i = 0; $i < count($arMenu1); $i ++)
   	{
   		if ($strMenu1 == $arMenu1[$i])
   		{
			if ($bChinese)
			{
//			    echo $arMenu1CnNames[$i];
			    echo "<A class=A2 HREF=\"/$strMenu1/indexcn.html\">{$arMenu1CnNames[$i]}</A>";
			}
			else
			{
//			    echo $arMenu1Names[$i];
			    echo "<A class=A2 HREF=\"/$strMenu1/index.html\">{$arMenu1Names[$i]}</A>";
			}
   			break;
   		}
   	}
}

?>

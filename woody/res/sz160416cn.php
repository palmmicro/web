<?php 
require('php/_lof.php');

function GetLofRelated($sym)
{
 	$str = '<b>注意IXC和SZ160416跟踪的指数其实不同, 只是成分相似, 此处估算结果仅供参考.</b></p>
	<p><font color=red>已知问题:</font></p>
	<ol>
	    <li>2016年12月22日星期四, IXC股息除权, 导致23日全天估值不正常. 这个问题会涉及到所有没有参考指数数据, 而只能使用ETF估值的LOF.</li>
    </ol>
    <p>';
	$str .= GetHuaAnOfficialLink($sym->GetDigitA());
	$str .= ' '.GetOfficialLinkIXC();
	$str .= ' <a href="https://us.spindices.com/indices/equity/sp-global-oil-index" target=_blank>SPGOGUP官网</a>';
	$str .= ' '.GetLofLinks($sym);
	$str .= GetOilSoftwareLinks();
	$str .= GetCommoditySoftwareLinks();
	$str .= GetHuaAnSoftwareLinks();
	return $str;
}

require('/php/ui/_dispcn.php');
?>

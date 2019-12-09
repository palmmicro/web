<?php
require_once('_commonupdatestock.php');

/*gz
<li><a href="/bonddetail/2/010303.shtml">03国债⑶ 010303</a></li>
<li><a href="/bonddetail/1/109982.shtml">云南16Z4 109982</a></li>
qz
<li><a href="/bonddetail/2/120303.shtml">03三峡债 120303</a></li>
<li><a href="/bonddetail/1/114302.shtml">18华谊01 114302</a></li>
kzz
<tr>
                    <td><a href="http://bond.jrj.com.cn/bonddetail/2/113028.shtml" class="blueColor">113028</a></td>
                    <td><a href="http://bond.jrj.com.cn/bonddetail/2/113028.shtml" class="blueColor">环境转债</a></td>
                                        <td>21.70</td>
                                        <td  title="2019-06-18">06-18(周二)</td>
                    <td>783200</td>
                    <td>10000</td>
                    <td>0.0306%</td>
                    <td class="detail">
                    详情
                        <div>
                        	末“4”位数 7881, 2881, 1985<br />末“6”位数 345380, 545380, 745380, 945380, 145380<br />末“7”位数 9621520, 7621520, 5621520, 3621520, 1621520, 8955064<br />末“9”位数 308777205, 346822690
                        </div>                    </td>
                    <td>764200</td>
                    <td>56.57%</td>
                    <td>2019-07-08</td>
                    <td>10.44</td>
                    <td><a href="http://stock.jrj.com.cn/share,601200.shtml" class="blueColor">上海环境</a></td>
                </tr>
*/

function _updateChinaBond()
{
    $strType = UrlGetQueryValue('type');
    $strUrl = GetJrjBondListUrl($strType);
    $str = url_get_contents($strUrl);
    $str = FromGB2312ToUTF8($str);
//	DebugString($str);

    $strBoundary = RegExpBoundary();
    $strPattern = $strBoundary;
    if ($strType == 'kzz')
    {
	}
	else
	{
		$strPattern .= RegExpParenthesis('<li><a href="/bonddetail/', '[^.]*', '.');
		$strPattern .= RegExpParenthesis('shtml">', '[^<]*', '</a></li>');
	}
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateChinaBond');
    $iCount = 0;
	$sql = new StockSql();
   	foreach ($arMatch as $arItem)
   	{
   		$ar = explode('/', $arItem[1]);
   		$strFirst = $ar[0];
   		if ($strFirst == '1')				$strPrefix = SZ_PREFIX;
   		else if ($strFirst == '2')		$strPrefix = SH_PREFIX;
   		else								continue;
   		
   		$strDigit = $ar[1];
   		if (IsChineseStockDigit($strDigit))
   		{
   			$ar = explode(' ', $arItem[2]);
   			if ($strDigit == $ar[1])
   			{
   				$strName = $ar[0];
   				$strSymbol = $strPrefix.$strDigit;
   				if ($sql->WriteSymbol($strSymbol, $strName))
   				{
   					DebugString($strSymbol.' '.$strName);
   					$iCount ++;
   				}
   			}
   		}
   		else
   		{
   			DebugString($arItem[0]);
   		}
   	}
    DebugVal($iCount, 'updated');
}
	
	AcctAdminCommand('_updateChinaBond');

?>

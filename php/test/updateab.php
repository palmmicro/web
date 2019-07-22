<?php
require_once('_commonupdatestock.php');

/*sh
          <tr>	   
	    <td> 1</td>
	    	<td> <a href="http://irm.cnstock.com/company/index/600851" target="_blank">600851</a></td>
            <td> <a href="http://irm.cnstock.com/company/index/600851" target="_blank">海欣股份</a></td>
              <td  class="green" >  7.15 </td>
              <td  class="green" > -0.84 </td>
            <td> 900917 </td>
            <td> 海欣Ｂ股 </td>
            <td class="green" > 0.42 </td>
            <td class="green" > -1.19</td>
            <td> 2.5 </td>
            <td> 149.78 </td>
          </tr>            
sz
            <td> <a href="http://irm.cnstock.com/company/index/001872" target="_blank">001872</a></td>
            <td> <a href="http://irm.cnstock.com/company/index/001872" target="_blank">招商港口</a></td>
              <td  class="green" >  17.98 </td>
              <td  class="green" > -2.13 </td>
            <td> 201872 </td>
            <td> 招 港 Ｂ </td>
            <td class="green" > 9.76 </td>
            <td class="green" > -0.92</td>
            <td> 0.27 </td>
            <td> -73.1 </td>
*/

function _updateAb()
{
    $strType = UrlGetQueryValue('type');
    $strUrl = GetCnstocksUrl($strType);
    $str = url_get_contents($strUrl);

    $strPrefix = ($strType == 'sh') ? SH_PREFIX : SZ_PREFIX;
    
    $strBoundary = RegExpBoundary();
    $strSpace = RegExpSpace();
    $strDigit = RegExpDigit();
    
    $strPattern = $strBoundary;
	$strPattern .= '<td>'.$strSpace.$strDigit.'</td>'.$strSpace;
	$strPattern .= RegExpParenthesis('<td>'.$strSpace.RegExpSkip('<a href=[^>]*>'), $strDigit, '</a></td>').$strSpace;
	$strPattern .= RegExpParenthesis('<td>'.$strSpace.RegExpSkip('<a href=[^>]*>'), '[^<]*', '</a></td>').$strSpace;
	$strPattern .= RegExpSkip('<td[^<]*</td>').$strSpace;
	$strPattern .= RegExpSkip('<td[^<]*</td>').$strSpace;
	$strPattern .= RegExpParenthesis('<td>'.$strSpace, $strDigit, $strSpace.'</td>');
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    DebugVal(count($arMatch), '_updateAb');
    $iCount = 0;
	$ab_sql = new AbPairSql();
   	foreach ($arMatch as $arItem)
   	{
   		$strSymbolA = $strPrefix.$arItem[1];
   		$strSymbolB = $strPrefix.$arItem[3];
   		if ($ab_sql->WriteSymbol($strSymbolA, $strSymbolB))
   		{
   			DebugString($strSymbolA.' '.$strSymbolB.' '.$arItem[2]);
   			$iCount ++;
   		}
   	}
    DebugVal($iCount, 'updated');
}
	
	AcctAdminCommand('_updateAb');

?>

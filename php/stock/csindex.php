<?php

/* <h2 class="t_3 mb-10 pr">十大权重股<p class="more">截止日期:2021-07-08</p></h2>
				<table class="table table-even table-bg p_table tc">
					<thead>
						<tr>
							<th>代码</th>
							<th>简称</th>
							<th>行业</th>
							<th>权重</th>
						</tr>
					</thead>
					<tbody>
											<tr>
							<td>700</td>
							<td>腾讯控股</td>
							<td>信息技术</td>
							<td>27.27</td>
						</tr>
											<tr>
							<td>BABA</td>
							<td>阿里巴巴</td>
							<td>信息技术</td>
							<td>25.90</td>
						</tr>
											<tr>
							<td>3690</td>
							<td>美团-W</td>
							<td>可选消费</td>
							<td>12.58</td>
						</tr>
											<tr>
							<td>PDD</td>
							<td>拼多多</td>
							<td></td>
							<td>4.07</td>
						</tr>
											<tr>
							<td>JD</td>
							<td>京东商城</td>
							<td>可选消费</td>
							<td>3.98</td>
						</tr>
											<tr>
							<td>1810</td>
							<td>小米集团-W</td>
							<td>电信业务</td>
							<td>3.92</td>
						</tr>
											<tr>
							<td>BIDU</td>
							<td>百度</td>
							<td>信息技术</td>
							<td>3.72</td>
						</tr>
											<tr>
							<td>NTES</td>
							<td>网易</td>
							<td>信息技术</td>
							<td>2.53</td>
						</tr>
											<tr>
							<td>1024</td>
							<td>快手-W</td>
							<td>信息技术</td>
							<td>2.05</td>
						</tr>
											<tr>
							<td>BILI</td>
							<td>哔哩哔哩</td>
							<td></td>
							<td>1.38</td>
						</tr>
										</tbody>
				</table>*/

function _preg_match_csindex_data($str)
{
	$iCount = 4 * 10;
    $strBoundary = RegExpBoundary();
    $strAll = RegExpAll();
        
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('十大权重股<p class="more">截止日期:', RegExpDate(), '</p>');
/*    for ($i = 0; $i < $iCount; $i ++)
    {
    	$strPattern .= RegExpParenthesis($strAll.'<td>', '[^<]*', '</td>');
    }*/
    $strPattern .= $strBoundary;
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    if (RegExpDebug($arMatch) == 0)	return false;
    return $arMatch;
}
				
function CsindexGetData($strSymbol = 'H30533')
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$strFileName = DebugGetSymbolFile('csindex', $strSymbol);
//	if (StockNeedFile($strFileName, SECONDS_IN_HOUR) == false)		return;   		// update on every hour

//	$strUrl = GetCsindexUrl($strSymbol);
//	$strUrl = 'http://www.csindex.com.cn/en/indices/index-detail/'.$strSymbol;
	$strUrl = 'http://www.csindex.com.cn/uploads/file/autofile/closeweight/H11136closeweight.xls?t=1625908087';

   	if ($str = url_get_contents($strUrl))
    {
   		file_put_contents($strFileName, $str);
   		DebugString($str);
//   		_preg_match_csindex_data($str);
   	}
}

?>

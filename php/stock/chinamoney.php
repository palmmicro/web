<?php
// 

function _chinaMoneyHasFile($strFileName)
{
	clearstatcache(true, $strFileName);
    if (file_exists($strFileName))
    {
        $str = file_get_contents($strFileName);
        $iCurTime = time();
        if ($iCurTime < (filemtime($strFileName) + SECONDS_IN_MIN))	return $str;   // update on every minute
        
        $ar = json_decode($str, true);
        $arHead = $ar['head'];
        if ($arHead['rep_code'] != '200')		return false;;	// 200 ok not found
        
        $arData = $ar['data'];
        $ymd = new YMDTick(strtotime($arData['lastDate']));	// 2018-04-12 9:15
//        DebugString($ymd->GetYMD());
//        DebugString(strval($ymd->GetHour()));
//        DebugString(strval($ymd->GetMinute()));
        if ($ymd->GetNextTradingDayTick() <= $iCurTime)	return false;	// need update

//        DebugString('Use current file');
        return $str;
    }
    return false;
}

define ('CHINA_MONEY_URL', 'http://www.chinamoney.com.cn/r/cms/www/chinamoney/data/fx/ccpr.json');
function GetChinaMoney()
{
    date_default_timezone_set(STOCK_TIME_ZONE_CN);
	$strFileName = DebugGetChinaMoneyFile();
	$str = _chinaMoneyHasFile($strFileName);
    if ($str == false)
    {
    	if ($str = url_get_contents(CHINA_MONEY_URL))
    	{
    		DebugString('Save new file');
    		file_put_contents($strFileName, $str);
    	}
    	else
    	{
    		DebugString('No data!');
    		return;
    	}
    }
	
    $ar = json_decode($str, true);
    $arData = $ar['data'];
    $ymd = new YMDTick(strtotime($arData['lastDate']));	// 2018-04-12 9:15
    $strDate = $ymd->GetYMD();
//    DebugString($strDate);
    if (SqlGetForexHistory(SqlGetStockId('USCNY'), $strDate))
    {
//    	DebugString('Database entry existed');
    	return;
    }

    $arRecord = $ar['records'];
    foreach ($arRecord as $arPair)
    {
    	$strPair = $arPair['vrtEName'];
    	$strPrice = $arPair['price'];
    	DebugString($strPair.' '.$strPrice);
    	if ($strPair == 'USD/CNY')
    	{
    		DebugString('Insert USCNY');
			SqlInsertForexHistory(SqlGetStockId('USCNY'), $strDate, $strPrice);
		}
    	else if ($strPair == 'HKD/CNY')
    	{
    		DebugString('Insert HKCNY');
			SqlInsertForexHistory(SqlGetStockId('HKCNY'), $strDate, $strPrice);
		}
    }
}

// http://www.chinamoney.com.cn/r/cms/www/chinamoney/html/cn/latestRMBParityCn.html
/*
<body class="bg"><div style="width:330px;">
	<div id="title-tab101">
		<div class="fleft"><h2><a href="javascript:go('/fe/Channel/17383');">人民币汇率中间价</a></h2></div><div class="fright">2017-12-19 9:15&nbsp;&nbsp;</div>
	</div>
	<!-- 默认展示9条记录-->	
	<div id="list1" style="height:208px;overflow: auto;overflow-x: hidden;position:relative">
	    		<ul class="row1" onclick="changeChart('USD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_USD"></div></li>
	      			<li class="mtxt">美元/人民币</li>
	      			<li class="num">6.6098</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">64.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('EUR')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_EUR"></div></li>
	      			<li class="mtxt">欧元/人民币</li>
	      			<li class="num">7.7880</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">173.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('JPY')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_JPY"></div></li>
	      			<li class="mtxt">100日元/人民币</li>
	      			<li class="num">5.8725</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">12.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('HKD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_HKD"></div></li>
	      			<li class="mtxt">港元/人民币</li>
	      			<li class="num">0.84559</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">13.20</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('GBP')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_GBP"></div></li>
	      			<li class="mtxt">英镑/人民币</li>
	      			<li class="num">8.8443</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">334.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('AUD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_AUD"></div></li>
	      			<li class="mtxt">澳元/人民币</li>
	      			<li class="num">5.0663</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">68.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('NZD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_NZD"></div></li>
	      			<li class="mtxt">新西兰元/人民币</li>
	      			<li class="num">4.6242</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">71.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('SGD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_SGD"></div></li>
	      			<li class="mtxt">新加坡元/人民币</li>
	      			<li class="num">4.9032</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">2.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('CHF')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_CHF"></div></li>
	      			<li class="mtxt">瑞士法郎/人民币</li>
	      			<li class="num">6.7060</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">296.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('CAD')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_CAD"></div></li>
	      			<li class="mtxt">加元/人民币</li>
	      			<li class="num">5.1369</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">34.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('MYR')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_MYR"></div></li>
	      			<li class="mtxt">人民币/马来西亚林吉特</li>
	      			<li class="num">0.61752</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">7.20</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('RUB')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_RUB"></div></li>
	      			<li class="mtxt">人民币/俄罗斯卢布</li>
	      			<li class="num">8.8750</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">181.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('ZAR')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_ZAR"></div></li>
	      			<li class="mtxt">人民币/南非兰特</li>
	      			<li class="num">1.9258</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">524.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('KRW')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_KRW"></div></li>
	      			<li class="mtxt">人民币/韩元</li>
	      			<li class="num">164.47</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">22.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('AED')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_AED"></div></li>
	      			<li class="mtxt">人民币/阿联酋迪拉姆</li>
	      			<li class="num">0.55568</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">5.30</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('SAR')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_SAR"></div></li>
	      			<li class="mtxt">人民币/沙特里亚尔</li>
	      			<li class="num">0.56741</li>
	      	  				<li><em><div class="Pic_Up"></div></em></li>
	      	  				<li><span class="red">5.60</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('HUF')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_HUF"></div></li>
	      			<li class="mtxt">人民币/匈牙利福林</li>
	      			<li class="num">40.2272</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">1866.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('PLN')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_PLN"></div></li>
	      			<li class="mtxt">人民币/波兰兹罗提</li>
	      			<li class="num">0.54006</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">18.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('DKK')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_DKK"></div></li>
	      			<li class="mtxt">人民币/丹麦克朗</li>
	      			<li class="num">0.9557</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">22.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('SEK')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_SEK"></div></li>
	      			<li class="mtxt">人民币/瑞典克朗</li>
	      			<li class="num">1.2763</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">97.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('NOK')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_NOK"></div></li>
	      			<li class="mtxt">人民币/挪威克朗</li>
	      			<li class="num">1.2648</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">31.00</span></li>
					</a>
	    		</ul>
	    		<ul class="row2" onclick="changeChart('TRY')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_TRY"></div></li>
	      			<li class="mtxt">人民币/土耳其里拉</li>
	      			<li class="num">0.57940</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">37.60</span></li>
					</a>
	    		</ul>
	    		<ul class="row1" onclick="changeChart('MXN')">
	    			<a style=cursor:pointer>
	      			<li class="pic"><div class="Pic_MXN"></div></li>
	      			<li class="mtxt">人民币/墨西哥比索</li>
	      			<li class="num">2.8863</li>
	      	  				<li><em><div class="Pic_Down"></div></em></li>
	      	  				<li><span class="green">36.00</span></li>
					</a>
	    		</ul>
*/

/*
function preg_match_china_money($str)
{
    $strBoundary = RegExpBoundary();
    $strSpace = RegExpSpace();
    
    $strPattern = $strBoundary;
    $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Ta\(start\) Pend\(10px\)" data-reactid="\d*"><span data-reactid="\d*">', '[^<]*', '</span></td>');
    for ($i = 0; $i < 6; $i ++)
    {
        $strPattern .= RegExpParenthesis('<td class="Py\(10px\) Pstart\(10px\)" data-reactid="\d*"><span data-reactid="\d*">', '[^<]*', '</span></td>');
    }
    $strPattern .= $strBoundary;
//    DebugString($strPattern);
    
    $arMatch = array();
    preg_match_all($strPattern, $str, $arMatch, PREG_SET_ORDER);
    return $arMatch;
}
*/

?>

<?php
require_once('_entertainment.php');

function Echo20211222($strHead)
{
	$strHead = GetHeadElement($strHead);
	$strThird = GetNameLink('third', '第三笔');
	$strChinaInternet = GetStockCategoryLink('chinainternet');
	$strSZ164906 = GetStockLink('SZ164906', true);

    echo <<<END
	$strHead
<p>2021年12月22日 周三
<br />在十四个月后，收到了第四笔100.98美元的收入。跟一年多前{$strThird}时想象的不同，拖拉机软件并没有持续多久的热度，今年是靠一路下跌的{$strChinaInternet}维持住了网站的流量。 
最开始时候华宝油气一枝独秀的时代已经结束，在过去的三十天里{$strSZ164906}估值网页的访问量已经是华宝油气的三倍。
</p>
END;
}

?>

<?php
require_once('php/_entertainment.php');

function GetMetaDescription()
{
	return '2020年雪球嘉年华会场，闲逛等雪球之夜喝酒之前，答应写给雪球私募的作业。';
}

function EchoAll()
{
	$strPrivate = GetXueqiuIdLink('5828665454', '雪球私募');
	$strStock = GetBlogLink(20141016);
	$strArticle = GetExternalLink(GetXueqiuWoodyUrl().'165021350', '帖子');
	$strImage = ImgSnowballCarnival();

	EchoBlogDate();
    echo <<<END
<br />2020雪球嘉年华火爆无比，连场外的宣传档活动都比往年丰富不少。我顺着展台一路收集了两罐百事可乐和一个滚雪球之旅的作业本，打印了一张照片，还在娃娃机那里尝试了三个币的机会，不过最后只收获了一只口罩。
<br />到了{$strPrivate}的展台前，工作人员告诉我可以抽奖。选了三个私募卡片，{$strStock}收益率加起来超过了200%，荣获二等奖。不过不巧的是，二等奖的奖品发完了。她说可以给我两个三等奖的眼罩，或者把二等奖的抱枕邮寄给我。
<br />我问能不能给我一个一等奖的T恤呢？她问你买过雪球私募吗？我说这个问题可不能回答，不然你们肯定不给我了。
<br />她接着问，那你能在雪球上发个雪球私募的{$strArticle}吗？我说那当然可以了。估计看我回答得这么痛快，她继续问，你有粉丝吗？我说那当然有。然后她就等着我现场发帖了。
<br />我一看架势不对啊，赶快解释我手机上没装雪球软件。她疑惑的问，一个没装雪球的人是怎么进来的呢？我本来想跟她说是在门口垃圾桶里捡到了一个牌子，不过觉得这样不利于我拿到一等奖奖品，就换了一套说辞，说我是雪球极度重度用户，因为雪球手机软件实在太影响视力和睡眠，所以才被迫卸载的。
<br />估计我诚实的脸打动了她，终于同意了。
<br />总算轮到我问问题，我问能不能让我拍张照片当成雪球发帖的封面图啊。一听到我的要求，三个美女工作人员全部躲到了一边，所以这篇文章没有美女配图。
<br />$strImage
</p>
END;
}

require('../../../php/ui/_dispcn.php');
?>

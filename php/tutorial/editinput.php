<?php
require_once('/php/url.php');
require_once('/php/debug.php');
require_once('/php/sql/sqltable.php');

/*
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":[{"verified_type":"5","verified_desc":"用户已完成实名身份认证"}],"st_color":"1","name":null,"location":null,"id":1352803596,"type":"1","followers_count":33,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":"价值投资实践中","friends_count":427,"verified":false,"status":1,"profile":"/1352803596","stocks_count":51,"screen_name":"夜雨声烦","step":"three","allow_all_stock":false,"blog_description":null,"city":"朝阳区","donate_count":0,"gender":"m","last_status_id":124285811,"status_count":471,"province":"北京","url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20181/1517494875003-1517494875490.jpg,community/20181/1517494875003-1517494875490.jpg!180x180.png,community/20181/1517494875003-1517494875490.jpg!50x50.png,community/20181/1517494875003-1517494875490.jpg!30x30.png","privacy_agreement":null,"cube_count":2,"verified_realname":true},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":[{"verified_type":"5","verified_desc":"用户已完成实名身份认证"}],"st_color":"1","name":null,"location":null,"id":1512427742,"type":"1","followers_count":45,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":"寂寞深山雪，清贫瑶池奴。（.*？）","friends_count":306,"verified":false,"status":2,"profile":"/1512427742","stocks_count":42,"screen_name":"集韵","step":"null","allow_all_stock":false,"blog_description":null,"city":"","donate_count":0,"gender":"n","last_status_id":125246450,"status_count":529,"province":"","url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20187/1534327350426-1534327350715.jpg,community/20187/1534327350426-1534327350715.jpg!180x180.png,community/20187/1534327350426-1534327350715.jpg!50x50.png,community/20187/1534327350426-1534327350715.jpg!30x30.png","privacy_agreement":null,"cube_count":4,"verified_realname":true},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":null,"st_color":"1","name":null,"location":null,"id":7781467265,"type":"1","followers_count":11,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":"地产保险银行+","friends_count":655,"verified":false,"status":0,"profile":"/7781467265","stocks_count":131,"screen_name":"千泽","step":"null","allow_all_stock":false,"blog_description":null,"city":"","donate_count":0,"gender":"n","last_status_id":125237974,"status_count":108,"province":"","url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20193/1554344403396-1554344403607.jpg,community/20193/1554344403396-1554344403607.jpg!180x180.png,community/20193/1554344403396-1554344403607.jpg!50x50.png,community/20193/1554344403396-1554344403607.jpg!30x30.png","privacy_agreement":null,"cube_count":5,"verified_realname":false},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":null,"st_color":"1","name":null,"location":null,"id":1426381781,"type":"1","followers_count":1,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":"风吹雨成花，时间追不上白马","friends_count":24,"verified":false,"status":2,"profile":"/1426381781","stocks_count":20,"screen_name":"Mark的自由之路","step":"null","allow_all_stock":false,"blog_description":null,"city":"未知","donate_count":0,"gender":"n","last_status_id":124505869,"status_count":14,"province":"不限","url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20185/1529853685664-1529853685932.jpg,community/20185/1529853685664-1529853685932.jpg!180x180.png,community/20185/1529853685664-1529853685932.jpg!50x50.png,community/20185/1529853685664-1529853685932.jpg!30x30.png","privacy_agreement":null,"cube_count":0,"verified_realname":false},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":null,"st_color":"1","name":null,"location":null,"id":2228928727,"type":"1","followers_count":1,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":null,"friends_count":122,"verified":false,"status":0,"profile":"/2228928727","stocks_count":118,"screen_name":"蓝胖子跑得快","step":"null","allow_all_stock":false,"blog_description":null,"city":null,"donate_count":0,"gender":"n","last_status_id":124999693,"status_count":11,"province":null,"url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/201710/1509764480802-1509764480986.jpg,community/201710/1509764480802-1509764480986.jpg!180x180.png,community/201710/1509764480802-1509764480986.jpg!50x50.png,community/201710/1509764480802-1509764480986.jpg!30x30.png","privacy_agreement":null,"cube_count":0,"verified_realname":false},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":null,"st_color":"1","name":null,"location":null,"id":9586930900,"type":"1","followers_count":3,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":null,"friends_count":144,"verified":false,"status":0,"profile":"/9586930900","stocks_count":6,"screen_name":"一点都不智能","step":"null","allow_all_stock":false,"blog_description":null,"city":null,"donate_count":0,"gender":"n","last_status_id":125060397,"status_count":6,"province":null,"url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20192/1553862083103-1553862083312.jpeg,community/20192/1553862083103-1553862083312.jpeg!180x180.png,community/20192/1553862083103-1553862083312.jpeg!50x50.png,community/20192/1553862083103-1553862083312.jpeg!30x30.png","privacy_agreement":null,"cube_count":0,"verified_realname":false},
{"subscribeable":false,"remark":null,"common_count":0,"recommend_reason":null,"verified_infos":null,"st_color":"1","name":null,"location":null,"id":5150399568,"type":"1","followers_count":4,"recommend":null,"domain":null,"intro":null,"follow_me":false,"blocking":false,"stock_status_count":null,"description":"","friends_count":221,"verified":false,"status":0,"profile":"/5150399568","stocks_count":273,"screen_name":"高黎明","step":"null","allow_all_stock":false,"blog_description":null,"city":"烟台","donate_count":0,"gender":"m","last_status_id":124618450,"status_count":6,"province":"山东","url":null,"verified_description":null,"verified_type":0,"following":false,"group_ids":null,"name_pinyin":null,"screenname_pinyin":null,"photo_domain":"//xavatar.imedao.com/","profile_image_url":"community/20159/1445865830399-1445865831971.jpg,community/20159/1445865830399-1445865831971.jpg!180x180.png,community/20159/1445865830399-1445865831971.jpg!50x50.png,community/20159/1445865830399-1445865831971.jpg!30x30.png","privacy_agreement":null,"cube_count":0,"verified_realname":false},
*/

function GetEditInputDefault()
{
	return '2244868365';
}

function GetEditInputString($strInput)
{
	$strCookie = 'xq_a_token=2702d8e6d725cfa9cf118a92a6003cd58874d8b8';
	$strUrl = 'https://xueqiu.com/friendships/groups/members.json?gid=0&uid='.$strInput.'&page=2';
//	DebugString($strUrl);
	$str = url_get_contents($strUrl, $strCookie);
    $ar = json_decode($str, true);
    
    $str = '';
    $arUsers = $ar['users'];
    foreach ($arUsers as $arCur)
    {
    	$str .= $arCur['id'].' '.$arCur['screen_name'].'<br />';
    }
/*    $iCount = intval($ar['count']);
    for ($i = 0; $i < $iCount; $i ++)
    {
    }
*/
	return $str;
}

?>

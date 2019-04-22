<?php
require_once('/php/url.php');
require_once('/php/debug.php');
require_once('/php/externallink.php');
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

/*
		self.mainURL = "https://xueqiu.com"								 
		self.ipURL = "http://www.xicidaili.com"			
		self.portfolioURL = "https://xueqiu.com/P/{}"			 
		self.loginURL = "https://xueqiu.com/snowman/login"		
		self.userURL = "https://xueqiu.com/cubes/list.json?user_id={}&_={}"
		self.netURL = "https://xueqiu.com/cubes/nav_daily/all.json?cube_symbol={}"
		self.queryURL = "https://xueqiu.com/cube/search.json?q={}&count={}&page={}"	
		self.codeURL = "https://xueqiu.com/account/sms/send_verification_code.json"
		self.followerURL = "https://xueqiu.com/friendships/followers.json?uid={}&pageNo={}"
		self.followeeURL = "https://xueqiu.com/friendships/groups/members.json?uid={}&page={}&gid=0"
		self.historyURL = "https://xueqiu.com/cubes/rebalancing/history.json?cube_symbol={}&count={}&page={}"
		self.ipRegulation = r"(([1-9]?\d|1\d{2}|2[0-4]\d|25[0-5]).){3}([1-9]?\d|1\d{2}|2[0-4]\d|25[0-5])"
		self.cookie = "AQAAAKTCMDO5LQkA/wFeZQIWGR34f/iG; xq_a_token=6125633fe86dec75d9edcd37ac089d8aed148b9e; xq_a_token.sig=CKaeIxP0OqcHQf2b4XOfUg-gXv0; xq_r_token=335505f8d6608a9d9fa932c981d547ad9336e2b5; xq_r_token.sig=i9gZwKtoEEpsL9Ck0G7yUGU42LY; u=471544938460796; Hm_lvt_1db88642e346389874251b5a1eded6e3=1544938461; Hm_lpvt_1db88642e346389874251b5a1eded6e3=1544938461; device_id=8811e70b46b0adaa9496184d828c6f1d; _ga=GA1.2.1956277879.1544938463; _gid=GA1.2.679564619.1544938463; _gat_gtag_UA_16079156_4=1"
*/

class XueqiuIdSql extends TableSql
{
    function XueqiuIdSql() 
    {
        parent::TableSql('xueqiuid');
    }
    
    function Create()
    {
    	$str = ' `id` BIGINT UNSIGNED NOT NULL PRIMARY KEY,'
         	  . ' `name` VARCHAR( 64 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,'
         	  . ' `friend` INT UNSIGNED NOT NULL ,'
         	  . ' `follower` INT UNSIGNED NOT NULL ,'
         	  . ' `status` INT UNSIGNED NOT NULL ,'
         	  . ' INDEX ( `status` )';
    	return $this->CreateTable($str);
    }

    function Write($strId, $strName, $strFriend, $strFollower, $strStatus)
    {
    	$ar = array('id' => $strId,
    				  'name' => $strName,
    				  'friend' => $strFriend,
    				  'follower' => $strFollower,
    				  'status' => $strStatus);
    	
    	if ($record = $this->GetById($strId))
    	{
    		unset($ar['id']);
    		if ($record['name'] == $strName)			unset($ar['name']);
    		if ($record['friend'] == $strFriend)		unset($ar['friend']);
    		if ($record['follower'] == $strFollower)	unset($ar['follower']);
    		if ($record['status'] == $strStatus)		unset($ar['status']);
    		if (count($ar) > 0)
    		{
    			return $this->UpdateById($ar, $strId);
    		}
    	}
    	else
    	{
    		return $this->InsertData($ar);
    	}
    	return false;
    }
}
/*
class XueqiuFriendSql extends TableSql
{
    function XueqiuFriendSql() 
    {
        parent::TableSql('xueqiufriend');
    }
    
    function Create()
    {
    	$str = ' `id` BIGINT UNSIGNED NOT NULL,'
         	  . ' `friend_id` BIGINT UNSIGNED NOT NULL ,'
         	  . ' PRIMARY KEY ( `id`, `friend_id` ) ,'
         	  . ' INDEX ( `id` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strId, $strFriendId)
    {
		return $this->InsertData(array('id' => $strId, 'friend_id' => $strFriendId));
    }
}
*/

function GetEditInputDefault()
{
//	return '2244868365';	// Woody
	return '1426381781';
}

function _getXueqiuId($strId, $xq_sql)
{
	$strCookie = 'xq_a_token=962201de99e24d9a442fce1d50f9087657d6fa26'; //;'
//				  .'xq_is_login=1;'
//				  .'xq_is_login.sig=J3LxgPVPUzbBg3Kee_PquUfih7Q;'
//				  .'remember=1;'
//				  .'remember.sig=K4F3faYzmVuqC0iXIERCQf55g2Y;'
//				  .'u.sig=J1YjyGI_Jp4UGXqCZeYDGtcfrwY;'
//				  .'u='.$strId;
	$strUrl = 'https://xueqiu.com/friendships/groups/members.json?gid=0&uid='.$strId;
	$strDisp = '';
	
    $fStart = microtime(true);
	$iCount = 0;
	$iPage = 1;
	do
	{
		$str = url_get_contents($strUrl.'&page='.strval($iPage), $strCookie);
		$ar = json_decode($str, true);
		if ($iPage != intval($ar['page']))	break;
		
		if (intval($ar['count']) > 0)
		{
			$arUsers = $ar['users'];
			foreach ($arUsers as $arCur)
			{
				if ($arCur['follow_me'] == false)
				{
					$strDisp .= GetXueQiuIdLink($arCur['id'], $arCur['screen_name']).'<br />';	// .' '.$arCur['follow_me'].' '.$arCur['following']
					$iCount ++;
				}
				$xq_sql->Write($arCur['id'], $arCur['screen_name'], $arCur['friends_count'], $arCur['followers_count'], $arCur['status_count']);
			}
		}
		$iPage ++;
	} while ($iPage <= intval($ar['maxPage']));
	return $strDisp.strval($iCount).DebugGetStopWatchDisplay($fStart);
}

function GetEditInputString($strInput)
{
    $xq_sql = new XueqiuIdSql();
    $str = _getXueqiuId($strInput, $xq_sql);
	return $str;
}

?>

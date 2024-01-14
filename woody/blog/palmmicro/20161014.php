<?php
require('php/_palmmicro.php');

function GetMetaDescription($bChinese)
{
	return 'The full story of Palmmicro WeChat public account, from its beginning to the disappointing end.';
}

function _echo20161014($bChinese)
{
	$strPalmmicro = GetBlogLink(20080326, $bChinese);
	$strFlyingpig33 = GetQuoteElement('flyingpig33');
	$strSZ162411 = GetBlogLink(20150818, $bChinese);
	$strPHP = GetBlogLink(20100905, $bChinese);
	$strGoogle = GetBlogLink(20110509, $bChinese);
	$str162411 = GetRemarkElement('162411');
	$str1 = GetRemarkElement('1');
	$strPA3288 = GetInternalLink('/pa3288/index.html', 'PA3288');
	$strQuoteSz162411 = GetQuoteElement('sz162411');
	$strQuotePalmmicro = GetQuoteElement('palmmicro');
	$strImage = ImgPalmmicroWechat($bChinese);
	
	EchoBlogDate($bChinese);
    echo <<<END
<br />As a company that has been engaged in Internet products for 16 years, $strPalmmicro has never developed its own mobile application software. The world is changing rapidly, and now it seems that there is no need to develop your own applications. 
Most needs can be met by using the WeChat public account.
<br />As I talked with public account $strFlyingpig33 when I was working on the $strSZ162411 net value estimation more than a year ago, I always thought that adding a public account was very simple.
Using the WeChat example $strPHP program that is almost clear at a glance, I was constantly prompted something with token failed. After debugging it repeatedly all night, I realized that it was because the Yahoo web service added a piece of javascript after each of my pages. 
<br />Because I have been using $strGoogle Analytics for web statistics for a long time, I have always felt that this feature added by Yahoo two years ago is a burden. It does not provide any new features and instead slows down the response speed of the web page.
Now I have a good reason to get rid of it. After searching for a long time in the new Yahoo Small Business website Aabaco Small Business, I finally closed it. 
<br />Next step will be the function. Now the most direct need is to use WeChat to check SZ162411 net value. Use voice or keyboard to enter $str162411 to obtain its various net value and specific valuation time.
<br />If the user only enters $str1, a large number of results will be matched. Due to the WeChat message length limit of 2048 bytes, only the first part of the match will be displayed. 
If you use WeChat voice directly, WeChat's built-in speech recognition seems to require a little training.
For example, if you say $str162411 at the beginning, the recognition result may not be satisfactory, but if you input $str162411 with the keyboard first, subsequent speech recognition will be smooth.
<br />A problem was encountered during the development process. WeChat messages have a limit that must be returned within 5 seconds. 
According to Google Analytics's Page Timings statistics of 5,934 times in the past 30 days for SZ162411 net value page, the average response time is 10 seconds, which will most likely exceed WeChat's 5-second limit, resulting in message response failure. 
The main reason for the slow response time is that we may need to visit different websites such as Sina stock data and the USD/RMB data before valuation. 
I had no choice but to optimize, store as much data locally as possible, and reduce visits to external websites in each query. In the end, the longest response time was barely controlled at 4228 milliseconds, which finally met the requirements.
<br />Back to the company's products, this WeChat public account and this website serve as a specific application example to provide an overall solution for data collection, storage and query for the $strPA3288 Internet of Things module under development. 
On this basis, we can provide a full set of products and software and hardware technologies to help customers build their own IoT data management and analysis application systems.
<br />Although there are not many functions yet, you can already scan the QR code below to add a Palmmicro WeChat public account. 
Choosing $strQuoteSz162411 as the WeChat account is not only in line with the currently provided data, but also a no-brainer choice, because I like to use the name $strQuotePalmmicro so much that it has long been occupied by my own private WeChat account. 
$strImage
</p>
END;
}

function EchoAll($bChinese)
{
	_echo20161014($bChinese);
}

require('../../../php/ui/_disp.php');
?>

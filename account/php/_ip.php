<?php
require_once('_account.php');
require_once('/php/ui/table.php');

function _echoEditIpForm($strIp, $bChinese)
{
    if ($bChinese)
    {
        $strTitle = '输入IP地址:';
        $strSubmit =  '提交';
    }
    else
    {
        $strTitle = 'Input IP Address:';
        $strSubmit =  'Submit';
    }
    
	echo <<< END
	<form id="ipForm" name="ipForm" method="post" action="/account/php/_submitip.php">
        <div>
		<p><font color=olive>$strTitle</font>
	        <input name="ip" value="$strIp" type="text" maxlength="16" class="textfield" id="ip" />
	        <input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
}

function EchoCheckIp($bChinese)
{
    $strIp = UrlGetQueryValue('ip');
    if ($strIp == false)
    {
        $strIp = UrlGetIp();
    }
    
    $str = IpLookupGetString($strIp, '<br />', $bChinese);
    EchoParagraph($str);
    _echoEditIpForm($strIp, $bChinese);
    
    if (AcctIsAdmin())
    {
        EchoParagraph(GetDebugLink());
    }
}

    AcctNoAuth();

?>

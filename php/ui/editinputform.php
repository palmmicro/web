<?php
require_once('htmlelement.php');

define('EDIT_INPUT_NAME', 'input');

function EchoEditInputForm($strPage, $strInput = '', $bChinese = true)
{
    $strSubmit =  $bChinese ? '提交' : 'Submit';
    $strName = EDIT_INPUT_NAME;
	$strCur = UrlGetCur();
	echo <<< END
	<form id="inputForm" name="inputForm" method="post" action="$strCur">
        <div>
		<p><font color=olive>$strPage</font>
	        <br /><input name="$strName" value="$strInput" type="text" style="width:640px;" maxlength="240" class="textfield" id="$strName" />
	        <br /><input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
}

?>

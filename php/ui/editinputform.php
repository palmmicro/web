<?php
require_once('htmlelement.php');

define('EDIT_INPUT_NAME', 'input');

function EchoEditInputForm($strTitle, $strInput = '', $bChinese = true)
{
    $strSubmit =  $bChinese ? '提交' : 'Submit';
    $strName = EDIT_INPUT_NAME;
	echo <<< END
	<form id="inputForm" name="inputForm" method="post" action="/php/_submiteditinput.php">
        <div>
		<p><font color=olive>$strTitle</font>
	        <input name="$strName" value="$strInput" type="text" maxlength="240" class="textfield" id="$strName" />
	        <input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
}

?>

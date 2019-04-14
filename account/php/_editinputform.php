<?php
require_once('/php/ui/htmlelement.php');

define('EDIT_INPUT_NAME', 'input');

function EchoEditInputForm($strTitle, $strInput, $bChinese)
{
    $strSubmit =  $bChinese ? '提交' : 'Submit';
    $strName = EDIT_INPUT_NAME;
	echo <<< END
	<form id="inputForm" name="inputForm" method="post" action="/account/php/_submitinput.php">
        <div>
		<p><font color=olive>$strTitle</font>
	        <input name="$strName" value="$strInput" type="text" maxlength="16" class="textfield" id="$strName" />
	        <input type="submit" name="submit" value="$strSubmit" />
	    </p>
        </div>
    </form>
END;
}

?>

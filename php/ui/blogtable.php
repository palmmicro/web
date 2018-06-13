<?php
require_once('table.php');

// ****************************** Interpretation table *******************************************************

function _echoInterpretationTableItem($ar)
{
    echo <<<END
    <tr>
        <td class=c1>{$ar[0]}</td>
        <td class=c1>{$ar[1]}</td>
        <td class=c1>{$ar[2]}</td>
    </tr>
END;
}

function EchoInterpretationParagraph($arData, $strName, $bChinese)
{
    if ($bChinese)  $arColumn = array('序号', '原始数据内容', '字段意义');
    else              $arColumn = array('Index', 'Original Data', 'Meaning');
    
    echo <<<END
    	<p>
        <TABLE borderColor=#cccccc cellSpacing=0 width=640 border=1 class="text" id="$strName">
        <tr>
            <td class=c1 width=50 align=center>{$arColumn[0]}</td>
            <td class=c1 width=290 align=center>{$arColumn[1]}</td>
            <td class=c1 width=300 align=center>{$arColumn[2]}</td>
        </tr>
END;

    foreach ($arData as $ar)    _echoInterpretationTableItem($ar);
    EchoTableParagraphEnd();
}

?>

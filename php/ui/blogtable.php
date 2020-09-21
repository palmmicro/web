<?php
require_once('table.php');

function EchoInterpretationParagraph($arData, $strName, $bChinese = true)
{
	EchoTableParagraphBegin(array(new TableColumn(($bChinese ? '序号' : 'Index'), 50),
								   new TableColumn(($bChinese ? '原始数据内容' : 'Original Data'), 290),
								   new TableColumn(($bChinese ? '字段意义' : 'Meaning'), 300)
								   ), $strName);

    foreach ($arData as $ar)    EchoTableColumn($ar);
    EchoTableParagraphEnd();
}

?>

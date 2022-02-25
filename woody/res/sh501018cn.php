<?php 
require('php/_qdii.php');

function GetQdiiRelated($sym)
{
	$str = GetNanFangOfficialLink($sym->GetDigitA());
	$str .= ' '.GetQdiiLinks($sym);
	$str .= GetNanFangSoftwareLinks();
	$str .= _GetKnownBugs('注意USO其实只是SH501018跟踪和持有的标的之一，此处估算结果仅供参考。');
	return $str;
}

require('/php/ui/_dispcn.php');
?>

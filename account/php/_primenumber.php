<?php
require_once('_account.php');
require_once('_editinputform.php');
require_once('/php/ui/table.php');

function _calcPrimeNumber($strNumber, $bChinese)
{
    $fStart = microtime(true);
	$iNum = intval($strNumber);
	$aiPrime = array(2);
	for ($i = 3; $i * $i <= $iNum; $i += 2)
	{
		$bPrime = true;
		foreach ($aiPrime as $iPrime)
		{
			if ($iPrime * $iPrime > $i)		break;
			else if (($i % $iPrime) == 0)
			{
				$bPrime = false;
				break;
			}
		}
		if ($bPrime)	$aiPrime[] = $i;
	}

	$aiNum = array();
	for($i = 0; $aiPrime[$i] * $aiPrime[$i] <= $iNum; $i ++)
	{
		while(($iNum % $aiPrime[$i]) == 0)
		{
			$iNum /= $aiPrime[$i];
			$aiNum[] = $aiPrime[$i];
		}
	}
	if ($iNum > 1) 		$aiNum[] = $iNum;

	$strCount = strval(count($aiPrime));
	$str = $bChinese ? '找到'.$strCount.'个质数' : "Found $strCount prime number";
	$str .= DebugGetStopWatchDisplay($fStart);
	$str .= '<br />'.$strNumber.'=1';
	foreach ($aiNum as $iPrime)
	{
		$str .= '*'.strval($iPrime);
	}
//	return rtrim($str, '*');
	return $str;
}

function _getPrimeNumberStr($bChinese)
{
	return $bChinese ? '分解质因数' : 'Prime Number';
}

function EchoAll($bChinese = true)
{
    if (($strNumber = UrlGetQueryValue(EDIT_INPUT_NAME)) == false)
    {
        $strNumber = strval(time());
    }
    
    $str = _calcPrimeNumber($strNumber, $bChinese);
    EchoParagraph($str);
    EchoEditInputForm(_getPrimeNumberStr($bChinese), $strNumber, $bChinese);
}

function EchoMetaDescription($bChinese = true)
{
  	$str = _getPrimeNumberStr($bChinese);
    $str .= $bChinese ? '页面. 质数又称素数, 该数除了1和它本身以外不再有其他的因数, 否则称为合数. 每个合数都可以写成几个质数相乘的形式. 其中每个质数都是这个合数的因数, 叫做这个合数的分解质因数.'
    					: ' page. A prime number (or a prime) is a natural number greater than 1 that has no positive divisors other than 1 and itself.';	//  A natural number greater than 1 that is not a prime number is called a composite number.
    EchoMetaDescriptionText($str);
}

function EchoTitle($bChinese = true)
{
  	$str = _getPrimeNumberStr($bChinese);
  	echo $str;
}

	$acct = new AcctStart(false);

?>

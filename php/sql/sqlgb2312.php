<?php
require_once('sqltable.php');

/*
  function safe_encoding($string) {
    $encoding="UTF-8";
    for($i=0;$i<strlen($string);$i++) {
      if(ord($string{$i})<128) continue;
      if((ord($string{$i})&224)==224) { //第一个字节判断通过
        $char=$string{++$i};
        if((ord($char)&128)==128) { //第二个字节判断通过
          $char=$string{++$i};
          if((ord($char)&128)==128) {
            $encoding="UTF-8";
            break;
          }
        }
      }
      if((ord($string{$i})&192)==192) { //第一个字节判断通过
        $char=$string{++$i};
        if((ord($char)&128)==128) { //第二个字节判断通过
          $encoding="GB2312";
          break;
        }
      }
    }
    if(strtoupper($encoding)==strtoupper($this->_outEncoding))
      return $string;
    else
      return iconv($encoding,$this->_outEncoding,$string);
  }
*/

function get_first_pin_yin($str)
{
//    $fchar=ord($str{0});
//    if($fchar>=ord("A") && $fchar<=ord("z") )return strtoupper($str{0});

//    $s= $this->safe_encoding($str);
//    $asc=ord($s{0})*256+ord($s{1})-65536;

    $asc = hexdec($str) - 65536;
//    DebugVal($asc);
    
    if($asc>=-20319 && $asc<=-20284)return "A";
    if($asc>=-20283 && $asc<=-19776)return "B";
    if($asc>=-19775 && $asc<=-19219)return "C";
    if($asc>=-19218 && $asc<=-18711)return "D";
    if($asc>=-18710 && $asc<=-18527)return "E";
    if($asc>=-18526 && $asc<=-18240)return "F";
    if($asc>=-18239 && $asc<=-17923)return "G";
    if($asc>=-17922 && $asc<=-17418)return "H";
    if($asc>=-17417 && $asc<=-16475)return "J";
    if($asc>=-16474 && $asc<=-16213)return "K";
    if($asc>=-16212 && $asc<=-15641)return "L";
    if($asc>=-15640 && $asc<=-15166)return "M";
    if($asc>=-15165 && $asc<=-14923)return "N";
    if($asc>=-14922 && $asc<=-14915)return "O";
    if($asc>=-14914 && $asc<=-14631)return "P";
    if($asc>=-14630 && $asc<=-14150)return "Q";
    if($asc>=-14149 && $asc<=-14091)return "R";
    if($asc>=-14090 && $asc<=-13319)return "S";
    if($asc>=-13318 && $asc<=-12839)return "T";
    if($asc>=-12838 && $asc<=-12557)return "W";
    if($asc>=-12556 && $asc<=-11848)return "X";
    if($asc>=-11847 && $asc<=-11056)return "Y";
    if($asc>=-11055 && $asc<=-10247)return "Z";
    return false;
}

class GB2312Sql extends TableSql
{
    public function __construct() 
    {
        parent::__construct('gb2312');
    }
    
    function Create()
    {
    	$str = ' `id` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL PRIMARY KEY,'
         	  . ' `utf` CHAR( 4 ) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,'
         	  . ' UNIQUE ( `utf` )';
    	return $this->CreateTable($str);
    }
    
    function Insert($strGB, $strUTF)
    {
    	return $this->InsertArray(array('id' => $strGB, 'utf' => $strUTF));
    }
    
    function GetUTF($strGB)
    {
    	if ($record = $this->GetRecordById($strGB))
    	{
    		return $record['utf'];
    	}
    	return false;
    }
    
    function GetRecord($strUTF)
    {
    	return $this->GetSingleData(_SqlBuildWhere('utf', $strUTF));
    }

    function GetStockPinYinName($str)
    {
    	$strName = '';
    	$iCount = 0;
    	for ($i = 0; $i < strlen($str); $i++)
    	{
    		$iChar1 = ord($str[$i]);
    		if ($iChar1 < 0x80)		continue;
		
    		if (($iChar1 & 0xE0) == 0xE0) 
    		{	// 第一个字节判断通过
    			$iChar2 = ord($str[$i + 1]);
    			if (($iChar2 & 0x80) == 0x80) 
    			{	// 第二个字节判断通过
    				$iChar3 = ord($str[$i + 2]);
    				if (($iChar3 & 0x80) == 0x80)
    				{	// 的确是UTF-8	
    					$iUtf = ($iChar1 & 0x1F) << 12;
    					$iUtf |= ($iChar2 & 0x3F) << 6;
    					$iUtf |= ($iChar3 & 0x3F);
    					$strUTF = dechex($iUtf);
    					$strGB = $this->GetId($strUTF);
//    					DebugString($strUTF.' '.$strGB);
    					
    					if ($strFirst = get_first_pin_yin($strGB))
    					{
    						$strName .= $strFirst;
    						$iCount ++;
    						if ($iCount >= 4)		break;
    						
    						$i += 2;
    					}
    				}
    			}
    		}
    	}
    	return $strName;
    }
}


?>

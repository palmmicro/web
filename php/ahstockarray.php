<?php
require_once('stocklink.php');

function _ahGetArray()
{
    $ar = array('SZ000002' => '02202',
                  'SZ000039' => '02039',
                  'SZ000063' => '00763',
                  'SZ000157' => '01157',
                  'SZ000338' => '02338',
                  'SZ000488' => '01812',
                  'SZ000513' => '01513',
                  'SZ000585' => '00042',
                  'SZ000756' => '00719',
                  'SZ000776' => '01776',
                  'SZ000898' => '00347',
                  'SZ000921' => '00921',
                  'SZ002202' => '02208',
                  'SZ002490' => '00568',
                  'SZ002594' => '01211',
                  'SZ002672' => '00895',
                  'SZ002703' => '01057',
                  'SH600011' => '00902',
                  'SH600012' => '00995',
                  'SH600016' => '01988',
                  'SH600026' => '01138',
                  'SH600027' => '01071',
                  'SH600028' => '00386',
                  'SH600029' => '01055',
                  'SH600030' => '06030',
                  'SH600036' => '03968',
                  'SH600050' => '00762',
                  'SH600115' => '00670',
                  'SH600188' => '01171',
                  'SH600196' => '02196',
                  'SH600332' => '00874',
                  'SH600362' => '00358',
                  'SH600377' => '00177',
                  'SH600548' => '00548',
                  'SH600585' => '00914',
                  'SH600600' => '00168',
                  'SH600660' => '03606',
                  'SH600685' => '00317',
                  'SH600688' => '00338',
                  'SH600775' => '00553',
                  'SH600806' => '00300',
                  'SH600808' => '00323',
                  'SH600837' => '06837',
                  'SH600860' => '00187',
                  'SH600871' => '01033',
                  'SH600874' => '01065',
                  'SH600875' => '01072',
                  'SH600876' => '01108',
                  'SH600958' => '03958',
                  'SH601005' => '01053',
                  'SH601038' => '00038',
                  'SH601088' => '01088',
                  'SH601107' => '00107',
                  'SH601111' => '00753',
                  'SH601186' => '01186',
                  'SH601211' => '02611',
                  'SH601238' => '02238',
                  'SH601288' => '01288',
                  'SH601318' => '02318',
                  'SH601328' => '03328',
                  'SH601333' => '00525',
                  'SH601336' => '01336',
                  'SH601375' => '01375',
                  'SH601390' => '00390',
                  'SH601398' => '01398',
                  'SH601588' => '00588',
                  'SH601600' => '02600',
                  'SH601601' => '02601',
                  'SH601607' => '02607',
                  'SH601618' => '01618',
                  'SH601628' => '02628',
                  'SH601633' => '02333',
                  'SH601688' => '06886',
                  'SH601717' => '00564',
                  'SH601727' => '02727',
                  'SH601766' => '01766',
                  'SH601800' => '01800',
                  'SH601808' => '02883',
                  'SH601811' => '00811',
                  'SH601818' => '06818',
                  'SH601857' => '00857',
                  'SH601866' => '02866',
                  'SH601880' => '02880',
                  'SH601881' => '06881',
                  'SH601898' => '01898',
                  'SH601899' => '02899',
                  'SH601919' => '01919',
                  'SH601939' => '00939',
                  'SH601988' => '03988',
                  'SH601991' => '00991',
                  'SH601992' => '02009',
                  'SH601998' => '00998',
                  'SH603993' => '03993',
                 );
    return $ar;
}

function AhWriteDatabase()
{
    $ar = _ahGetArray();
	SqlCreateStockPairTable(TABLE_AH_STOCK);
    foreach ($ar as $strA => $strH)
    {
    	if ($strA == 'SH600050')  $strRatio = '0.332';
    	else						$strRatio = '1.0';
    	SqlInsertStockPair(TABLE_AH_STOCK, SqlGetStockId($strA), SqlGetStockId($strH), $strRatio);
    }
}

function _getRatioAdrH($strSymbolAdr)
{
    if ($strSymbolAdr == 'ACH')         return 25.0;
    else if ($strSymbolAdr == 'CEA')   return 50.0;
    else if ($strSymbolAdr == 'CHU')   return 10.0;
    else if ($strSymbolAdr == 'GSH')   return 50.0;
    else if ($strSymbolAdr == 'LFC')   return 5.0;
    else if ($strSymbolAdr == 'ZNH')   return 50.0;
    else 
        return 100.0;
}

function _getAdrSymbolA($strSymbolAdr)
{
    if ($strSymbolAdr == 'ACH')         return 'SH601600';
    else if ($strSymbolAdr == 'CEA')   return 'SH600115';
    else if ($strSymbolAdr == 'CHU')   return 'SH600050';
    else if ($strSymbolAdr == 'GSH')   return 'SH601333';
    else if ($strSymbolAdr == 'LFC')   return 'SH601628';
    else if ($strSymbolAdr == 'PTR')   return 'SH601857';
    else if ($strSymbolAdr == 'SHI')   return 'SH600688';
    else if ($strSymbolAdr == 'SNP')   return 'SH600028';
    else if ($strSymbolAdr == 'ZNH')   return 'SH600029';
    else 
        return false;
}

function AdrhWriteDatabase()
{
	SqlCreateStockPairTable(TABLE_ADRH_STOCK);
    $ar = AdrGetSymbolArray();
    foreach ($ar as $str)
    {
    	$strAdr = strtoupper($str);
    	$strA = _getAdrSymbolA($strAdr);
    	$strH = SqlGetAhPair($strA);
    	$strRatio = strval(_getRatioAdrH($strAdr));
    	SqlInsertStockPair(TABLE_ADRH_STOCK, SqlGetStockId($strAdr), SqlGetStockId($strH), $strRatio);
    }
}

?>

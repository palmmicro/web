<?php

function GetAdrSymbolA($strSymbolAdr)
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


?>

<?php

class ForexReference extends MysqlReference
{
/*    function ForexReference($strSymbol)
    {
        parent::MysqlReference($strSymbol);
    }
*/    
    public function LoadData()
    {
		$this->LoadSinaForexData();
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
    }
}

?>

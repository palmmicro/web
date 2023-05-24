<?php

class ForexReference extends MysqlReference
{
    public function LoadData()
    {
		$this->LoadSinaForexData();
        $this->bConvertGB2312 = true;     // Sina name is GB2312 coded
    }
}

?>

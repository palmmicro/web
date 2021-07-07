<?php
require_once('sqlkey.php');

class VisitorSql extends KeySql
{
	var $strSrcKey;
	
    function VisitorSql($strTableName = TABLE_VISITOR, $strDstPrefix = TABLE_PAGE, $strSrcPrefix = TABLE_IP)
    {
    	$this->strSrcKey = $this->Add_id($strSrcPrefix);
        parent::KeySql($strTableName, $strDstPrefix);
    }

    function GetSrcKeyIndex()
    {
    	return $this->strSrcKey;
    }
    
    function GetDstKeyIndex()
    {
    	return $this->GetKeyIndex();
    }
    
    function CreateVisitorTable($str = '')
    {
    	$str = $this->ComposeKeyStr().','
    		 . $this->ComposeIdStr($this->strSrcKey).','
    		 . $this->ComposeDateStr().','
    		 . $this->ComposeTimeStr().','
    		 . $str
    		 . $this->ComposeForeignKeyStr().','
    		 . $this->ComposeForeignStr($this->strSrcKey).','
    		 . _SqlComposeDateTimeIndex();
    	return $this->CreateIdTable($str);
    }
    
    public function Create()
    {
    	return $this->CreateVisitorTable();
    }

    function MakeDateTimeArray($strDate = false, $strTime = false)
    {
    	$ar = array();
    	$ar['date'] = $strDate ? $strDate : DebugGetDate();
    	$ar['time'] = $strTime ? $strTime : DebugGetTime();
    	return $ar;
    }
    
    function MakeVisitorInsertArray($strDstId, $strSrcId, $strDate, $strTime)
    {
		$ar = array_merge($this->MakeDateTimeArray($strDate, $strTime), $this->MakeFieldKeyId($strDstId));
    	$ar[$this->strSrcKey] = $strSrcId;
    	return $ar;
    }
    
    function InsertVisitor($strDstId, $strSrcId, $strDate = false, $strTime = false)
    {
    	return $this->InsertArray($this->MakeVisitorInsertArray($strDstId, $strSrcId, $strDate, $strTime));
    }

    function BuildWhereBySrc($strSrcId)
    {
    	return _SqlBuildWhere($this->strSrcKey, $strSrcId);
    }
    
    function BuildWhereByDst($strDstId)
    {
		return $this->BuildWhere_key($strDstId);
    }
    
    public function GetAll($strWhere = false, $iStart = 0, $iNum = 0)
    {
    	return $this->GetData($strWhere, _SqlOrderByDateTime(), _SqlBuildLimit($iStart, $iNum));
    }

    function GetDataBySrc($strSrcId, $iStart = 0, $iNum = 0)
    {
    	return $this->GetAll($this->BuildWhereBySrc($strSrcId), $iStart, $iNum);
    }

    function GetDataByDst($strDstId, $iStart = 0, $iNum = 0)
    {
    	return $this->GetAll($this->BuildWhereByDst($strDstId), $iStart, $iNum);
    }

    function DeleteBySrc($strSrcId)
    {
    	if ($strSrcId)
    	{
    		return $this->DeleteData($this->BuildWhereBySrc($strSrcId));
    	}
    	return false;
    }
    
    function CountBySrc($strSrcId)
    {
    	return $this->CountData($this->BuildWhereBySrc($strSrcId));
    }

    function CountByDate($strDate)
    {
    	return $this->CountData(_SqlBuildWhere('date', $strDate));
    }

    function CountToday()
    {
    	return $this->CountByDate(DebugGetDate());
    }

    function CountUniqueDst($strSrcId)
    {
    	$ar = array();
    	
    	if ($result = $this->GetDataBySrc($strSrcId)) 
    	{
    		$strIndex = $this->GetDstKeyIndex();
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ar[] = $record[$strIndex];
    		}
    		@mysql_free_result($result);
    	}
    	$ar = array_unique($ar);
    	return count($ar);
    }
}

?>

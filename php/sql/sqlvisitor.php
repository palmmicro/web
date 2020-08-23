<?php
require_once('sqltable.php');

class VisitorSql extends TableSql
{
	var $strDstKey;
	var $strSrcKey;
	
    function VisitorSql($strTableName = TABLE_VISITOR, $strDstPrefix = TABLE_PAGE, $strSrcPrefix = TABLE_IP)
    {
    	$this->strDstKey = $this->Add_id($strDstPrefix);
    	$this->strSrcKey = $this->Add_id($strSrcPrefix);
        parent::TableSql($strTableName);
    }

    public function GetExtraCreateStr()
    {
    	return '';
    }
    
    function Create()
    {
    	$str = $this->ComposeIdStr($this->strDstKey).','
    		 . $this->ComposeIdStr($this->strSrcKey).','
    		 . ' `date` DATE NOT NULL ,'
    		 . ' `time` TIME NOT NULL ,'
    		 . $this->GetExtraCreateStr()
    		 . $this->ComposeForeignStr($this->strDstKey).','
    		 . $this->ComposeForeignStr($this->strSrcKey).','
    		 . _SqlComposeDateTimeIndex();
    	return $this->CreateIdTable($str);
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
    	$ar = $this->MakeDateTimeArray($strDate, $strTime);
    	$ar[$this->strDstKey] = $strDstId;
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
    	return _SqlBuildWhere($this->strDstKey, $strDstId);
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
    		return $this->DeleteRecord($this->BuildWhereBySrc($strSrcId));
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
    		while ($record = mysql_fetch_assoc($result)) 
    		{
    			$ar[] = $record[$this->strDstKey];
    		}
    		@mysql_free_result($result);
    	}
    	$ar = array_unique($ar);
    	return count($ar);
    }
}

?>

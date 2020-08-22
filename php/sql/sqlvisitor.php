<?php
require_once('sqltable.php');

class VisitorSql extends TableSql
{
	var $strDst;
	var $strSrc;
	
    function VisitorSql($strTableName = TABLE_VISITOR, $strDstPrefix = TABLE_PAGE, $strSrcPrefix = TABLE_IP)
    {
    	$this->strDst = $this->Add_id($strDstPrefix);
    	$this->strSrc = $this->Add_id($strSrcPrefix);
        parent::TableSql($strTableName);
    }

    public function GetExtraCreateStr()
    {
    	return '';
    }
    
    function Create()
    {
    	$str = $this->ComposeIdStr($this->strDst).','
    		 . $this->ComposeIdStr($this->strSrc).','
    		 . ' `date` DATE NOT NULL ,'
    		 . ' `time` TIME NOT NULL ,'
    		 . $this->GetExtraCreateStr()
    		 . $this->ComposeForeignStr($this->strDst).','
    		 . $this->ComposeForeignStr($this->strSrc).','
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
    	$ar[$this->strDst] = $strDstId;
    	$ar[$this->strSrc] = $strSrcId;
    	return $ar;
    }
    
    function InsertVisitor($strDstId, $strSrcId, $strDate = false, $strTime = false)
    {
    	return $this->InsertArray($this->MakeVisitorInsertArray($strDstId, $strSrcId, $strDate, $strTime));
    }

    function _buildWhereBySrc($strSrcId)
    {
    	return _SqlBuildWhere($this->strSrc, $strSrcId);
    }
    
    function _buildWhereByDst($strDstId)
    {
    	return _SqlBuildWhere($this->strDst, $strDstId);
    }
    
    public function GetAll($strWhere = false, $iStart = 0, $iNum = 0)
    {
    	return $this->GetData($strWhere, _SqlOrderByDateTime(), _SqlBuildLimit($iStart, $iNum));
    }

    function GetDataBySrc($strSrcId, $iStart = 0, $iNum = 0)
    {
    	return $this->GetAll($this->_buildWhereBySrc($strSrcId), $iStart, $iNum);
    }

    function GetDataByDst($strDstId, $iStart = 0, $iNum = 0)
    {
    	return $this->GetAll($this->_buildWhereByDst($strDstId), $iStart, $iNum);
    }

    function DeleteBySrc($strSrcId)
    {
    	if ($strSrcId)
    	{
    		return $this->DeleteRecord($this->_buildWhereBySrc($strSrcId));
    	}
    	return false;
    }
    
    function CountBySrc($strSrcId)
    {
    	return $this->CountData($this->_buildWhereBySrc($strSrcId));
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
    			$ar[] = $record[$this->strDst];
    		}
    		@mysql_free_result($result);
    	}
    	$ar = array_unique($ar);
    	return count($ar);
    }
}

?>

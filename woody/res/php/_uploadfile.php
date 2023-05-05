<?php
require_once('_stock.php');

class _AdminUploadFileAccount extends Account
{
    public function AdminProcess()
    {
    	if ($_FILES['file']['error'] > 0)
    	{
    		DebugString('Return Code: '.$_FILES['file']['error']);
    	}
    	else
    	{
    		DebugString('Upload: '.$_FILES['file']['name']);
    		DebugString('Type: '.$_FILES['file']['type']);
    		DebugString('Size: '.($_FILES['file']['size'] / 1024).' Kb');
    		DebugString('Temp file: '.$_FILES['file']['tmp_name']);

    		$strFileName = DebugGetPath('csv').'/'.$_FILES['file']['name'];
    		if (file_exists($strFileName))
    		{
    			DebugString($_FILES['file']['name'].' already exists.');
    		}
    		else
    		{
    			move_uploaded_file($_FILES['file']['tmp_name'], $strFileName);
    			DebugString('Stored in: '.$strFileName);
    		}
    	}
	}
}

?>

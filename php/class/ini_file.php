<?
///////////////////////////////////////////////////////////////////////// http://px.sklar.com/code.html?id=142&fmt=pl
// 
//  class.INIFile.php3  -  implements  a  simple  INIFile Parser 
//  
//  Author:  MO
//  
//  Description: 
//	I just wandered how to sawe simple parameters not in a database but in a file
//  So starting every time from scratch isn't comfortable and I desided to write this
//  small unit for workin with ini like files
//  Some  Examples: 
//	
//	$ini = new INIFile("./ini.ini");
//  //Read entire group in an associative array
//	$grp = $ini->read_group("MAIN");
//	//prints the variables in the group
//	if ($grp)
//	for(reset($grp); $key=key($grp); next($grp))
//	{
//		echo "GROUP ".$key."=".$grp[$key]."<br>";
//	}
//	//set a variable to a value
//	$ini->set_var("NEW","USER","JOHN");
//  //Save the file
//	$ini->save_data();


class  INIFile {

	var $INI_FILE_NAME = '';
	var $ERROR = '';
	var $GROUPS = array();
	var $CURRENT_GROUP = '';
	
	public function __construct($inifilename='')
	{
		$this->INI_FILE_NAME = $inifilename;
		if(!empty($inifilename))
		{
			clearstatcache();
			if(!file_exists($inifilename)){
				$this->Error("This file does not exist: $inifilename!");
				return;
			}
		}
		$this->parse($inifilename);
	}


// LOAD AND SAVE FUNCTIONS
	
	function parse($inifilename)
	{
//		$this->INI_FILE_NAME = $inifilename;
		$fp = fopen($inifilename, 'r+');
		$contents = fread($fp, filesize($inifilename));
//		$ini_data = split("\n",$contents);
		$ini_data = explode("\n",$contents);
		
/*		while(list($key, $data) = each($ini_data))
		{
			$this->parse_data($data);
		}
*/
		foreach ($ini_data as $key => $data)
		{
			$this->parse_data($data);
		}

		fclose($fp);
	}
	
	function parse_data($data)
	{
//		if(ereg("\[([[:alnum:]]+)\]",$data,$out))
		if(preg_match("/^\[([[:alnum:]]+)\]/",$data,$out))
		{
			$this->CURRENT_GROUP=$out[1];
//			$this->GROUPS[$this->CURRENT_GROUP] = array();
		}
		else
		{
//			$split_data = split('=', $data);
			$split_data = explode('=', $data);
			if (count($split_data) >= 2)	$this->GROUPS[$this->CURRENT_GROUP][$split_data[0]]=$split_data[1];
		}
	}

	function save_data()
	{
		$fp = fopen($this->INI_FILE_NAME,'w');
		
		if(empty($fp))
		{
			$this->Error("Cannot create file {$this->INI_FILE_NAME}");
			return false;
		}
		
		$groups = $this->read_groups();
		$group_cnt = count($groups);
		
		for($i=0; $i<$group_cnt; $i++)
		{
			$group_name = $groups[$i];
			$res = sprintf("[%s]\n",$group_name);
			fwrite($fp, $res);
			$group = $this->read_group($group_name);
			for(reset($group); $key=key($group);next($group))
			{
				$res = sprintf("%s=%s\n",$key,$group[$key]);
//				echo $res."\n";
				fwrite($fp,$res);
			}
		}
		
		fclose($fp);
	}

// FUNCTIONS FOR GROUPS
	
	//returns number of groups	
	function get_group_count()
	{
		return count($this->GROUPS);
	}
	
	//returns an array with the names of all the groups
	function read_groups()
	{
		$groups = array();
		for(reset($this->GROUPS);$key=key($this->GROUPS);next($this->GROUPS))
			$groups[]=$key;
		return $groups;
	}
	
	//checks if a group exists
	function group_exists($group_name)
	{
		return isset($this->GROUPS[$group_name]);
/*		$group = $this->GROUPS[$group_name];
		if (empty($group)) return false;
		else return true;*/
	}

	//returns an associative array of the variables in one group	
	function read_group($group)
	{
		$group_array = $this->GROUPS[$group];
		if(!empty($group_array)) 
			return $group_array;
		else 
		{
			$this->Error("Group $group does not exist");
			return false;
		}
	}
	
	//adds a new group
	function add_group($group_name)
	{
		if (isset($this->GROUPS[$group_name]))
		{
			$this->Error("Group $group_name exists");
		}
		else
		{
			$this->GROUPS[$group_name] = array();
		}
/*		$new_group = $this->GROUPS[$group_name];
		if(empty($new_group))
		{
			$this->GROUPS[$group_name] = array();
		}
		else $this->Error("Group $group_name exists");*/
	}


// FUNCTIONS FOR VARIABLES
	
	//reads a single variable from a group
	function read_var($group, $var_name)
	{
		$var_value = false;
		if (isset($this->GROUPS[$group][$var_name]))	$var_value = $this->GROUPS[$group][$var_name];
//		if(!empty($var_value))
/*		if ($var_value == false)
		{
		    $this->Error("{$this->INI_FILE_NAME}: $var_name does not exist in $group");
		    return false;
		}*/
	    return $var_value;
	}

	function set_group($group)
	{
	    $this->GROUPS[$group] = array();
	}
	
	//sets a variable in a group
	function set_var($group, $var_name, $var_value)
	{
//		if ($this->group_exists($group))
		{
	        $this->GROUPS[$group][$var_name] = $var_value;
		}
	}	

// ERROR FUNCTION
			
	function Error($errmsg)
	{
		$this->ERROR = $errmsg;
		DebugString('INIFile error: '.$this->ERROR."\n");
		return;
	}
}
?>

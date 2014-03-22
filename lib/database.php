<?php 

class Database
{

	private $mysql = array();
	private $connection;
        private $log;
	
	// MySQL Error Numbers
	const ERROR_DB_NOT_FOUND = 1049; // Database Not Found
	
	public function __construct($mysql_host, $mysql_username, $mysql_password, $mysql_database="")
	{
		$this->mysql = array("host" => $mysql_host,
					 "username" => $mysql_username,
					 "password" => $mysql_password,
					 "database" => $mysql_database
		);
	}
	
	public function connect()
	{
		$connection = mysql_connect($this->mysql["host"],
                                            $this->mysql["username"],
                                            $this->mysql["password"]
		);
		echo mysql_error();
		// Check that the database connected
		if(!is_resource($connection))
		{
			// Throw the Exception
			throw new Exception("Database Connection Unavailable", 500);
		}
                
		$this->connection = $connection;	
		
		if(true != empty($this->mysql["database"]))
		{
			// Check that the Database Exists
			$this->select_db($this->mysql["database"]);
			if(mysql_errno() == self::ERROR_DB_NOT_FOUND)
			{
				// Database Setup Error (Default Database Not Defined)
				throw new Exception("Selected Database Not Defined", 404);
			}
		}
	}
	
	public function select_db($database_name)
	{
		mysql_select_db($this->mysql["database"], $this->connection);
	}

	public function query($sql)
	{
		if(!is_resource($this->connection))
		{
			$this->connect();
		}
		
		$resource = mysql_query($sql,$this->connection);
		
		if(mysql_error())
		{
			return mysql_error();
		}
		
		if(is_resource($resource))
		{
                    $return = array();
                    while($temp_row = mysql_fetch_assoc($resource))
                    {
                            $return[] = $temp_row;
                    }
		}
		else
		{
			$return = $resource;
		}
		return $return;
	}

	public function escape( $string ){
		return mysql_real_escape_string( $string );
	}	
}
?>

<?
	/**** Class Database ****/
	Class Database
	{
		
		
		/**** function connect to database ****/
		function connectDatabase()
		{
				$strHost = "localhost";
				$strDB = "ics_service";
				$strUser = "root";
				$strPassword = "1234";
				
				$this->objConnect = mysql_connect($strHost,$strUser,$strPassword);
				$this->DB = mysql_select_db($strDB);
//				$this->CharSet = mysql_query('UTF-8');
		}

		/**** function insert record ****/
		function fncInsertRecord()
		{
				$strSQL = "INSERT INTO $this->strTable ($this->strField) VALUES ($this->strValue) ";
				return mysql_query($strSQL);
		}

		/**** function select record ****/
		function fncSelectRecord()
		{
				$strSQL = "SELECT * FROM $this->strTable WHERE $this->strCondition ";
				$objQuery = @mysql_query($strSQL);
				return @mysql_fetch_array($objQuery);
		}

		/**** function update record (argument) ****/
		function fncUpdateRecord($strTable,$strCommand,$strCondition)
		{
				$strSQL = "UPDATE $strTable SET  $strCommand WHERE $strCondition ";
				return @mysql_query($strSQL);
		}

		/**** function delete record ****/
		function fncDeleteRecord()
		{
				$strSQL = "DELETE FROM $this->strTable WHERE $this->strCondition ";
				return @mysql_query($strSQL);
		}

		/*** end class auto disconnect ***/
		function __destruct() {
				return @mysql_close($this->objConnect);
	    }
		
		/*** function fatch data ***/
		function mysqlFetchRows($query){
			$row = mysql_fetch_array($query);
			return $row;
		}
		
		function mysqlFetchAll($query) {
		   while($row=mysql_fetch_array($query)) {
			   $return[] = $row;
		   }
		   return $return;
		}
	}//END Class Database	

?>
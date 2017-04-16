<?php

class dbConnect {

    public function dbconnect(){
    	return pg_connect("host=mcsdb.utm.utoronto.ca dbname=mehtada3_309 user=mehtada3 password=05270");
    }

    public function userLogin($username,$passwd){

    	$dbconn=$this->dbconnect();
    	$result=pg_prepare($dbconn, "login", "SELECT * FROM voters1 WHERE username= $1 and passwd= $2");

		## check if database was able to prepare it
		if (!($result)){
			pg_close($dbconn);
			return NULL;
		}

		$result = pg_execute($dbconn, "login", array($username,$passwd));

		$result = pg_fetch_all($result);
		pg_close($dbconn);
		if($result[0]['passwd']==$passwd){
			return True;
		}
		return False;
    }

    public function vote($username, $vote){
    	$dbconn=$this->dbconnect();
    	$result=pg_prepare($dbconn, "vote", "UPDATE voters1 SET vote= $1 WHERE username= $2");

		## check if database was able to prepare it
		if (!($result)){
			pg_close($dbconn);
			return NULL;
		}

		$result = pg_execute($dbconn, "vote", array($vote,$username));

		pg_close($dbconn);
    }

    public function getVoteCount(){

    	$dbconn=$this->dbconnect();
    	$extend=pg_prepare($dbconn, "extend", "SELECT COUNT(*) FROM voters1  WHERE vote='extend'");

    	if (!($extend)){
			pg_close($dbconn);
			return NULL;
		}
		$extend = pg_execute($dbconn, "extend", array());

    	$dontextend=pg_prepare($dbconn, "dontextend", "SELECT COUNT(*) FROM voters1  WHERE vote='dontextend'");

    	if (!($dontextend)){
			pg_close($dbconn);
			return NULL;
		}

		$dontextend = pg_execute($dbconn, "dontextend", array());
		$result = array();
		$count = pg_fetch_row($dontextend);
		$result['dontextend']=$count[0];

		$count = pg_fetch_row($extend);
		$result['extend']=$count[0];

		return $result;

    }
}
?>

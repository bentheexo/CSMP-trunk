<?php
// As of January 1st this project has changed CeresCP for
// my distrobution purposes. I have rewritten major componets
// to fit my needs of the software.

session_start();
include_once 'config.php'; // loads config variables
include_once 'query.php'; // imports queries
include_once 'functions.php';

if (check_ban())
	redir("motd.php", "main_div", "Disabled");

if ($CONFIG_v4p == 0) {
		redir("motd.php", "main_div", "Vote 4 Points has been disabled.");
}

opentable('Vote for Points');
?>
<center>
<table width="490"><tr><td>

<?php
	$ip= $_SERVER['REMOTE_ADDR'];

$theaccountID = array();
$thepoints = array();
$thelastvote1 = array();
$thelastvote2 = array();
$thelastvote3 = array();
$thelastvote4 = array();
$theip = array();
$thedate = array();
$arrayUSERID = array();
$arrayAccountId = array();
$verifyAccountId = array();
$arrayPOINTS = array();
$verifyACCOUNTID = 0;
$accountid=0;
$offset=(8*60*60);
settype($user,"String");
$defaultip = settype($ip,"String");

	$offset=(8*60*60); //converting 8 hours to seconds.
	$dt = time();
	$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
//	$rtime = settype($mysql_datetime,"String");
	$user = $_SESSION[$CONFIG_name.'user'];
	$accountid = $_SESSION[$CONFIG_name.'account_id'];
	$STOREpoints = 0;
	$ip = $_SERVER['REMOTE_ADDR'];
	$arrayAccountId = array();
	$ctr = 0;
	//(8*60*60) This will convert to time GMT+8 Change To Change Time here 
	$offset=(8*60*60); //converting 8 hours to seconds.
	$dt = time();
	$mysql_datetime = strftime("%Y-%m-%d %H:%M:%S", $dt+$offset);
	$rtime = $mysql_datetime;
	$offsetEXP=(8*60*60)+(12*60*60); //converting 8 hours to seconds.
	$dtexp = time();
	$mysql_blockendedtime = strftime("%Y-%m-%d %H:%M:%S", $dtexp+$offsetEXP);
	$expirationtime = "$mysql_blockendedtime";

	$unixrtime = strtotime($rtime);

	
	echo "<br/>";
	
		$ctr = 0;
		$query = sprintf(V4P_RESULTA, $POST_accountid);
		$result = execute_query($query, 'v4p2.php');
		while($row = mysql_fetch_array($result)){
		$expirationTimeLastRecord = $row["blockendedtime"];
		$expirationTimeLastRecord2 = $row["blockendedtime2"];
		$expirationTimeLastRecord3 = $row["blockendedtime3"];
		$lastvisit = $row['lastvisit'];
		$STOREpoints = $row["point"];
		$ctr++;
		}
		
		$ctr2 = 0;
		$STOREtimes =array();
		$STOREtimes2 =array();
		$STOREtimes3 =array();

		$STOREip = array();
		$query = sprintf(V4P_RESULTB, $ip);
		$result = execute_query($query, 'v4p2.php');
		while($row2 = mysql_fetch_array($result)){
		$STOREip[$ctr2] = $row2["ip_address"];
		$STOREtimes[$ctr2] = $row2["blockendedtime"];
		$STOREtimes2[$ctr2] = $row2["blockendedtime2"];
		$STOREtimes3[$ctr2] = $row2["blockendedtime3"];
		$ctr2++;
		}
		//GETTING THE HIGHEST TIME OF THE BLOCKED IP
		$verifyIP = in_array($ip,$STOREip);
		if($verifyIP == 1)
		{
			$high = $STOREtimes[0];
			$high2 = $STOREtimes2[0];
			$high3 = $STOREtimes3[0];
			for($check = 1 ; $check <$ctr2 ; $check++)
			{
				if($STOREtimes[$check]>$high)
				{
						$high = $STOREtimes[$check];
				}
				if($STOREtimes2[$check]>$high2)
				{
						$high2 = $STOREtimes2[$check];
				}
				if($STOREtimes3[$check]>$high3)
				{
						$high3 = $STOREtimes3[$check];
				}
			}
		}
			$highTimeForIPunix = strtotime($high);
			$highTimeForIPunix2 = strtotime($high2);
			$highTimeForIPunix3 = strtotime($high3);
			
	$lastRecordTimeBlockended = strtotime($expirationTimeLastRecord);
	$lastRecordTimeBlockended2 = strtotime($expirationTimeLastRecord2);
	$lastRecordTimeBlockended3 = strtotime($expirationTimeLastRecord3);

	if($CONFIG_v4p_enablevote1 == 1)
	{
		if(in_array($ip,$STOREip)==1)
		{
			if($unixrtime>=$highTimeForIPunix)
			{
							$points = 1+$STOREpoints;
							mysql_query("UPDATE vote_point SET blockendedtime = '$expirationtime' WHERE account_id='$accountid'");
							mysql_query("UPDATE vote_point SET point='$points'WHERE account_id = '$accountid'");
							mysql_query("UPDATE vote_point SET ip_address='$ip' WHERE account_id = '$accountid'");
								mysql_query("UPDATE vote_point SET lastvisit='$rtime' WHERE account_id = '$accountid'");
								echo "<a href=\"$CONFIG_v4p_vote1\" target=\"_blank\"><img src=\"$CONFIG_v4p_image1\" alt=\"$CONFIG_v4p_vote1\"></img></a>";
			}
			else
			{
							echo "$CONFIG_v4p_ipblocked";
			}
		}
	else if($ip!=$STOREip)
	{
		if($unixrtime>=$lastRecordTimeBlockended)
		{
							$points = 1+$STOREpoints;
							mysql_query("UPDATE vote_point SET blockendedtime = '$expirationtime' WHERE account_id='$accountid'");
							mysql_query("UPDATE vote_point SET point='$points'WHERE account_id = '$accountid'");
							mysql_query("UPDATE vote_point SET ip_address='$ip' WHERE account_id = '$accountid'");
								mysql_query("UPDATE vote_point SET lastvisit='$rtime' WHERE account_id = '$accountid'");
								echo "<a href=\"$CONFIG_v4p_vote1\" target=\"_blank\"><img src=\"$CONFIG_v4p_image1\" alt=\"$CONFIG_v4p_vote1\"></img></a>";
			}
			else
			{
							echo "$ipblocked";
			}
		}
	}
	else if(isset($_POST['vote2']))
	{
		include('voteTwo.php');
	}
	else if(isset($_POST['vote3']))
	{
		include('voteThree.php');
	}
	else
	{
			echo "";
	}

?>

</td></tr></table></center>
<?php
closetable();
ending();
?>

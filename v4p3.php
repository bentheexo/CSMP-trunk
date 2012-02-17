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

if($user=="")
{
	redir('motd.php', 'Main_Div', 'You must login');
}
else
{
	//Variables Used
			include('variables.php');
			include("query.php");
	//FETCHING
		for($ctr = 0; $ctr<$ctr3;$ctr++)
		{
			$fetchaccountid = $arrayAccountId[$ctr];
		}
	//VERIFRIYING THE IP
	//	$verifyIP = in_array($ip,$theip);
		$verifyUSER = in_array($user,$arrayUSERID);
		$verifyACCOUNTID = in_array($accountid,$verifyAccountId);
		include('checking.php');
	//THE COMPARISON
		if($verifyUSER==1&&$verifyACCOUNTID==0)
		{
			notinDB($offset,$accountid,$con,$defaultip,$ip,$mysql_datetime);
		}
		else if($verifyUSER==1&&$verifyACCOUNTID==1)
		{
			inDB($offset,$accountid,$con,$ip,$user,$points,$lastvisit);
		}
		else
		{
			echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=index.php \">";
		}
}

?>
</td></tr></table></center>
<?php
closetable();
ending();
?>

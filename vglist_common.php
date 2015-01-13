・ｿ<?php
include "../mdcommon.php";

function openVGDB() {
	$link = mysql_connect("localhost", "admin", "test");
	if (!$link) {
	    die('Could not connect: ' . mysql_error());
	}
	else {
		//echo 'Connected successfully';
		mysql_select_db("vghistory");
	}
	return $link;
}

function readGameList($gfile, &$glist) {
	$game_feed = fopen($gfile, "r");
	//$games = array();
	while (!feof($game_feed)) {
		$glist[] = fgets($game_feed);
	}
	fclose($game_feed);
}

function readGameDB($link) {
	return mysql_query( "SELECT * FROM game_list ORDER BY alpha_order" );
}

function targetDBRow($query_string, $link) {
	return mysql_fetch_row( mysql_query($query_string ." LIMIT 1") );
}

function dispGameList($glist) {
	// new non-SQL
	//
	// title = record[0]
	// genre = record[1]
	// publisher = record[2]
	// console = record[3]
	// clear_date = record[4]
	// website? = record[5]
	// pwnage = record[6]

	$i = 0;
	foreach ($glist as $gameset) {
		$record = explode("\t", trim($gameset));
		$i++;
		echo $i . ".   ";
		if ($record[5] != "*")	{	//	Begin optional tag for website!!!
			echo "<a href=";
			if (substr($record[5], 0, 3) == "___")	{
				echo "http://www.classicgaming.com/" . str_replace("___", "", $record[5]) . "/";
	    	}
			else	{
				echo $record[5];
			}
			echo " target=game_info>";	// End optional tag parameters.
		}
		echo $record[0];
		if ($record[5] != "*")	{
			echo "</a>";	// Close the tag!
		}
		echo " {" . $record[1] . "} "; 	// genre
		echo " [" . $record[3] . "]\n<BR>\n";	// console
	}
}

function dispGameListSQL($vgres) {	// new SQL!
	//
	// title = record[1]
	// genre = record[2]
	// publisher = record[3]
	// console = record[4]
	// clear_date_text = record[5]
	// clear_date = record[6]
	// website? = record[7]
	// pwnage = record[8]

	$i = 0;
	//foreach ($glist as $gameset) {
	while ($record = mysql_fetch_row($vgres)) {
		//$record = explode("\t", trim($gameset));
		$i++;
		echo $i . ".   ";
		if ($record[7])	{	//	Begin optional tag for website!!!
			echo "<a href=";
			if (substr($record[7], 0, 3) == "___")	{
				echo "http://www.classicgaming.com/" . str_replace("___", "", $record[7]) . "/";
	    	}
			else	{
				echo $record[7];
			}
			echo " target=game_info>";	// End optional tag parameters.
		}
		echo $record[1];	// title
		if ($record[7])	{
			echo "</a>";	// Close the tag!
		}
		echo " {" . $record[2] . "} "; 	// genre
		echo " [" . $record[4] . "]\n<BR>\n";	// console
	}
}
?>

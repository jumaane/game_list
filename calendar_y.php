・ｿ<?php
chdir ("../");
include "mdvg_common.php";

// Get mySQL link
$vglink = openVGDB();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=iso-8859-1">
   <META NAME="GENERATOR" CONTENT="Mozilla/4.06 [en]C-compaq  (Win98; I) [Netscape]">
   <TITLE>Calendar of gaming!</TITLE>
<!-- SGI_COMMENT COSMOCREATE -->
<!-- SGI_COMMENT VERSION NUMBER="1.0.2" -->
</HEAD>
<?php

//$host = "localhost";
//$usr = "vg_guest";
//$pwd = "game";

$param = $_GET['ownage'];

//$dbase = "vghistory";

$str_sql = "SELECT YEAR(clear_date) a, COUNT(name) b FROM game_list ".
	"GROUP BY a ORDER BY a DESC";

//$dbh = mysql_connect($host, $usr, $pwd);
//mysql_select_db($dbase);

$results = mysql_query($str_sql);
?>
<BODY TEXT="#BBBBDD" BGCOLOR="#111111" LINK="#DDDD00" VLINK="#33CC33" ALINK="#8B008B" border="0">
<link type='text/css' rel='Stylesheet' href='menu.css' />

<center>
<div class=main><a href=index.php target=_top>Main Page</a></font></div>
<div class=secondary><a href=console.html>Browse by console</a></font></div>
<div class=secondary><a href=genre.html>Browse by genre</a></div>
<div class=secondary><a href=publisher.html>Browse by publisher</a></div>
<div class=feature>Clear by year!</div>
<div class=ownage><a href=misc/ownage.php?ownage=O target=vglist>Games I own</a></div>
<div class=kikoku><a href=../index.php target=_parent>[Mystic Domain home]</a></div>
<BR>
<TABLE WIDTH=190 BORDER=0 class=select>

<TR><TD>
<UL>
<?php
while($record = mysql_fetch_row($results)) {
	echo "<LI><a href=misc/calendar.php?lvl=Y&period=". $record[0] ." target=vglist>".
		$record[0] ."</a> (". $record[1] .")</LI>\n";
}
?>
</UL>
</TD></TR>
</TABLE>

</BODY>
</HTML>
<?php
mysql_close($vglink);
?>

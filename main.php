<?php
include "vglist_common.php";

// Get mySQL link
$vglink = openVGDB();
?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<TITLE>The new page of gaming history...</TITLE>
<link type="text/css" rel="Stylesheet" href="mdvg.css" />
</HEAD>
<?php
$games = Array();
//readGameList("_scripts/game_list.txt", $games);
$game_list_db = readGameDB($vglink);

$recentSQL = "SELECT name, DATE_FORMAT(clear_date, '%c/%e/%Y'), promo FROM game_list WHERE clear_date = ".
	"(SELECT MAX(clear_date) FROM game_list)";
?>

<!-- BODY text="#505000" BGCOLOR="#20E0E0" -->
<!-- BODY text="#FFEEF7" BGCOLOR="#20E0E0" link="#BB8899" vlink="AA99AA" -->
<body class="vgpc">

<!-- SCRIPT LANGUAGE ="Javascript">
if (navigator.appName == "Netscape") {
    document.write("<EMBED SRC=../vgmids/Katamari_Rocks.mp3 WIDTH=2 HEIGHT=0 AUTOSTART=true LOOP=false VOLUME=5>\n");
}
else {
    document.write("<object classid=CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95 type=audio/x-wav width=0 height=0>\n");
    document.write("<param name=src value=../vgmids/Katamari_Rocks.mp3>\n");
    document.write("<param name=loop value=false>\n");
    document.write("<param name=hidden value=true>\n");
    document.write("<param name=volume value=5>\n");
    document.write("</object>\n\n");
}
</SCRIPT -->

<table BORDER="1" WIDTH="650" CELLPADDING=10><tr><td>
<b>
<font face="Arial">
<font size=+2>My complete career statistics</font> (<a href="index00.php" target="_parent">Simple view!</a>)
<BR>
<BR>
<font size=+1>Current total: <?php echo /* count($games) */ mysql_num_rows($game_list_db) ?></font>
<BR>
<BR>
<!-- font size=+1>Last game completed - Phantasy Star Portable 2 Infinity, 11/30/2011</font -->
<?php $most_recent = targetDBRow($recentSQL, $vglink) ?>
<font size=+1>Last game completed - <?php echo $most_recent[0] .", ". $most_recent[1] ?></font>
<BR>
<BR>
<?php echo $most_recent[2] ?>
<BR>
<BR>
<p>
<a href=../home.html target=_top>** Go to the source of the madness **</a>
</p>
</b>
</font><b>
<?php
// procedurized!
//dispGameList($games);
dispGameListSQL($game_list_db);
?>
</b>
<BR>
</font>
</td>
</tr>
</table>

<table BORDER="0" WIDTH="650" CELLPADDING=10><tr><td>
<font face="Arial">
<center>
<p><font size=+1><a href="../home.html" target=_top>The
game of life... the toughest one yet...</a></font>
</p>
<BR>
<P>
<a href=../hyperlink.html target=_top><img src="../gfdotcom/gfdc_ani/akumaten.gif" ALT="Click here to see all Mystic Domain links..." BORDER=0></a>
</center>
</font>
</td>
</tr>
</table>

</BODY>
</HTML>
<?php
mysql_close($vglink);
?>

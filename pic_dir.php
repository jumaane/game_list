<?php
session_start();
$locale = $_SESSION["locale"];
$mobile_flag = $_SESSION["moba"];

include "mdpc_common.php";
include $locale ."/nation_id.php";
?>
<HTML>
<HEAD>
<?php
// (7/5/2011) Mobile flag modifications here!
// [end]

$xdir = $_GET[$nation_id .'dir'];

// (7/25/2011) Due to generalization, first portion is the $locale!
$dir_list[] = $locale;

$dir_list[] = $xdir;

if (isset($_GET[$nation_id .'dir2'])) {
	$xdir2 = $_GET[$nation_id .'dir2'];
	$dir_list[] = $xdir2;
}

$row_count = 0;
$colspan = 3;

// (07/26/2011) Mobile flag determines whether to augment height OR width...
$img_wd = 360;		// Mobile picture width
$img_ht = 150;		// Web base picture height

$gd_imgsrc = ($mobile_flag > 0) ? "moba_thumb" : "thumbnail";
$img_param = ($mobile_flag > 0) ? $img_wd : $img_ht;

$name = "";

$base_url = "http://" . $_SERVER['HTTP_HOST'];
$slashdot = explode('/', $_SERVER['PHP_SELF']);
array_pop($slashdot);
$slash_count = 0;
foreach ($slashdot as $foldir) {
	if ($slash_count > 0)
		$base_url .= "/" . $foldir;
	$slash_count++;
}
$base_url .= "/";

// (7/18/2011) Mobile flag/generalization modification (session variable necessary?)
//$base_url .= $locale;

/*  (03/28/2010) Use of makeFileStrDir() function
echo "<BASE HREF=\"" . $base_url . urlencode($xdir) . "/";
if (isset($xdir2))	{	// defined -> isset
	echo $xdir2 . "/";
}*/
echo "<BASE HREF=\"". $base_url . makeFileStrDir($dir_list, 1) ."\">\n";

//  (07/04/2011) Creating the title
if (isset($xdir2))	{	// defined -> isset
	if (strpos($xdir2, "-"))
		$name = substr($xdir2, (strpos($xdir2, "-")+1));
	else
		$name = $xdir2;
	$name = str_replace("_", " ", $name);
}
else	{
	$name = substr($xdir, (strpos($xdir, "-")+1));
	$name = str_replace("_", " ", $name);
}
?>
<TITLE><?php echo $name ?></TITLE>
</HEAD>

<?php
// (03/28/2010) Text color here
$bgcolor = strlen($name) - 1;	// Just a placeholder here (FYI: strlen() -> length())
$txtclr = strlen($name) - 1;
pgClrCreate($dir_list, $bgcolor, $txtclr)
?>

<BODY BGCOLOR="#<?php echo substr($bgcolor,0,6) ?>" TEXT="#<?php echo substr($txtclr,0,6) ?>">
<SCRIPT LANGUAGE = "Javascript">
// Is the "ref" of these functions specified in "BASE HREF"???
//
// Image.width, height
// document.width, height

function displayPic(photo)	{
	<?php echo $nation_id ?>_image = new Image();
	<?php echo $nation_id ?>_image.src = photo;
//	if (parent.md_pic.document.height < 490)
//		md_image.height = parent.md_pic.document.height - 10;
	<?php echo $nation_id ?>_image.height = 200;
	parent.<?php echo $nation_id ?>_pic.document.images[0].src = eval('<?php echo $nation_id ?>_image.src');
}
</SCRIPT>

<CENTER>

<TABLE BORDER=0 CELLSPACING=3 CELLPADDING=3 WIDTH=100%>

<?php
//$target_dir = "~\\www\\pictures\\japan";
//$target_dir = "C:\\Mystic Domain\\pictures\\japan\\" . $xdir;

// (03/28/2010) Use of makeFileStrDir() function
// (07/25/2010) Mobile/generalized base, must add $locale!
$target_dir = makeFileStrDir($dir_list, 0);
chdir ($target_dir);
$dir_open = srvrIsWin() ? popen("dir /b", "r") : popen("ls", "r");

$dir_out = "";
while (!feof($dir_open)) {
  $dir_out .= fread($dir_open, 128);
}
fclose($dir_open);

$dir_out = explode("\n", $dir_out);

//* (03/28/2010) Use of makeBaseRef() function
$base_ref = makeBaseRef($dir_list);

//*(07/25/2011) Thumbnail-making process should retrieve the locale on its own...
array_shift($dir_list);

foreach ($dir_out as $picture)	{
	if (strpos($picture, ".JPG"))	{
		// (2011/7/4) [mobile_flag] OFF=>long row; ON=long column.
		if (($row_count == 0) || ($mobile_flag > 0)) echo "<TR>\n";
		
		echo "<TD nowrap ALIGN=CENTER>\n";
		// (07/04/2011) The thumbnail IS the picture (in mobile mode).
		if ($mobile_flag == 0) {
			echo "<A onClick=\"displayPic('".$picture."');\" >\n";
		}
		// <作業中>

//		(Normal thumbnails)
//		echo "<IMG SRC=" . $picture . " BORDER=2 HEIGHT=" . $img_ht . "></A><BR>\n";
//
//		(PHP-created thumbnails)
		/* (03/28/2010) Use of $base_ref
		echo "<IMG SRC=../";
		if (isset($xdir2))
			echo "../";
		*/
		echo "<IMG SRC=". $base_ref;
		
		/* (07/18/2011) Working from base, must back-reference base.
		//echo "thumbnail.php?picsrc=" . $picture . "&imgsize=" . $img_ht;
		//echo "&xdir=" . urlencode($xdir);
		//if (isset($xdir2)) echo "&xdir2=" . urlencode($xdir2);
		*/
		/* (07/25/2011) Not necessary???
		//echo "../";
		*/		
		// Continue with selecting correct image source
		echo $gd_imgsrc .".php?picsrc=" . $picture . "&imgsize=" . $img_param ."&". makeQueryStrDir($nation_id, $dir_list);

		
		/* (07/04/2011) No title tags here (nor links).
		//if (!preg_match("/^DSC/i", $picture)) echo " TITLE='" . $picture . "'";
		//echo " BORDER=2></A><BR>\n";
		*/
		echo " BORDER=2>";
		if ($mobile_flag == 0) echo "</A>";
		echo "<BR>\n</TD>";
		
		// (2011/7/4) Go to next row immediately in mobile mode.
		if ($mobile_flag > 0) echo "</TR>\n";
		$row_count++;
	}
}
if (($row_count != 0) && ($mobile_flag == 0)) echo "</TR>\n";

// [edit]
?>
</TABLE>
</CENTER>

</BODY>
</HTML>

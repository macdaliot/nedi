<?php
# Program: Nodes-Stolen.php
# Programmer: Remo Rickli

$printable = 1;
$exportxls = 0;

include_once ("inc/header.php");
include_once ("inc/libnod.php");

$_GET = sanitize($_GET);
$na = isset($_GET['na']) ? $_GET['na'] : "-";
$ip = isset($_GET['ip']) ? $_GET['ip'] : "";
$stl = isset($_GET['stl']) ? strtolower(preg_replace("/[^0-9a-f]/i", "",$_GET['stl'])) : "";
$dev = isset($_GET['dev']) ? $_GET['dev'] : "";
$ifn = isset($_GET['ifn']) ? $_GET['ifn'] : "";
$ord = isset($_GET['ord']) ? $_GET['ord'] : "";
$del = isset($_GET['del']) ? $_GET['del'] : "";

?>
<h1>Stolen Nodes</h1>

<?php
$link	= DbConnect($dbhost,$dbuser,$dbpass,$dbname);

if ($stl){
	$query	= GenQuery('stolen','i','','','',array('name','stlip','mac','device','ifname','usrname','time'),'',array($na,ip2long($ip),$stl,$dev,$ifn,$_SESSION['user'],time()) );
	if( !DbQuery($query,$link) ){echo "<h4>".DbError($link)."</h4>\n";}else{echo "<h5>$stl $updlbl OK</h5>\n";}
}elseif ($del){
	$query	= GenQuery('stolen','d','','','',array('mac'),array('='),array($del) );
	if( !DbQuery($query,$link) ){echo "<h4>".DbError($link)."</h4>\n";}else{echo "<h5>$dellbl $del ok</h5>\n";}
}

if( !isset($_GET['print']) ) { ?>

<table class="content">
<tr class="bgmain">
<td class="ctr s">
	<a href="<?= $self ?>.php"><img src="img/32/<?= $selfi ?>.png" title="<?= $self ?>"></a>
</td>
<td>
	<form method="get" action="<?= $self ?>.php">
		Sort
		<select name="ord" size="1" onChange="submit();">
			<option value="name" <?= ($ord == "name")?" selected":"" ?> ><?= $namlbl ?>

			<option value="stlip" <?= ($ord == "stlip")?" selected":"" ?> >IP <?= $adrlbl ?>

			<option value="mac" <?= ($ord == "mac")?" selected":"" ?> >MAC <?= $adrlbl ?>

			<option value="device" <?= ($ord == "device")?" selected":"" ?> >Device
			<option value="time" <?= ($ord == "updated")?" selected":"" ?> ><?= $timlbl ?>

		</select>
	</form>
</td>
<td class="rgt">
	<form method="get" action="<?= $self ?>.php">
		MAC <input type="text" name="stl" value="<?= $stl ?>" class="m">
</td>
<td class="rgt">
		<?= $namlbl ?> <input type="text" name="na" value="<?= $na ?>" class="m"><br>
		IP <input type="text" name="stlip" value="<?= $ip ?>" class="m">
</td>
<td class="rgt">
		Device <input type="text" name="dev" value="<?= $dev ?>" class="m"><br>
		IF <input type="text" name="ifn" value="<?= $ifn ?>" class="m">

</td>
<td class="ctr s">
		<input type="submit" class="button" value="<?= $addlbl ?>">
	</form>
</td>
</tr>
</table>
<p>

<?php
}

$query	= GenQuery('stolen','s','stolen.*',$ord,'',array(),array(),array(),array(),'LEFT JOIN devices USING (device)');
$res	= DbQuery($query,$link);
if($res){
?>
<h2>Stolen Nodes <?= $lstlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th colspan="3">
			<img src="img/16/node.png"><br>
			Node <?= $inflbl ?>

		</th>
		<th colspan="3">
			<img src="img/16/dev.png"><br>
				Device <?= $laslbl ?>
		</th>
		<th colspan="5">
			<img src="img/16/user.png"><br>
			Stolen <?= $addlbl ?>

		</th>
	</tr>
<?php
	$row = 0;
	while( ($s = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$nquery	= GenQuery('nodes','s','distinct mac,oui,firstseen,lastseen,device,ifname,nodip,aname','','',array('mac'),array('='),array($s[2]),array(),'LEFT JOIN nodarp USING (mac) LEFT JOIN dns USING (nodip)');
		$nres	= DbQuery($nquery,$link);
		$nnod	= DbNumRows($nres);
		if ($nnod == 1) {
			$n = DbFetchRow($nres);
			DbFreeResult($nres);
		}else{
			$n = array($s[0],$s[1],$s[2],'-',0,0,'Not in nodes','-');
		}
		$ls	= date($_SESSION['timf'],$n[3]);
		list($fc,$lc) = Agecol($n[2],$n[3],$row % 2);
		$ip	= long2ip($n[6]);
		$na	= preg_replace("/^(.*?)\.(.*)/","$1", $n[7]);
		$sup	= date($_SESSION['timf'],$s[6]);
		$simg	= "";
		list($s1c,$s2c) = Agecol($s[6],$s[6],$row % 2);
		if ($n[3] > $s[6]){$bi = "alrm";}

		echo "\t<tr class=\"$bg\">\n";
		echo "\t\t<td class=\"$bi ctr b m\">\n\t\t\t<a href=\"Nodes-Status.php?mac=$n[0]\"><img src=\"img/oui/".Nimg("$n[0];$n[1]").".png\" title=\"Nodes-Status\"></a><br>\n\t\t\t$s[2]\n\t\t</td>\n";
		echo "\t\t<td>\n\t\t\t".preg_replace("/^(.*?)\.(.*)/","$1", $n[7])."\n\t\t</td>\n\t\t<td>\n\t\t\t".long2ip($n[6])."\n\t\t</td>\n";
		echo "\t\t<td>\n\t\t\t$n[4]\n\t\t</td>\n\t\t<td>\n\t\t\t$n[5]\n\t\t</td>\n";
		echo "\t\t<td style=\"background-color:#$lc\">\n\t\t\t$ls\n\t\t</td>\n";
		echo "\t\t<td>\n\t\t\t$s[3]\n\t\t</td>\n\t\t<td>\n\t\t\t$s[4]\n\t\t</td>\n";
		echo "\t\t<td style=\"background-color:#$s1c\">\n\t\t\t$sup\n\t\t</td>\n\t\t<td>\n\t\t\t$s[5]\n\t\t</td>\n";
		echo "\t\t<td class=\"ctr s\" >\n\t\t\t<a href=\"?del=$s[2]\"><img src=\"img/16/bcnl.png\" onclick=\"return confirm('$dellbl $s[2]?')\"></a>\n\t\t</td>\n";
		echo "\t</tr>\n";
	}
	DbFreeResult($res);
}else{
	print DbError($link);
}
TblFoot("bgsub", 11, "$row Nodes".(($ord)?", $srtlbl: $ord":"") );

include_once ("inc/footer.php");
?>

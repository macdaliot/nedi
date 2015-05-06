<?php
# Program: Monitoring-Health.php
# Programmer: Remo Rickli

error_reporting(E_ALL ^ E_NOTICE);

$printable = 1;
$exportxls = 0;

$refresh   = 60;
$firstmsg  = time() - 86400;

include_once ("inc/header.php");
include_once ("inc/libdev.php");
include_once ("inc/libmon.php");
include_once ("inc/librep.php");

$_GET = sanitize($_GET);
$reg = isset($_GET['reg']) ? $_GET['reg'] : "";
$cty = isset($_GET['cty']) ? $_GET['cty'] : "";
$bld = isset($_GET['bld']) ? $_GET['bld'] : "";

?>
<h1>Monitoring Master</h1>

<form method="get" name="dynfrm" action="<?= $self ?>.php">
<table class="content"><tr class="bgmain">
<td class="ctr s">
	<a href="<?= $self ?>.php"><img src="img/32/<?= $selfi ?>.png" title="<?= $self ?>"></a>
</td>
<td class="ctr top">
	<h3><?= $stalbl ?></h3>

<?php
$link = DbConnect($dbhost,$dbuser,$dbpass,$dbname);
list($nmon,$lastok,$monal,$deval,$slow) = TopoMon($loc);

StatusMon( $_SESSION['gsiz'] );
?>

</td>
<td class="ctr top">
	<h3><?= $inclbl ?> <?= $notlbl ?> <?= $acklbl ?></h3>
<?php
StatusIncidents($loc,$_SESSION['gsiz'],1);
?>

</td>
<td class="ctr s">
	<span id="counter"><?= $refresh ?></span>
	<img src="img/16/exit.png" title="Stop" onClick="stop_countdown(interval);">
</td>
</tr>
</table>
</form>
<p>

<h2><?= $msglbl ?> <?= $tim['t'] ?></h2>

<table class="full"><tr><td class="helper qrt">

<h3>Devices</h3>
<?php
	$query	= GenQuery('events','g','device,readcomm','cnt desc',$_SESSION['lim'],array('time','location'),array('>','~'),array($firstmsg,$loc),array('AND'),'LEFT JOIN devices USING (device)');
	$res	= DbQuery($query,$link);
	if($res){
		$nlev = DbNumRows($res);
		if($nlev){
?>
<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/dev.png"><br>
			Device
		</th>
		<th>
			<img src="img/16/bell.png"><br>
			<?= $msglbl ?>

		</th>
		<th>
			<img src="img/16/cog.png"><br>
			<?= $cmdlbl ?>

		</th>
<?php
			$row = 0;
			while( ($r = DbFetchRow($res)) ){
				if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
				$row++;
				$s    = substr($r[0],0,$_SESSION['lsiz']);		# Shorten labels
				$mbar = Bar($r[2],0,'si');
				$ud   = urlencode($r[0]);
				TblRow($bg);
				TblCell( $r[0],"Devices-Status.php?dev=$ud","$bi b" );
				TblCell( "$mbar $r[2]","Monitoring-Events.php?in[]=device&op[]==&st[]=$ud&co[]=AND&in[]=time&op[]=>&st[]=$firstmsg",'nw' );
				TblCell( "<a href=\"$r[1]://$ud/Monitoring-Health.php\"><img src=\"img/16/hlth.png\" title=\"$r[0] Health\"></a>\n".
					 "\t\t\t<a href=\"$r[1]://$ud/Monitoring-Setup.php\"><img src=\"img/16/bino.png\" title=\"$r[0] $monlbl $cfglbl\"></a>\n".
					 "\t\t\t<a href=\"$r[1]://$ud/Reports-Combination.php?in[]=&op[]=~&st[]=&rep=mon\"><img src=\"img/16/chrt.png\" title=\"$r[0] $inclbl $sumlbl\"></a>\n".
					 "\t\t\t<a href=\"$r[1]://$ud/Reports-Monitoring.php?rep[]=lat&rep[]=evt\"><img src=\"img/16/dbin.png\" title=\"$r[0] $monlbl $stslbl\"></a>\n".
					 "\t\t\t<a href=\"$r[1]://$ud/System-Services.php\"><img src=\"img/16/cog.png\" title=\"$r[0] $srvlbl\"></a>\n"
					,'','ctr nw' );
				echo "\t</tr>\n";
			}
			echo "</table>\n";
		}else{
			echo "<p>\n<h5>$nonlbl</h5>\n";
		}
		DbFreeResult($res);
	}else{
		print DbError($link);
	}
?>

</td><td class="helper tqrt">

<h3><?= $mlvl[200] ?> & <?= $mlvl[250] ?> <?= $lstlbl ?></h3>
<?php

Events($_SESSION['lim'],array('level','time','location'),array('>=','>','~'),array(200,$firstmsg,$loc),array('AND','AND'),2);

echo "\n</td></tr></table>\n\n";
if($_SESSION['opt']){
	MonAvail('','','',$_SESSION['lim'],'');
}

include_once ("inc/footer.php");

?>

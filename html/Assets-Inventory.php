<?php
# Program: Assets-Inved.php
# Programmer: Remo Rickli

$printable = 1;
$exportxls = 0;
if( isset($_GET['lst']) ){$exportxls = 1;}

include_once ("inc/header.php");
include_once ("inc/libdev.php");
$_GET = sanitize($_GET);
$chg = isset($_GET['chg']) ? $_GET['chg'] : "";
$add = isset($_GET['add']) ? $_GET['add'] : "";
$upd = isset($_GET['upd']) ? $_GET['upd'] : "";
$del = isset($_GET['del']) ? $_GET['del'] : "";

$csv = isset($_POST['csv']) ? $_POST['csv'] : "";

$lst = isset($_GET['lst']) ? $_GET['lst'] : "";
$val = isset($_GET['val']) ? $_GET['val'] : "";

$link	= DbConnect($dbhost,$dbuser,$dbpass,$dbname);
if($chg){
	$query	= GenQuery('inventory','s','*','','',array('serial'),array('='),array($chg) );
	$res	= DbQuery($query,$link);
	$nitm	= DbNumRows($res);
	if ($nitm != 1) {
		echo "<h4>$chg: $nitm $vallbl!</h4>";
		DbFreeResult($res);
	}else{
		$item = DbFetchRow($res);
	}
	DbFreeResult($res);
	$st = $item[0];
	$sn = $item[1];
	$cl = $item[2];
	$ty = $item[3];
	$an = $item[4];
	$lo = $item[5];
	$co = $item[6];

	$au = date("m/d/Y",$item[7]);
	$ps = $item[8];
	$pc = $item[9];
	$pn = $item[10];
	$pt = date("m/d/Y",$item[10]);

	$ew = date("m/d/Y",$item[19]);
	$es = date("m/d/Y",$item[20]);
	$el = date("m/d/Y",$item[21]);

	$mp = $item[12];
	$sl = $item[13];
	$md = $item[14];
	$mc = $item[15];
	$ms = $item[16];
	$sm = date("m/d/Y",$item[17]);
	$em = date("m/d/Y",$item[18]);


	$com = $item[22];
	$usr = $item[23];
}else{
	$st = isset($_GET['st']) ? $_GET['st'] : (($lst == 'st') ? $val : 10);
	$sn = isset($_GET['sn']) ? $_GET['sn'] : "";
	$cl = isset($_GET['cl']) ? $_GET['cl'] : (($lst == 'cl') ? $val : '');
	$ty = isset($_GET['ty']) ? $_GET['ty'] : (($lst == 'ty') ? $val : '');
	$an = isset($_GET['an']) ? $_GET['an'] : (($lst == 'an') ? $val : '');
	$lo = isset($_GET['lo']) ? $_GET['lo'] : (($lst == 'lo') ? $val : '');
	$co = isset($_GET['co']) ? $_GET['co'] : (($lst == 'co') ? $val : '');

	$ps = isset($_GET['ps']) ? $_GET['ps'] : (($lst == 'ps') ? $val : '');
	$pc = isset($_GET['pc']) ? $_GET['pc'] : (($lst == 'pc') ? $val : '');
	$pn = isset($_GET['pn']) ? $_GET['pn'] : (($lst == 'pn') ? $val : '');
	$pt = isset($_GET['pt']) ? $_GET['pt'] : (($lst == 'pt') ? $val : '');
	$ew = isset($_GET['ew']) ? $_GET['ew'] : (($lst == 'ew') ? $val : '');
	$es = isset($_GET['es']) ? $_GET['es'] : (($lst == 'es') ? $val : '');
	$el = isset($_GET['el']) ? $_GET['el'] : (($lst == 'el') ? $val : '');

	$mp = isset($_GET['mp']) ? $_GET['mp'] : (($lst == 'mp') ? $val : '');
	$sl = isset($_GET['sl']) ? $_GET['sl'] : (($lst == 'sl') ? $val : '');
	$md = isset($_GET['md']) ? $_GET['md'] : (($lst == 'md') ? $val : '');
	$mc = isset($_GET['mc']) ? $_GET['mc'] : (($lst == 'mc') ? $val : '');
	$ms = isset($_GET['ms']) ? $_GET['ms'] : (($lst == 'ms') ? $val : '');
	$sm = isset($_GET['sm']) ? $_GET['sm'] : (($lst == 'sm') ? $val : '');
	$em = isset($_GET['em']) ? $_GET['em'] : (($lst == 'em') ? $val : '');

	$com = isset($_GET['com']) ? preg_replace('/[\r\n]+/', ' ', $_GET['com']) : '';
}

echo strtotime('');
?>
<h1><?= $invlbl ?> <?= $edilbl ?></h1>

<?php  if( !isset($_GET['print']) and !isset($_GET['xls']) ) { ?>
<form method="get" action="<?= $self ?>.php" name="bld">
<table class="content"><tr class="bgmain">
<td class="ctr s">
	<a href="<?= $self ?>.php"><img src="img/32/<?= $selfi ?>.png" title="<?= $self ?>"></a>
</td>
<td class="top">
	<h3><?= $igrp['20'] ?></h3>
	<img src="img/16/bchk.png" title="<?= $stalbl ?>">
	<select size="1" name="st">
<?php
foreach (array_keys($stco) as $c){
	echo "		<option value=\"$c\" ".( ($c == $st)?" selected":"").">$stco[$c]\n";
}
?>
	</select><br>
	<img src="img/16/key.png"> <input type="text" title="<?= $serlbl ?>" placeholder="<?= $serlbl ?>" name="sn" value="<?= $sn ?>" class="m" OnFocus="select();" <?= (($chg)?"readonly":"") ?> autofocus><br>
	<img src="img/16/form.png"> <input type="text" title="<?= $asnlbl ?>" placeholder="<?= $asnlbl ?>" name="an" value="<?= $an ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/abc.png" OnClick="window.open('inc/browse-img.php?t=p','Panels','scrollbars=1,menubar=0,resizable=1,width=600,height=800');">
	<input type="text" title="<?= $typlbl ?>" placeholder="<?= $typlbl ?>" name="ty" value="<?= $ty ?>" class="m" OnFocus="select();" title="<?= $sellbl ?> <?= $imglbl ?>">
	<input type="text" title="<?= $clalbl ?>" placeholder="<?= $clalbl ?>" name="cl" value="<?= $cl ?>" class="xs" OnFocus="select();"><br>
	<img src="img/16/home.png"> <input type="text" title="<?= $loclbl ?>" placeholder="<?= $loclbl ?>" name="lo" value="<?= $lo ?>" class="l" OnFocus="select();"><br>
	<img src="img/16/user.png"> <input type="text" title="<?= $conlbl ?>" placeholder="<?= $conlbl ?>" name="co" value="<?= $co ?>" class="l" OnFocus="select();">
</td>
<td class="top">
	<h3><?= $purlbl ?>/<?= $venlbl ?></h3>
	<img src="img/16/umgr.png"> <input type="text" title="<?= $srclbl ?>" placeholder="<?= $srclbl ?>" name="ps" value="<?= $ps ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/cash.png"> <input type="text" title="<?= $coslbl ?>" placeholder="<?= $coslbl ?>" name="pc" value="<?= $pc ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/form.png"> <input type="text" title="<?= $purlbl ?> <?= $numlbl ?>" placeholder="<?= $numlbl ?>" name="pn" value="<?= $pn ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/date.png"> <input type="text" title="<?= $purlbl ?> <?= $datlbl ?>" placeholder="<?= $datlbl ?>" name="pt" id="pt" value="<?= $pt ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/glok.png"> <input type="text" title="<?= $venlbl ?> <?= $wtylbl ?> <?= $endlbl ?>" placeholder="<?= $wtylbl ?> <?= $endlbl ?> " name="ew" id="ew" value="<?= $ew ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/cog.png"> <input type="text" title="<?= $venlbl ?> <?= $srvlbl ?> <?= $endlbl ?>" placeholder="<?= $srvlbl ?> <?= $endlbl ?> " name="es" id="es" value="<?= $es ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/bdis.png"> <input type="text" title="EoL" placeholder="EoL " name="el" id="el" value="<?= $el ?>" class="m" OnFocus="select();">
</td>
<td class="top">
	<h3><?= $igrp['31'] ?></h3>
	<img src="img/16/brld.png" title="<?= $stalbl ?>">
	<select size="1" name="ms">
		<option value="0" <?= ($ms == 0)?" selected":"" ?>>-
		<option value="100" <?= ($ms == 1)?" selected":"" ?>><?= $renlbl ?>
	</select><br>
	<img src="img/16/dril.png"> <input type="text" title="<?= $igrp['31'] ?> <?= $igrp['17'] ?>" placeholder="<?= $igrp['17'] ?>" name="mp" value="<?= $mp ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/tool.png"> <input type="text" title="<?= $srvlbl ?> <?= $levlbl ?>" placeholder="<?= $srvlbl ?> <?= $levlbl ?>" name="sl" value="<?= $sl ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/find.png"> <input type="text" title="<?= $igrp['31'] ?> <?= $deslbl ?>" placeholder="<?= $deslbl ?>" name="md" value="<?= $md ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/cash.png"> <input type="text" title="<?= $coslbl ?>" placeholder="<?= $coslbl ?>" name="mc" value="<?= $mc ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/bblf.png"> <input type="text" title="<?= $igrp['31'] ?> <?= $sttlbl ?>" placeholder="<?= $sttlbl ?>" name="sm" id="sm" value="<?= $sm ?>" class="m" OnFocus="select();"><br>
	<img src="img/16/bbrt.png"> <input type="text" title="<?= $igrp['31'] ?> <?= $endlbl ?>" placeholder="<?= $endlbl ?>" name="em" id="em" value="<?= $em ?>" class="m" OnFocus="select();">
	<script type="text/javascript" src="inc/datepickr.js"></script>
	<link rel="stylesheet" type="text/css" href="inc/datepickr.css" />
	<script>
	new datepickr('pt', {'dateFormat': 'm/d/y'});
	new datepickr('ew', {'dateFormat': 'm/d/y'});
	new datepickr('es', {'dateFormat': 'm/d/y'});
	new datepickr('el', {'dateFormat': 'm/d/y'});
	new datepickr('sm', {'dateFormat': 'm/d/y'});
	new datepickr('em', {'dateFormat': 'm/d/y'});
	</script>
</td>
<td class="ctr top">
	<h3><?= $cmtlbl ?></h3>
	<textarea rows="8" name="com" cols="20" placeholder="<?= $cmtlbl ?>"><?= $com ?></textarea><br>
	<input type="hidden" value="<?= $lst ?>" name="lst">
	<input type="hidden" value="<?= $val ?>" name="val">
<?php
if($chg or $upd or $add){
	echo "	<input type=\"submit\" class=\"button\" value=\"$updlbl\" name=\"upd\">\n";
	echo "	<input type=\"submit\" class=\"button\" value=\"$dellbl\" name=\"del\">\n";
}else{
	echo "	<input type=\"submit\" class=\"button\" value=\"$addlbl\" name=\"add\">\n";
}
?>
</form>
</td>
<td class="ctr top">
	<h3>CSV <?= $implbl ?></h3>
	<form method="post" action="<?= $self ?>.php" name="imp" enctype="multipart/form-data">
		<img src="img/16/clip.png" title="<?= $fillbl ?>">
		<input name="csv" class="s" type="file" accept="accept=".csv" onchange="this.form.submit();">
	</form>
</td>
</tr>
</table>
<p>

<script type="text/javascript">
<?php
if($chg){
	echo "document.add.lo.focus();\n";
}else{
	echo "document.add.sn.focus();\n";
}
?>
</script>
<?php
}

#echo strtotime("17.Sep.2000"), "\n";

if( array_key_exists('csv',$_FILES) ){
	if( file_exists($_FILES['csv']['tmp_name']) ){
		$lines = file( $_FILES['csv']['tmp_name'] );
		array_shift($lines);
		array_shift($lines);
		array_shift($lines);

		$inv = array();
		$query	= GenQuery('inventory','s','serial');
		$res	= DbQuery($query,$link);
		if($res){
			while( $i = DbFetchRow($res) ){
				$inv[$i[0]] = 1;
			}
			DbFreeResult($res);
		}

		$nosn = 0;
		$insn = 0;
		$upsn = 0;
		foreach ($lines as $l){
			$f = explode(";", $l);
			$em = strtotime( preg_replace('/^(\d+)\.(\d+)\.(\d+)$/','$2/$1/$3',$f[10]) );
			#$ew = strtotime( preg_replace('/^(\d+)\.(\d+)\.(\d+)$/','$2/$1/$3',$f[11]) );
			$es = strtotime( preg_replace('/^(\d+)\.(\d+)\.(\d+)$/','$2/$1/$3',$f[12]) );
			$el = strtotime( preg_replace('/^(\d+)\.(\d+)\.(\d+)$/','$2/$1/$3',$f[13]) );
			$sn = $f[2];
			if(!$f[2]) $sn = $f[4];
			if( $sn == '' ){
				$nosn++;
			}elseif( array_key_exists($sn,$inv) ){
				$query	= GenQuery('inventory','u',"serial = '".DbEscapeString($sn)."'",'','',
						array('assettype','assetlocation','assetcontact','assetupdate','maintsla','maintdesc','maintstatus','endmaint','endwarranty','endsupport','endlife','comment','usrname'),
						array(),
						array($f[1],"$f[7]$locsep$f[6]",$f[5],time(),$f[0],$f[8],(($f[9]=='Ja')?1:0),(($em)?$em:0),(($ew)?$ew:0),(($es)?$es:0),(($el)?$el:0),$_FILES['csv']['name'],$_SESSION['user']) );
				if( DbQuery($query,$link) ){
					$upsn++;
				}else{
					echo "<h4>".DbError($link)."</h4>\n";
				}
			}else{
				$query	= GenQuery('inventory','i','','','',
						array('state','serial','assettype','assetlocation','assetcontact','assetupdate','maintsla','maintdesc','maintstatus','endmaint','endwarranty','endsupport','endlife','comment','usrname'),
						array(),
						array(250,$sn,$f[1],"$f[7]$locsep$f[6]",$f[5],time(),$f[0],$f[8],(($f[9]=='Ja' or $f[9]=='Yes')?1:0),(($em)?$em:0),(($ew)?$ew:0),(($es)?$es:0),(($el)?$el:0),$_FILES['csv']['name'],$_SESSION['user']) );
				if( DbQuery($query,$link) ){
					$insn++;
				}else{
					echo "<h4>".DbError($link)."</h4>\n";
				}
			}
		}
		echo "<h5>$insn $addlbl, $upsn $updlbl, $nosn $nonlbl $serlbl</h5>\n";
	}
}

$pts = max(0, strtotime( preg_replace("/\s.*$/", "", $pt) ) );						# avoid negative timestamps due to cutting off time from string
$sms = max(0, strtotime( preg_replace("/\s.*$/", "", $sm) ) );
$ems = max(0, strtotime( preg_replace("/\s.*$/", "", $em) ) );
$ews = max(0, strtotime( preg_replace("/\s.*$/", "", $ew) ) );
$ess = max(0, strtotime( preg_replace("/\s.*$/", "", $es) ) );
$els = max(0, strtotime( preg_replace("/\s.*$/", "", $el) ) );

if ($add and $sn and $ty){
	$query	= GenQuery('inventory','i','','','',
			array('state','serial','assetclass','assettype','assetnumber','assetlocation','assetcontact','assetupdate','pursource','purcost','purnumber','purtime','maintpartner','maintsla','maintdesc','maintcost','maintstatus','startmaint','endmaint','endwarranty','endsupport','endlife','comment','usrname'),
			array(),
			array($st,$sn,$cl,$ty,$an,$lo,$co,time(),$ps,$pc,$pn,$pts,$mp,$sl,$md,$mc,$ms,$sms,$ems,$ews,$ess,$els,$com,$_SESSION['user']) );
	if( !DbQuery($query,$link) ){echo "<h4>".DbError($link)."</h4>";}else{echo "<h5>$serlbl $sn $addlbl OK</h5>";}
}elseif ($upd and $sn and $ty){
	$query	= GenQuery('inventory','u',"serial = '".DbEscapeString($sn)."'",'','',
			array('state','assetclass','assettype','assetnumber','assetlocation','assetcontact','assetupdate','pursource','purcost','purnumber','purtime','maintpartner','maintsla','maintdesc','maintcost','maintstatus','startmaint','endmaint','endwarranty','endsupport','endlife','comment','usrname'),
			array(),
			array($st,$cl,$ty,$an,$lo,$co,time(),$ps,$pc,$pn,$pts,$mp,$sl,$md,$mc,$ms,$sms,$ems,$ews,$ess,$els,$com,$_SESSION['user']) );
	if( !DbQuery($query,$link) ){echo "<h4>".DbError($link)."</h4>";}else{echo "<h5>$serlbl $sn $updlbl OK</h5>";}
}elseif($del ){
	$query	= GenQuery('inventory','d','','','',array('serial'),array('='),array($sn) );
	if( !DbQuery($query,$link) ){echo "<h4>".DbError($link)."</h4>";}else{echo "<h5>$serlbl $del $dellbl OK</h5>";}
}

if($lst){
	if($lst == "st"){
		echo "<h2>$stalbl \"$stco[$val]\" $lstlbl</h2>\n";
		$col = "state";
	}elseif($lst == "ty"){
		echo "<h2>$typlbl \"$val\" $lstlbl</h2>\n";
		$col = "assettype";
	}elseif($lst == "cl"){
		list($mcl,$img) = ModClass($val);
		echo "<h2>$clalbl \"$mcl\" $lstlbl</h2>\n";
		$col = "assetclass";
	}elseif($lst == "lo"){
		echo "<h2>$loclbl \"$val\" $lstlbl</h2>\n";
		$col = "assetlocation";
	}elseif($lst == "co"){
		echo "<h2>$conlbl \"$val\" $lstlbl</h2>\n";
		$col = "assetcontact";
	}elseif($lst == "ps"){
		echo "<h2>$srclbl \"$val\" $lstlbl</h2>\n";
		$col = "pursource";
	}elseif($lst == "ms"){
		echo "<h2>$renlbl \"$val\" $lstlbl</h2>\n";
		$col = "maintstatus";
	}elseif($lst == "mp"){
		echo "<h2>$igrp[14] \"$val\" $lstlbl</h2>\n";
		$col = "maintpartner";
	}elseif($lst == "sl"){
		echo "<h2>SLA \"$val\" $lstlbl</h2>\n";
		$col = "maintsla";
	}elseif($lst == "sm"){
		echo "<h2>$stalbl $igrp[31] \"".date($_SESSION['datf'],$val)."\" $lstlbl</h2>\n";
		$col = "startmaint";
	}elseif($lst == "em"){
		echo "<h2>$endlbl $igrp[31] \"".date($_SESSION['datf'],$val)."\" $lstlbl</h2>\n";
		$col = "endmaint";
	}
?>

<table class="content">
	<tr class="bgsub">
<?php
	TblCell('','','xs','','th');
	TblCell($serlbl,'','',"+<img src=\"img/16/key.png\"><br>",'th');
	if($lst != "ty") TblCell($typlbl,'','',"+<img src=\"img/16/abc.png\"><br>",'th');
	if($lst != "lo") TblCell($loclbl,'','',"+<img src=\"img/16/home.png\"><br>",'th');
	if($lst != "co") TblCell($conlbl,'','',"+<img src=\"img/16/user.png\"><br>",'th');
	if($lst != "ps") TblCell($srclbl,'','',"+<img src=\"img/16/umgr.png\"><br>",'th');
	if($lst != "mp") TblCell($igrp['17'],'','',"+<img src=\"img/16/dril.png\"><br>",'th');
	if($lst != "sl") TblCell('SLA','','',"+<img src=\"img/16/form.png\"><br>",'th');
	if($lst != "ms") TblCell($stalbl,'','',"+<img src=\"img/16/brld.png\"><br>",'th');
	if($lst != "sm") TblCell($sttlbl,'','',"+<img src=\"img/16/bblf.png\"><br>",'th');
	if($lst != "em") TblCell($endlbl,'','',"+<img src=\"img/16/bbrt.png\"><br>",'th');
	TblCell($deslbl,'','',"+<img src=\"img/16/find.png\"><br>",'th');
	echo "\t</tr>\n";

	$query	= GenQuery('inventory','s','*','assettype,serial','',array("$col"),array('='),array("$val") );
	$res	= DbQuery($query,$link);
	if($res){
		$row = 0;
		$uv  = urlencode($val);
		while( ($item = DbFetchRow($res)) ){
			if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
			$row++;
			list($mcl,$img) = ModClass($item[2]);
			TblRow($bg);
			TblCell( '','',"$bi ctr xs","+".Staimg($item[0]) );
			TblCell( $item[1],"?chg=".urlencode($item[1])."&lst=$lst&val=$uv" );
			if($lst != "ty") TblCell( $item[3],"?lst=ty&val=".urlencode($item[3]),'',"+<img src=\"img/16/$img.png\" title=\"$mcl\">" );
			if($lst != "lo") TblCell( $item[5],"?lst=lo&val=".urlencode($item[5]) );
			if($lst != "co") TblCell( $item[6],"?lst=co&val=".urlencode($item[6]) );
			if($lst != "ps") TblCell( $item[8],"?lst=ps&val=".urlencode($item[8]) );
			if($lst != "mp") TblCell( $item[12],"?lst=mp&val=".urlencode($item[12]) );
			if($lst != "sl") TblCell( $item[13],"?lst=sl&val=".urlencode($item[13]) );
			if($lst != "ms") TblCell( ($item[16])?$renlbl:'-',"?lst=ms&val=".urlencode($item[16]),'ctr' );
			if($lst != "sm") TblCell( ($item[17])?date($_SESSION['datf'],$item[17]):'-',"?lst=sm&val=$item[17]",' nw' );
			if($lst != "em") TblCell( ($item[18])?date($_SESSION['datf'],$item[18]):'-',"?lst=em&val=$item[18]",SupportBg($item[18]).' nw' );
			TblCell( $item[14] );
			echo "\t</tr>\n";
		}
		DbFreeResult($res);
	}else{
		print DbError($link);
	}
	TblFoot("bgsub", 16, "$row $vallbl");

	include_once ("inc/footer.php");
	exit;
}
?>

<table class="full fixed"><tr><td class="helper">

<h2><?= $invlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/abc.png"><br>
			<?= $typlbl ?>

		</th>
		<th>
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>

		</th>
	</tr>
<?php
$query	= GenQuery('inventory','g','assettype,assetclass');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[2],-10,'mi');
		list($mcl,$img) = ModClass($item[1]);
		TblRow($bg);
		TblCell( $item[0],"?lst=ty&val=".urlencode($item[0]),'nw',"+<a href=\"?lst=cl&val=$item[1]\"><img src=\"img/16/$img.png\" title=\"$mcl\"></a>" );
		TblCell( $item[2],"Assets-List.php?in[]=assettype&op[]==&st[]=".urlencode($item[0]),'',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

</td><td class="helper">

<h2><?= ($verb1)?"$laslbl $chglbl":"$chglbl $laslbl" ?></h2>

<table class="content">
	<tr class="bgsub">
		<th colspan="2">
			<img src="img/16/abc.png"><br>
			<?= $typlbl ?>
		</th>
		<th>
			<img src="img/16/clock.png"><br>
			<?= $updlbl ?>

		</th>
		<th>
			<img src="img/16/user.png"><br>
			<?= $usrlbl ?>

		</th>
		<th><img src="img/16/say.png"><br>
		<?= $cmtlbl ?>

		</th>
	</tr>
<?php
$query	= GenQuery('inventory','s','*','assetupdate desc',$_SESSION['lim']);
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		list($auc,$auc) = Agecol($item[7],$item[7],$row % 2);
		list($mcl,$img) = ModClass($item[2]);
		TblRow($bg);
		TblCell( '','',"$bi ctr xs","+".Staimg($item[0]) );
		TblCell( $item[3],"?lst=ty&val=".urlencode($item[3]),'nw',"+<img src=\"img/16/$img.png\" title=\"$mcl\">" );
		TblCell( date($_SESSION['datf'],$item[7]),'','nw','',"background-color:#$auc" );
		TblCell( $item[23] );
		TblCell( $item[22] );
		echo "\t</tr>\n";
	}
}
?>
</table>

<h2><?= $loclbl ?> <?= $sumlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/home.png"><br>
			<?= $loclbl ?>
		</th>
		<th class="l">
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>
		</th>
	</tr>
<?php
$query	= GenQuery('inventory','g','assetlocation');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[1],0,'mi');
		TblRow($bg);
		TblCell( $item[0],"?lst=lo&val=".urlencode($item[0]) );
		TblCell( $item[1],'','',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

<h2><?= $srclbl ?> <?= $sumlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/umgr.png"><br>
			<?= $srclbl ?>

		</th>
		<th class="l">
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>

		</th>
	</tr>
<?php
$query	= GenQuery('inventory','g','pursource');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[1],0,'mi');
		TblRow($bg);
		TblCell( $item[0],"?lst=ps&val=".urlencode($item[0]) );
		TblCell( $item[1],'','',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

<h2><?= $igrp['17'] ?> <?= $sumlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/dril.png"><br>
			<?= $igrp['17'] ?>

		</th>
		<th class="l">
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>

		</th>
	</tr>
<?php
$query	= GenQuery('inventory','g','maintpartner');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[1],0,'mi');
		TblRow($bg);
		TblCell( $item[0],"?lst=mp&val=".urlencode($item[0]) );
		TblCell( $item[1],'','',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

<h2><?= $stalbl ?> <?= $sumlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th colspan="2">
			<img src="img/16/bchk.png"><br>
			<?= $stalbl ?>

		</th>
		<th class="l">
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>

		</th>
<?php
$query	= GenQuery('inventory','g','state');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[1],0,'mi');
		TblRow($bg);
		TblCell( '','',"$bi xs",'+'.Staimg($item[0]) );
		TblCell( $stco[$item[0]],"?lst=st&val=".urlencode($item[0]) );
		TblCell( $item[1],'','',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

<h2><?= $renlbl ?> <?= $sumlbl ?></h2>

<table class="content">
	<tr class="bgsub">
		<th>
			<img src="img/16/brld.png"><br>
			<?= $stalbl ?>

		</th>
		<th class="l">
			<img src="img/16/form.png"><br>
			<?= $qtylbl ?>

		</th>
<?php
$query	= GenQuery('inventory','g','maintstatus');
$res	= DbQuery($query,$link);
if($res){
	$row = 0;
	while( ($item = DbFetchRow($res)) ){
		if ($row % 2){$bg = "txta"; $bi = "imga";}else{$bg = "txtb"; $bi = "imgb";}
		$row++;
		$stbar = Bar($item[1],0,'mi');
		TblRow($bg);
		TblCell( ($item[0])?$renlbl:'-',"?lst=ms&val=".urlencode($item[0]) );
		TblCell( $item[1],'','',$stbar );
		echo "\t</tr>\n";
	}
}
?>
</table>

</td></tr></table>

<?php
include_once ("inc/footer.php");
?>

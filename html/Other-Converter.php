<?php
# Program: Other-Converter.php
# Programmer: Remo Rickli

$printable = 1;
$exportxls = 0;

include_once ("inc/header.php");

$_GET = sanitize($_GET);
$txt  = isset($_GET['txt']) ? $_GET['txt'] : "";

if( !isset($_GET['print']) ) {
?>
<h1>Text Converter</h1>

<form method="get" action="<?= $self ?>.php">
<table class="content" >
<tr class="bgmain">
<td class="ctr s">
	<a href="<?= $self ?>.php"><img src="img/32/<?= $selfi ?>.png" title="<?= $self ?>"></a>
</td>
<td class="ctr">
	<?= $inflbl ?>: <input type="text" name="txt" value="<?= $txt ?>" class="xl" onfocus="select();">
</td>
<td class="ctr s">
	<input type="submit" class="button" value="<?= $sholbl ?>">
</td>
</tr>
</table>
</form>
<p>

<?php
}

?>
<h2>Decimal, ASCII, HEX</h2>

<table class="content fixed" >
	<tr class="bgsub">
<?php

$ord = preg_split('/\D/', $txt);
for($i=0;$i<count($ord);$i++){
	echo "\t\t<td>\n\t\t\t$i\n\t\t</td>\n";
}

?>
	</tr>
	<tr class="txta code">
<?php

foreach ($ord as $o){
	echo "\t\t<td>\n\t\t\t$o\n\t\t</td>\n";
}

?>
	</tr>
	<tr class="txtb code">
<?php

foreach ($ord as $o){
	if($o > 31 and $o < 122){
		echo "\t\t<td>\n\t\t\t".chr($o)."\n\t\t</td>\n";
	}else{
		echo "\t\t<td>\n\t\t\t\n\t\t</td>\n";
	}
}

?>
	</tr>
	<tr class="txta code">
<?php

foreach ($ord as $o){
	echo "\t\t<td>\n\t\t\t".dechex($o)."\n\t\t</td>\n";
}
?>
	</tr>
</table>

<?php
include_once ("inc/footer.php");
?>

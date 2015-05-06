<?php
# This file can be used to add links for each interface in Device-Status, with the variables from devtools.php plus those:
# $in		IF name
# $ui		URL encoded IF name
# $ifl[$in]	IF alias
# $ifv[$in]	IF PVID

echo ($ifl[$i])?"<a href=\"Devices-Interfaces.php?in[]=alias&op[]=%3D&st[]=".urlencode($ifl[$i])."\"><img src=\"img/16/abc.png\" title=\"Alias $lstlbl\"></a>":"";

?>

<a href="System-Export.php?act=c&exptbl=links&sep=%3B&query=<?= urlencode("SELECT * FROM nbrtrack WHERE device = '$dv' AND ifname='$in'") ?>"><img src="img/16/flop.png" title="<?= $nbrlbl ?>"></a>
			
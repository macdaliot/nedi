<!--

- This document can be edited as needed. It'll be included in Monitoring-Health, if # Columns is set to 0 in User-Profile
- Click on Monitor in Topology-Map to add current map on the bottom of this file
- The following code is an example for a single image holding cycling maps (e.g. for a NOC display)

-->
<a href="javascript:linkto()"><img name="map" class="genpad bctr" src="img/32/paint.png"></a>

<script language="javascript">

	maps = new Array(
			"in[]=snmpversion&op[]=>&st[]=1&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&tit=Network&dim=1024x600&fmt=png&lev=4&mde=f&xo=0&yo=0&rot=0&len=280&lis=&lil=0&lit=t&lsf=10&lal=50&pwt=12&pos=A",
			"in[]=snmpversion&op[]=>&st[]=1&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&tit=Network&dim=1024x600&fmt=png&lev=4&mde=f&xo=0&yo=0&rot=0&len=280&lis=&lil=0&lit=w&lsf=10&lal=50&pwt=12&pos=c",
			"in[]=snmpversion&op[]=>&st[]=1&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&co[]=&in[]=device&op[]=~&st[]=&tit=Network&dim=1024x600&fmt=png&lev=4&mde=f&xo=0&yo=0&rot=0&len=280&lis=&lil=0&lit=l&lsf=10&lal=50&pwt=12&pos=h"
			)
	
	curmap = 0
	nummap = maps.length
	function cyclemap(){
		curmap++
		if(curmap == nummap){
			curmap = 0
		}
		document.map.src="inc/drawmap.php?" + maps[curmap];
		setTimeout("cyclemap()", 10 * 1000)
	}

	function linkto(){
		document.location.href = "Topology-Map.php?" + maps[curmap]
	}

	window.onload = cyclemap();
</script>

<?php
require_once('classes.php');
require_once('functions.php');
$imgdir = './images';

$options['Hide Areas'] = 'noareas';
$options['Hide Towns'] = 'notowns';
$options['Disable Extra Info'] = 'noextra';
$options['Disable Overlay'] = 'nooverlay';

$towns = array();
$areas = array();

$towns['nasraah'] = new label('Nasraah Tej Village','nasraah','ignis','150px','250px');
$towns['essadi'] = new label('Essadi Village','essadi','ignis','250px','400px');
$towns['altaruk'] = new label('Altaruk City','altaruk','ignis','300px','290px');
$towns['allahed'] = new label('Allahed Town','allahed','ignis','210px','80px');
$towns['meleketi'] = new label('Meleketi Town','meleketi','ignis','430px','440px');
$towns['medenet'] = new label('Medenet City','medenet','ignis','510px','210px');

$areas['centpass'] = new label('Central<br>Passage','centpass','ignis','230px','330px');
$areas['nruins'] = new label('Northern <br>Ruins','nruins','ignis','130px','430px');
$areas['arteries'] = new label('Allahed\'s<br>Arteries','arteries','ignis','290px','450px');
$areas['amonument'] = new label('Allahed\'s<br>Monument','amonument','ignis','290px','550px');

$areas['ddoor'] = new label('Desert Door','ddoor','ignis','400px','330px');
$areas['altsurr'] = new label('Altaruk\'s<br>Surroundings','altsurr','ignis','280px','190px');
$areas['avalley'] = new label('Allahed\'s Valley','avalley','ignis','270px','50px');
$areas['abeach'] = new label('Allahed\'s Beach','abeach','ignis','250px','00px');
$areas['adomain'] = new label('Alexia\'s<br>Domains','adomain','ignis','310px','20px');
$areas['arena'] = new label('Arena','arena','ignis','190px','220px');
$areas['volcanic'] = new label('Volcanic Zone','Volcanic','ignis','350px','100px');

$areas['mbeach'] = new label('Meleketi\'s Beach','mbeach','ignis','530px','490px');
$areas['ccoast'] = new label('Cactus<br>Coast','ccoast','ignis','550px','430px');
$areas['mdesert'] = new label('Meleketi\'s Desert','mdesert','ignis','500px','420px');

$areas['scanyon'] = new label('South Canyon','scanyon','ignis','620px','400px');
$areas['ncanyon'] = new label('North<br>Canyon','ncanyon','ignis','440px','340px');
$areas['iruins'] = new label('Ignean Ruins','iruins','ignis','670px','420px');
$areas['rbeach'] = new label('Ruins Beach','rbeach','ignis','690px','350px');

$areas['esands'] = new label('Eastern<br>Sands','esands','ignis','610px','340px');
$areas['wsands'] = new label('Western Sands','wsands','ignis','580px','230px');
$areas['medesert'] = new label('Medenet\'s<br>Desert','medesert','ignis','540px','140px');
$areas['dvalley'] = new label('Desert<br>Valley','dvalley','ignis','450px','200px');
$areas['cdesert'] = new label('Central<br>Desert','cdesert','ignis','430px','260px');

if($_GET['noextra'] != 'on') {

	$areas['abeach']->extra = 'Teleport pad on this beach just below the cliff, leads to a small beach in the wz at the southern tip of the wall';
	
	/* Automated screenshot adding */
	foreach($towns as $town) {
		$pic = getpic($town,'small-');
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$town->extra .= '<img src="'.$pic.'" alt="A view of '.$town->name."\">\n";
		}
	}
	foreach($areas as $area) {
		$pic = getpic($area,'small-');
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$area->extra .= '<img src="'.$pic.'" alt="A view of '.$area->name."\">\n";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Regnum - Labeled map of Ignis</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<style type="text/css">
	html,body { background:black; }
	#mapbox {
		width:651px;
		height:730px;
		position:relative;
		margin:auto;
	}
	a.nickname { 
		background:none;
		padding:0;
	}

	<?php
	foreach($towns as $town)
			echo $town->css();

	foreach($areas as $area)
			echo $area->css();

	?>
	</style>

</head>
<body>


<div id="mapbox">
	<a href="index.html" class="homelink">Back to index</a>

	<div id="options">
		<form action="" method="get">
		<fieldset><legend>Options</legend>
		<?php 
		foreach($options as $name => $opt) {
			echo '<label for="'.$opt.'"><input type="checkbox" name="'.$opt.'" id="'.$opt.'"';
			if($_GET[$opt] == 'on')
				echo ' checked';
			echo '> '.$name."</label>\n";
		}?>
		<input type="submit" value="Submit">
		</fieldset>
		</form>
	</div>

	<img src="images/ignis/ignisunmarked.jpg" alt="Map of Ignis inner realm" class="map">

	<?php
	if($_GET['nooverlay'] != 'on')
		echo '<img src="images/ignis/overlay.png" alt="" class="overlay">';

	if($_GET['notowns'] != 'on') {
		foreach($towns as $town)
			echo $town->biglabel();
	}

	if($_GET['noareas'] != 'on') {
		foreach($areas as $area)
			echo $area->smalllabel();
	}
	?>

</div>

</body>
</html>

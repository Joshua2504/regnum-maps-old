<?php 
require_once('classes.php');
require_once('functions.php');

$imgdir = './images';

$options['Hide Forts'] = 'noforts';
$options['Hide Teleporters'] = 'noteleports';
$options['Hide Bridges'] = 'nobridges';
$options['Hide Other Places'] = 'noplaces';
$options['Disable Extra Info'] = 'noextra';
$options['Disable Overlay'] = 'nooverlay';

$forts['imperia'] = new label('Imperia Castle','imperia','alsius','30px','300px');
$forts['pinos'] = new label('Aggersborg Fort','pinos','alsius','400px','300px','Pinos');
$forts['trelleborg'] = new label('Trelleborg Fort','trelle','alsius','370px','20px');

$forts['menirah'] = new label('Menirah Fort','menirah','ignis','180px','490px');
$forts['samal'] = new label('Samal Fort','samal','ignis','400px','610px');
$forts['shaanarid'] = new label('Shaanarid Castle','shaanarid','ignis','550px','760px');

$forts['algaros'] = new label('Algaros Fort','algaros','syrtis','550px','70px');
$forts['stone'] = new label('Herbred Fort','stone','syrtis','550px','350px','Stone');
$forts['eferias'] = new label('Eferias Castle','eferias','syrtis','920px','600px');

$teleports['alsiustp'] = new label('TP','alsiustp','alsius','448px','15px');
$teleports['ignistp'] = new label('TP','ignistp','ignis','130px','600px');
$teleports['syrtistp'] = new label('TP','syrtistp','syrtis','770px','350px');

$bridges['PP2'] = new label('PP2','PP2','alsius','500px','110px');
$bridges['PP'] = new label('PP','PP','alsius','480px','275px');
$bridges['PB'] = new label('PB','PB','syrtis','580px','565px');
$bridges['PB2'] = new label('PB2','PB2','syrtis','710px','640px');
$bridges['PN2'] = new label('PN2','PN2','ignis','260px','450px');
$bridges['PN'] = new label('PN','PN','ignis','400px','500px');

$places['jabe'] = new label('Jabeline/<br>Stonehenge','jabe','syrtis','710px','500px');
$places['sabrepit'] = new label('Sabre Pit','sabrepit','syrtis','700px','250px');
$places['gcamp'] = new label('Gypsy Camp','gcamp','syrtis','720px','290px');
$places['msave'] = new label('Market Save','msave','syrtis','650px','350px');

$places['cupula'] = new label('Cupula (dome)','cupula','syrtis','600px','220px');
$places['pozo'] = new label('El Pozo (the hole)','pozo','alsius','250px','290px');
$places['graveyard'] = new label('Graveyard','graveyard','alsius','450px','210px');

if(!isset($_GET['noextra'])) {

	$places['jabe']->extra = 'Woodworker';
	$places['msave']->extra = '<p>Main save in syrtis, almost always has people nearby</p>';
	$places['sabrepit']->extra = '<p>May also be called "pozito" (pit)</p>';



	/* Automated screenshot adding */
	foreach($forts as $fort) {
		$pic = getpic($fort,'small-');
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$fort->extra .= '<img src="'.$pic.'" alt="A view of '.$fort->name."\">\n";
		}
	}
	foreach($bridges as $bridge) {
		$pic = getpic($bridge,'small-');
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$bridge->extra .= '<img src="'.$pic.'" alt="A view of '.$bridge->name."\">\n";
		}
	}
	foreach($places as $place) {
		$pic = getpic($place,'small-');
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$place->extra .= '<img src="'.$pic.'" alt="A view of '.$place->name."\">\n";
		}
	}
	foreach($teleports as $teleport) {
		$pic = getpic($teleport);
		$teleport->extra = "Teleport Pad";
		if($pic != false) {
			$pic = $imgdir.'/'.$pic;
			$teleport->extra .= '<img src="'.$pic.'" alt="A view of '.$teleport->name."\">\n";
		}
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
	<title>Regnum - Labeled map of the warzone</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<style type="text/css">
	body,html { background:black; }
	#mapbox {
		width:954px;
		height:1086px;
		overflow:auto;
	}

	#plainlink {
		color:white;
		text-align:center;
		display:block;
		margin:.2em;
	}

	<?php
		foreach($forts as $fort)
			echo $fort->css();

		foreach($teleports as $tp)
			echo $tp->css();

		foreach($bridges as $bridge)
			echo $bridge->css();
		
		foreach($places as $place)
			echo $place->css();
	?>

	</style>
</head>

<body>
<div id="mapbox">
<a href="index.html" class="homelink">Back to index</a>

<div id="options">
	<a href="wzmap.html" id="plainlink">Plain Version</a>
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

<img src="images/wzunmarked.jpg" alt="Map of the warzone with labels." class="map">
<?php 
if(!isset($_GET['nooverlay']))
	echo '<img src="images/innerrealmoverlay.png" alt="" class="overlay">';

if(!isset($_GET['noforts'])) {
 	foreach($forts as $fort)
		echo $fort->biglabel();
}
	
if(!isset($_GET['noteleports'])) {
	foreach($teleports as $tp)
		echo $tp->smalllabel();
}
if(!isset($_GET['noplaces'])) {
	foreach($places as $place)
		echo $place->smalllabel();
}

if(!isset($_GET['nobridges'])) {
	foreach($bridges as $bridge)
		echo $bridge->smalllabel();
 }
 ?>
</div>
</body>

</html>

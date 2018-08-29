<?php
require_once('classes.php');
require_once('functions.php');
$imgdir = './images';

$options['Hide Areas'] = 'noareas';
$options['Hide Towns'] = 'notowns';
$options['Disable Extra Info'] = 'noextra';
$options['Disable Overlay'] = 'nooverlay';

$towns['fisgael'] = new label('Fisgael City','fisgael','syrtis','180px','250px');
$towns['raeraia'] = new label('Raeraia City','raeraia','syrtis','150px','600px');
$towns['korsum'] = new label('Korsum Town','korsum','syrtis','30px','400px');
$towns['dohsim'] = new label('Dohsim Town','dohsim','syrtis','330px','620px');
$towns['ulren'] = new label('Ulren Asir Village','ulren','syrtis','420px','240px');
$towns['ilreah'] = new label('Ilreah Village','ilreah','syrtis','460px','90px');


$areas['arvnorth'] = new label('Arvanna\'s<br>Woods North','arvnorth','syrtis','250px','550px');
$areas['arvsouth'] = new label('Arvanna\'s<br>Woods South','arvsouth','syrtis','380px','500px');
$areas['arvlake'] = new label('Arvanna\'s Lake','arvlake','syrtis','300px','560px');
$areas['arvvalley'] = new label('Arvanna\'s Valley','arvvalley','syrtis','450px','500px');
$areas['nfrontier'] = new label('Northern Frontier','nfrontier','syrtis','200px','630px');
$areas['rcoast'] = new label('Rhy\'s<br>Coast','rcoast','syrtis','230px','710px');
$areas['arena'] = new label('Arena','arena','syrtis','430px','720px');

$areas['myil'] = new label('Myil Forest','myil','syrtis','130px','450px');
$areas['ksurr'] = new label('Korsum\'s Surroundings','ksurr','syrtis','70px','420px');

$areas['emerald'] = new label('Emerald Hills','emerald','syrtis','230px','370px');
$areas['naes'] = new label('Nae\'s<br>Crossing','naes','syrtis','250px','460px');
$areas['rasius'] = new label('Rasius\' Bay','rasius','syrtis','270px','360px');
$areas['elther'] = new label('Elther Forest','elther','syrtis','340px','450px');
$areas['fbeach'] = new label('Forest Beach','fbeach','syrtis','400px','350px');

$areas['sumey'] = new label('Sum Eyllis','sumey','syrtis','210px','300px');
$areas['arney'] = new label('Arn Eyllis','arney','syrtis','280px','250px');
$areas['mntgob'] = new label('Mount Goblin','mntgob','syrtis','150px','320px');
$areas['southbeach'] = new label('South Beach','southbeach','syrtis','370px','250px');
$areas['westbeach'] = new label('West Beach','westbeach','syrtis','270px','120px');
$areas['nwbeach'] = new label('NorthWest Beach','nwbeach','syrtis','150px','120px');

$areas['mforest'] = new label('Marelah\'s<br>Forest','mforest','syrtis','500px','150px');
$areas['hbeach'] = new label('Hidden Beach','hbeach','syrtis','600px','100px');
$areas['lisle'] = new label('Lam Island','lisle','syrtis','520px','340px');

if($_GET['noextra'] != 'on') {

	$towns['fisgael']->extra = "First city, levels 10-16";
	$towns['korsum']->extra = "Second city, levels 15-20";
	$towns['raeraia']->extra = "Third city, levels 20-25";
	$towns['dohsim']->extra = "Fourth city, levels 23-27";

	$areas['arvsouth']->extra = 'Teleport pad near the fire altar on the southeast side of these woods. Leads to the mountain passes, northwest side of the wall';


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
	<title>Regnum - Labeled map of Syrtis</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	<style type="text/css">
	html,body { background:black; }
	#mapbox {
		width:790px;
		height:630px;
		position:relative; margin:auto;
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

	<img src="images/syrtis/syrtisunmarked.jpg" alt="Map of Syrtis inner realm" class="map">

	<?php
	if($_GET['nooverlay'] != 'on')
		echo '<img src="images/syrtis/overlay.png" alt="" class="overlay">';

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

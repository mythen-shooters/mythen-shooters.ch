<?php
// $match:Game
// $showScore:boolean
// $showLeague:boolean
// $showEncounterWithLeague:boolean
?>

<div class="entry-content clearfix" style="text-align:center;border-bottom:0px solid #eee;margin-bottom:5px;padding-top:20px;padding-bottom:15px;">


	<?php
	   if ($showLeague) {
	       echo $match->getLeagueLong();
	       echo '<br />';
	   }
	?>

    <img style="position:relative;right:15px;" src="<?= $match->getTeamAImageUrl(60) ?>" />
    <span style="position:relative;bottom:20px;font-weight:normal;font-size:30px;">-</span>
    <img style="position:relative;left:15px;" src="<?= $match->getTeamBImageUrl(60) ?>" />
    <br />

	<span style="font-size:20px;">
		<?php
		if ($showEncounterWithLeague) {
		    echo $match->getEncounterWithLeague();
		} else {
		    echo $match->getEncounter();
		}
		?>
	</span>

    <br />

    <?php
     if (!$match->isPlayed()) {
        echo $match->getGameDateTimeFormattedShort(); 
        echo " Uhr in ";
        echo $match->getVenue();
     } else {
       echo $match->getScore();
     }
    ?>
	<br />

</div>

<?
$groupRepo = new HandballGroupRepository();
$groups = $groupRepo->findGroupsByTeamId($teamId);

foreach ($groups as $group) {
?>
    <div>
	  <h3 style="margin-bottom:0px;">Rangliste</h3>
	  <div class="responsive-table-container">
		<table style="">
		<? foreach ($group->getRankings() as $ranking) { ?>
			<?
				$bold = "";
				if ($ranking->isOurTeam()) {
					$bold = "font-weight:bold;";
				}
			?>

			<tr>
				<td style="border: 0px solid black;padding:0px;<?= $bold ?>">
					<?= $ranking->getRank(); ?>
					<img style="position:relative;top:10px;" src="https://www.handball.ch/images/logo/<?= $ranking->getTeamId() ?>.png?fallbackType=club&fallbackId=<?= $ranking->getClubId() ?>&width=30&height=30&rmode=pad&format=png" />
					<?= $ranking->getTeamName(); ?>
				</td>
				<td class="td-ranking" style="<?= $bold ?>padding:0px;padding-top:16px;"><?= $ranking->getTotalPoints() ?></td>
			</tr>
		<? } ?>
		</table>
      </div>
    </div>
  <? } ?>

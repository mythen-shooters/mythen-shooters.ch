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
			<tr>
				<td style="border: 0px solid black;padding:0px;">
					<?= $ranking->getRank(); ?>
					<img style="position:relative;top:10px;" src="https://www.handball.ch/images/logo/<?= $ranking->getTeamId() ?>.png?fallbackType=club&fallbackId=<?= $ranking->getClubId() ?>&width=30&height=30&rmode=pad&format=png" />
					<?= $ranking->getTeamName(); ?>
				</td>
				<td class="td-ranking" style="padding:0px;"><?= $ranking->getTotalPoints() ?></td>
			</tr>
		<? } ?>
		</table>
      </div>
    </div>
  <? } ?>

  <style>
.responsive-table-container
{
	width: 100%;
	overflow-y: auto;
	_overflow: auto;
	margin: 0 0 1em;
}
.td-ranking {
    text-align:center;
    width: 50px;
	border: 0px solid black;
}
</style>

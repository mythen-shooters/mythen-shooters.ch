<?
// $matches: array of matches


?> <div class="responsive-table-container"><table> <?

foreach ($matches as $match) {
    $reportUrl = $match->getPostReportUrl();

    ?>
    <tr style="" onclick="<? if (empty($reportUrl)) { echo "";} else { echo "window.location = '".$reportUrl."';"; } ?>" class="<? if (empty($reportUrl)) { echo "";} else { echo "gametable-report"; } ?>">
     <td class="gametable-cell" style="width:120px;"><? echo $match->getLeagueShort() ?></td>
     <td class="gametable-cell" style="width:420px;padding-top:4px;">
      <?
         $imageA = $match->getTeamAImageUrl("20");
         $imageB = $match->getTeamBImageUrl("20");
         echo "<img class='gametable-club-logo' src='$imageA' />";
         echo $match->getTeamAName();
         echo ' - ';
         echo "<img class='gametable-club-logo' src='$imageB' />";
         echo $match->getTeamBName();
      ?>
     </td>
     <td class="gametable-cell" style="width:120px;"><? echo $match->getScore(); ?> </td>
     
     <td class="gametable-cell" style="width:90px;text-align:right;">
         <a href="<? echo $match->getLivetickerUrl() ?>">Liveticker</a>
     </td>
     
     <td style="width:20px;padding:0px;text-align:center;margin:0px;padding-top:4px;"  class="gametable-cell">
         <?
         if (!empty($reportUrl)) {
           ?>
             <img style="height:20px;position:relative;top:2px;" src="/wp-content/themes/shooters/images/icons/standard.svg" />
           <?
         }
         ?>
        </td>
     </tr>
   <?php
}
?>
</table></div>

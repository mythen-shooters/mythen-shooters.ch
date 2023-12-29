<?
// $matches: array of matches
?> <div class="responsive-table-container"><table> <?

foreach ($matches as $match) {
    $previewUrl = $match->getPostPreviewUrl();
    ?>
     <tr style="" onclick="<? if (empty($previewUrl)) { echo "";} else { echo "window.location = '".$previewUrl."';"; } ?>" class="<? if (empty($previewUrl)) { echo "";} else { echo "gametable-report"; } ?>">
       <td class="gametable-cell" style="width:115px;"><? echo $match->getGameDateTimeFormattedShort() ?></td>	
       <td class="gametable-cell" style="width:90px"><? echo $match->getLeagueShort() ?></td>
       <td style="width:117px;"  class="gametable-cell"><? echo $match->getVenueShort(); ?> </td>
       <td class="gametable-cell" style="width:420px;padding-top:4px;">
         <?php
         $imageA = $match->getTeamAImageUrl("20");
         $imageB = $match->getTeamBImageUrl("20");
         echo "<img class='gametable-club-logo' src='$imageA' />";
         echo $match->getTeamAName();
         echo ' - ';
         echo "<img class='gametable-club-logo' src='$imageB' />";
         echo $match->getTeamBName();
         ?>
       </td>

       <td style="width:20px;padding:0px;text-align:center;margin:0px;padding-top:4px;"  class="gametable-cell">
         <?
         if (!empty($previewUrl)) {
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

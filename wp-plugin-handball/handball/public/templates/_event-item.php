<?php
// $event
// $class

echo "<div class='$class' style='padding-right:25px;'>";
    
	echo '<span style="position:relative;top:35px;color:#777;font-size:12px;">'.esc_attr($event->formattedStartDateLong()).'</span>';
    echo '<h2 style="position:relative;top:15px;font-size:18px;">' . esc_attr($event->getTitle()) . '</h2>';
	
    $imgUrl = $event->getFirstImageUrlInPost();
    if (!empty($imgUrl)) {
        echo '<img style="max-height:225px;" src="' . esc_attr($event->getFirstImageUrlInPost()) .'" style="width:400px;float:left;margin-right:10px;" />';
    }

    ?>
	<br /><a href="<?= $event->getUrl() ?>" class="more-link">Event anschauen</a>
	</div>
	


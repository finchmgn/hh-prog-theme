<?php

// переменные для запроса к ВК
$vk_vars = array(
	'method'    => 'photos.get?',
	'owner'     => 'owner_id=537837380&',
	'album'     => 'album_id=264283690&',
	'order'     => 'rev=0&',
	'count'     => 'count=20&',
	'serv_key'  => 'access_token=1f1d6f251f1d6f251f1d6f25961f76158611f1d1f1d6f254200d3dc2b8975ba19db4aae&',
	'version'   => 'v=5.52&'
);

$vk_request = 'https://api.vk.com/method/'.$vk_vars['method'].$vk_vars['owner'].$vk_vars['album'].$vk_vars['order'].$vk_vars['count'].$vk_vars['serv_key'].$vk_vars['version'];
$vk_request_result = file_get_contents($vk_request, true);
$results = json_decode($vk_request_result);
$results = $results->response->items;

?>
<p class="title_big"><?php echo get_theme_mod('vk_api_header'); ?></p>
<div id="vk-api__photo-block" class="vk-api__photo-block">

    <?php 
    foreach ($results as $photo) {
        echo "
        <div class='vk-api__photo-item'>
            <div class='vk-api__photo-item-image hhp-modal' style='background-image: url($photo->photo_604)'></div>
            <p class='vk-api__photo-desc'>$photo->text</p>
        </div>";
    }
    ?>

</div>

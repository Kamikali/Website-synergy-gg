<?php

function setEmojis($comment, $height = 20, $margintop = -4){
	$start = '<img style="max-height:'.$height.'px;max-width:'.$height.'px;margin-top:'.$margintop.'px;" src="http://www.emoji.synergy.gg/';
	$end = '">';

	$emojiName = array();
	$emojiName[0] = '/:adc:/';
	$emojiName[1] = '/:battlerite:/';
	$emojiName[2] = '/:battleroyale:/';
	$emojiName[3] = '/:blobglare:/';
	$emojiName[4] = '/:fill:/';
	$emojiName[5] = '/:heyguys:/';
	$emojiName[6] = '/:jungle:/';
	$emojiName[7] = '/:kirby:/';
	$emojiName[8] = '/:lol:/';
	$emojiName[9] = '/:mid:/';
	$emojiName[10] = '/:monkaGun:/';
	$emojiName[11] = '/:no:/';
	$emojiName[12] = '/:noot:/';
	$emojiName[13] = '/:nootlikethis:/';
	$emojiName[14] = '/:nootnoot:/';
	$emojiName[15] = '/:omegapoggers:/';
	$emojiName[16] = '/:poggers:/';
	$emojiName[17] = '/:sendnoots:/';
	$emojiName[18] = '/:spamreee:/';
	$emojiName[19] = '/:support:/';
	$emojiName[20] = '/:top:/';
	$emojiName[21] = '/:uuuuh:/';
	//$emojiName[22] = '/::/';

	$emojiURL = array();
	$emojiURL[0] = $start.'adc.png'.$end;
	$emojiURL[1] = $start.'battlerite.png'.$end;
	$emojiURL[2] = $start.'battleroyale.png'.$end;
	$emojiURL[3] = $start.'blobglare.png'.$end;
	$emojiURL[4] = $start.'fill.png'.$end;
	$emojiURL[5] = $start.'heyguys.png'.$end;
	$emojiURL[6] = $start.'jungle.png'.$end;
	$emojiURL[7] = $start.'kirby.png'.$end;
	$emojiURL[8] = $start.'lol.png'.$end;
	$emojiURL[9] = $start.'mid.png'.$end;
	$emojiURL[10] = $start.'monkaGun.png'.$end;
	$emojiURL[11] = $start.'no.png'.$end;
	$emojiURL[12] = $start.'noot.png'.$end;
	$emojiURL[13] = $start.'nootlikethis.png'.$end;
	$emojiURL[14] = $start.'nootnoot.gif'.$end;
	$emojiURL[15] = $start.'omegapoggers.png'.$end;
	$emojiURL[16] = $start.'poggers.png'.$end;
	$emojiURL[17] = $start.'sendnoots.png'.$end;
	$emojiURL[18] = $start.'spamreee.png'.$end;
	$emojiURL[19] = $start.'support.png'.$end;
	$emojiURL[20] = $start.'top.png'.$end;
	$emojiURL[21] = $start.'uuuuh.png'.$end;

	return preg_replace($emojiName, $emojiURL, $comment);
}
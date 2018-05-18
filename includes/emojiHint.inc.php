<?php


//Strings fuer emoji links
$start = '<img style="max-height:16px;max-width:16px;margin-top:-4px;" src="http://www.emoji.synergy.gg/';
$end = '">';

// Array with names
    $emojiURL[0] = ":adc:".$start."adc.png".$end;
    $emojiURL[1] = ":battlerite:".$start.'battlerite.png'.$end;
    $emojiURL[2] = ":battleroyale:".$start.'battleroyale.png'.$end;
    $emojiURL[3] = ":blobglare:".$start.'blobglare.png'.$end;
    $emojiURL[4] = ":fill:".$start.'fill.png'.$end;
    $emojiURL[5] = ":heyguys:".$start.'heyguys.png'.$end;
    $emojiURL[6] = ":jungle:".$start.'jungle.png'.$end;
    $emojiURL[7] = ":kirby:".$start.'kirby.png'.$end;
    $emojiURL[8] = ":lol:".$start.'lol.png'.$end;
    $emojiURL[9] = ":mid:".$start.'mid.png'.$end;
    $emojiURL[10] = ":monkaGun:".$start.'monkaGun.png'.$end;
    $emojiURL[11] = ":no:".$start.'no.png'.$end;
    $emojiURL[12] = ":noot:".$start.'noot.png'.$end;
    $emojiURL[13] = ":nootlikethis:".$start.'nootlikethis.png'.$end;
    $emojiURL[14] = ":nootnoot:".$start.'nootnoot.gif'.$end;
    $emojiURL[15] = ":omegapoggers:".$start.'omegapoggers.png'.$end;
    $emojiURL[16] = ":poggers:".$start.'poggers.png'.$end;
    $emojiURL[17] = ":sendnoots:".$start.'sendnoots.png'.$end;
    $emojiURL[18] = ":spamreee:".$start.'spamreee.png'.$end;
    $emojiURL[19] = ":support:".$start.'support.png'.$end;
    $emojiURL[20] = ":top:".$start.'top.png'.$end;
    $emojiURL[21] = ":uuuuh:".$start.'uuuuh.png'.$end;


// get the q parameter from URL
$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from "" 
if ($q[0] == ":") {
    $q = strtolower($q);
    $len=strlen($q);
    $counter = 1;
    $emojisFound = 0;
    foreach($emojiURL as $name) {
        if (stristr($q, substr($name, 0, $len))) {
            $last_space = strrpos($name, '<');
            $last_word = substr($name, $last_space);
            $first_chunk = substr($name, 0, $last_space);
            if ($hint === "") {
                $hint = '<tr><td><a onclick="jsFunction(\'' . $first_chunk . '\');">'.$last_word.' '.$first_chunk.'</a>';
            } else {
                if($counter == 0){
                    $hint .= '<tr><td style="width:33%"><a style="cursor: pointer;" onclick="jsFunction(\'' . $first_chunk . '\');">'.$last_word.' '.$first_chunk.'</a></td>';
                    $counter++;
                } elseif($counter >= 2) {
                    $hint .= '<td  style="width:33%"><a style="cursor: pointer;" onclick="jsFunction(\'' . $first_chunk . '\');">'.$last_word.' '.$first_chunk.'</a></td></tr>';
                    $counter = 0;
                } else {
                    $hint .= '<td  style="width:34%"><a style="cursor: pointer;" onclick="jsFunction(\'' . $first_chunk . '\');">'.$last_word.' '.$first_chunk.'</a></td>';
                    $counter++;
                }
            }
        }
    }
    $hint === "" ? "No matching Emojis found!" : $hint;
    echo "<br><table style='width:100%;font-size:12px;'>".$hint."</table>";
}

// Output "no suggestion" if no hint was found or output correct values 

?>
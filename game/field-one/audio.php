<?php
session_start();

function playAudio($music) {
    if (isset($_POST['playAudio'])) {
        
        $_SESSION['audioPlaying'] = true;
    }

    if (isset($_POST['stopAudio'])) {
        
        $_SESSION['audioPlaying'] = false;
    }

    
    $audioPlaying = isset($_SESSION['audioPlaying']) ? $_SESSION['audioPlaying'] : false;

    
    echo "<h1>Background Audio Control</h1>";
    if ($audioPlaying) {
        echo "<p>Audio is playing.</p>";
        echo "<form method='post'>";
        echo "<button type='submit' name='stopAudio'>Stop Audio</button>";
        echo "</form>";
    } else {
        echo "<p>Audio is not playing.</p>";
        echo "<form method='post'>";
        echo "<button type='submit' name='playAudio'>Play Audio</button>";
        echo "</form>";
    }

    
    echo "<audio controls loop>";
    echo "<source src='$music' type='audio/mpeg'>";
    echo "Your browser does not support the audio element.";
    echo "</audio>";
}


if (!isset($_SESSION['inBattle']) || $_SESSION['inBattle'] == false) {
    
    switch ($content) {
        case '../field-one/field-one.php':
            
            $music = 'field-one.mp3';
            break;
        case '../field-two/field-two.php':
            
            $music = 'field-two.mp3';
            break;
        case '../field-three/field-three.php':
            
            $music = 'field-three.mp3';
            break;
        default:
            
            $music = 'default.mp3';
            break;
    }

    
    playAudio($music);
}
?>

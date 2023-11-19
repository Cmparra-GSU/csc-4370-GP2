<?php

function getTextFile($currentArea) {
    switch ($currentArea) {
        case '../intro/intro.php':
            return '../intro/intro-text.php';
            
        case '../field-one/field-one.php':
            return '../field-one/field-one-text.php';

        case '../field-two/field-two.php':
            return '../field-two/field-two-text.php';
        
        case '../field-three/field-three.php':
            return '../field-three/field-three-text.php';
            
        case '../battle/battle.php':
            return '../battle/battle-text.php';
        default:
            return null; 
    }
}

function battleSelector($currentArea, $currentPosition, $eventText = null) {
    $textFile = getTextFile($currentArea);
    if ($eventText !== null) {
        displayBattleText($eventText, 0);
    } else if ($textFile !== null && file_exists($textFile)) {
        include($textFile);
        displayBattleText($first, $currentPosition);
    }
}


function selector($currentArea, $currentPosition, $eventText = null) {
    $textFile = getTextFile($currentArea);
    if ($eventText !== null) {
        if($eventText == 'move'){
            include($textFile);
            $_SESSION['currentText'] = $first;
            displayText($_SESSION['currentText'], $_SESSION['position']);
        }
        else{
            displayText($eventText, 0);
        }

    } 
    else if ($textFile !== null && file_exists($textFile)) {
        include($textFile);
        if (!isset($_SESSION['currentText'])) {
            $_SESSION['currentText'] = $first;
        }

        
        displayText($_SESSION['currentText'], $_SESSION['position']);
    } else {
        echo "File does not exist: " . $textFile;
    }
}





function displayText($currentTextArray, $currentPosition) {
    $_SESSION['currentText'] = $currentTextArray;
    $_SESSION['position'] = $currentPosition;

    if (isset($_POST['choice'])) {
        $nextArea = $_POST['choice'];
        
        $nextTextArray = getNextArray($nextArea);
        if ($nextTextArray) {
            $_SESSION['currentText'] = $nextTextArray;
            $_SESSION['position'] = 0; 

        }
    } elseif (isset($_POST['advanceText'])) {
        $_SESSION['position']++;

    }

    if ($currentEntry = $_SESSION['currentText'][$_SESSION['position']] ?? null) {
        echo "<p>{$currentEntry['speaker']}<br>{$currentEntry['text']}</p>";

        if (isset($currentEntry['moveto'])) {
            $_SESSION['moveto'] = $currentEntry['moveto'];
        }

        if (isset($currentEntry['choices'])) {
            foreach ($currentEntry['choices'] as $choice) {
                $nextValue = $choice['next'] ?? '';
                echo "<form method='post'>";
                echo "<input type='hidden' name='choice' value='{$nextValue}'>";
                echo "<button type='submit'>{$choice['text']}</button>";
                echo "</form>";
            }
        } else {
            echo "<form method='post'>";
            echo "<button type='submit' name='advanceText'>Next</button>";
            echo "</form>";
        }
    }
}


function getNextArray($arrayName) {
    echo "<script>console.log('getNextArray called with: $arrayName');</script>";
    if (isset($GLOBALS[$arrayName])) {
        echo "<script>console.log('Returning array: $arrayName');</script>";
        return $GLOBALS[$arrayName]; 
    }
    echo "<script>console.log('Array not found for: $arrayName');</script>";
    return null;
}



function displayBattleText($currentTextArray, $currentPosition) {
    if (isset($_SESSION['currentText']) && $_SESSION['currentText'] !== $currentTextArray) {
        $currentTextArray = $_SESSION['currentText'];
    } else {
        
        $_SESSION['currentText'] = $currentTextArray;
    }
    $_SESSION['position'] = $currentPosition;

    if (isset($_POST['choice'])) {
        $nextArea = $_POST['choice'];

        $nextTextArray = getNextArray($nextArea);
        if ($nextTextArray) {
            $_SESSION['currentText'] = $nextTextArray;
            $_SESSION['position'] = 0;
        }
    } elseif (isset($_POST['advanceText'])) {
        $_SESSION['position']++;

        if ($_SESSION['position'] >= count($_SESSION['currentText'])) {
            
        } else {
            $currentEntry = $_SESSION['currentText'][$_SESSION['position']];
            if (!empty($currentEntry['text'])) {
                
                echo "<p>{$currentEntry['speaker']}<br>{$currentEntry['text']}</p>";
            }

            if (isset($currentEntry['moveto'])) {
                $_SESSION['moveto'] = $currentEntry['moveto'];
                header("Location: game.php");
                exit;
            }

            if (isset($currentEntry['choices'])) {
                foreach ($currentEntry['choices'] as $choice) {
                    $nextValue = $choice['next'] ?? '';
                    echo "<form method='post'>";
                    echo "<input type='hidden' name='choice' value='{$nextValue}'>";
                    echo "<button type='submit'>{$choice['text']}</button>";
                    echo "</form>";
                }
            } else {
                if (!empty($currentEntry['text'])) {
                    
                    echo "<form method='post'>";
                    echo "<button type='submit' name='advanceText'>Next</button>";
                    echo "</form>";
                }
            }
        }
    }

    if ($currentEntry = $_SESSION['currentText'][$_SESSION['position']] ?? null) {
        if (!empty($currentEntry['text'])) {
            
            echo "<p>{$currentEntry['speaker']}<br>{$currentEntry['text']}</p>";
        }

        if (isset($currentEntry['moveto'])) {
            $_SESSION['moveto'] = $currentEntry['moveto'];
        }

        if (isset($currentEntry['choices'])) {
            foreach ($currentEntry['choices'] as $choice) {
                $nextValue = $choice['next'] ?? '';
                echo "<form method='post'>";
                echo "<input type='hidden' name='choice' value='{$nextValue}'>";
                echo "<button type='submit'>{$choice['text']}</button>";
                echo "</form>";
            }
        } else {
            if (!empty($currentEntry['text'])) {
                
                echo "<form method='post'>";
                echo "<button type='submit' name='advanceText'>Next</button>";
                echo "</form>";
            }
        }
    }
}


?>

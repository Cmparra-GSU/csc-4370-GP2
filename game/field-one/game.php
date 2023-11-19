<?php
include('../functions/character.php');
include('../functions/text.php');
session_start();

if (!isset($_SESSION['content'])) {
    $_SESSION['content'] = '../intro/intro.php';
}


if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
} else {
    header("Location: ../main/main.php");
    exit;
}
if (!isset($_SESSION['currentPosition'])) {
    $_SESSION['currentPosition'] = 0;
}
if (isset($_SESSION['inBattle']) && $_SESSION['inBattle']) {
    header("Location: ../battle/battle.php");
    exit;
}

$content = $_SESSION['content'];

if (isset($_SESSION['playerDefeated']) && $_SESSION['playerDefeated'] === true) {
    
    setcookie('playerRow', 1, time() + 3600, '/');
    setcookie('playerCol', 1, time() + 3600, '/');
    

    
    $_SESSION['spotted'] = false;

    
    $content = 'game-over.php';
}


if (isset($_SESSION['moveto'])) {
    $content = '../' . $_SESSION['moveto'] . '/' . $_SESSION['moveto'] . '.php';
    if (isset($_SESSION['moveto'])&& $_SESSION['moveto']=='battle') {
       
       unset($_SESSION['moveto']);
       
    }

    $_SESSION['content'] = $content;
    $_SESSION['currentPosition'] = 0;
    unset($_SESSION['moveto']);
}

if (isset($_GET['content'])) {
    $contentParam = $_GET['content'];

    if ($contentParam === 'field-one') {
        $content = '../field-one/field-one.php';
    }

    if ($contentParam === 'field-one') {
        $content = '../field-two/field-two.php';
    }
    if ($contentParam === 'game-over') {
        $content = '../field-one/game-over.php';
    }

}

if (isset($_POST['useItem'])) {
    $itemToUse = $_POST['useItem'];
    $character->useItem($itemToUse);
    header("Location: game.php");
    exit;
}

if (isset($_SESSION['moveto']) && $_SESSION['moveto'] == 'battle') {
    $_SESSION['spotted'] = false;
}




if (isset($_POST['reset'])) {

    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time()-1000);
            setcookie($name, '', time()-1000, '/');
        }
    }
    session_destroy();
    header("Location: ../main/main.php");
    exit;

}

$currentPosition = $_SESSION['currentPosition'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="game.css">
    <title>Your Game Title</title>
</head>
<body>
    
        <div id="character-stats">
            <div class="basic-info">
                <p>Name: <?php echo htmlspecialchars($character->name); ?></p>
                <p>Health: <?php echo htmlspecialchars($character->currentHealth) . "/" . htmlspecialchars($character->maxHealth); ?></p>
            </div>
            <div class="cash-info">
                <p>Cash:<br>$<?php echo htmlspecialchars($character->cash); ?></p>
            </div>
            <div class="main-stats">
                <?php
                foreach ($character->stats as $statName => $statValue) {
                    echo "<p>" . ucfirst(htmlspecialchars($statName)) . ": " . htmlspecialchars($statValue) . "</p>";
                }
                ?>
            </div>
            <form method="post">
                <button type="submit" name="reset" class="resetButton">NEW<br>GAME</button>
            </form>

            
        </div>
        <div id="game-container">
            <div id="game-content">
                <div id = "game-grid-container">
                    <div id="map-screen">
                        <?php include($content); ?>
                    </div>
                    <div class="move-buttons">
                        <form method="post">
                            <input type="hidden" name="playerRow" value="<?php echo $playerRow; ?>">
                            <input type="hidden" name="playerCol" value="<?php echo $playerCol; ?>">
                            <?php
                            
                            if ($currentArea !== 'intro') {
                                
                                ?>
                                <button type="submit" name="moveUp">↑</button>
                                <button type="submit" name="moveDown">↓</button>
                                <button type="submit" name="moveLeft">←</button>
                                <button type="submit" name="moveRight">→</button>
                                <?php
                            }
                            ?>
                        </form>
                    </div>
            </div>


                <div id="textbox">
                <div id="text-content">
                    <?php
                    
                    if (isset($_SESSION['itemPickedUp']) && $_SESSION['itemPickedUp']) {
                        
                        selector($content, $currentPosition, $itemPickup);
                        $_SESSION['position']++;
                        $_SESSION['itemPickedUp'] = false; 
                    } 
                    
                    elseif(isset($_SESSION['spotted']) && $_SESSION['spotted']){
                        $_SESSION['spotted'] = false;
                        echo "<p>Spotted by the enemy!</p>";

                    
                        
                        $_SESSION['inBattle'] = true;
                    }

                    elseif (isset($_SESSION['teleportMessage']) && $_SESSION['teleportMessage'] ) {
                        selector($content, $currentPosition, $teleporterText);
                        unset($_SESSION['teleportMessage']);
                    }
                    
                    else {
                        selector($content, 0);
                    }
                    ?>
                </div>
            </div>


                <div id="player-inventory">
                    <p>Inventory:</p>
                    <ul>
                        <?php
                        if (isset($character) && $character->inventory) {
                            foreach ($character->inventory->getInventory() as $itemName => $quantity) {
                                echo "<li>";
                                echo htmlspecialchars($itemName) . ": " . htmlspecialchars($quantity) . " ";
                                echo "<form method='post' style='display: inline;'>";
                                echo "<input type='hidden' name='useItem' value='" . htmlspecialchars($itemName) . "'>";
                                echo "<button type='submit'>Use</button>";
                                echo "</form>";
                                echo "</li>";
                            }
                        }
                        ?>
                    </ul>
                </div>

            
        </div>
    </div>
</body>
</html>

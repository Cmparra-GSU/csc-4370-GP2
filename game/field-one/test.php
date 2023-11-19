<?php
include('../functions/character.php');
include('../functions/text.php');


session_start();

if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
} else {
    header("Location: ../main/main.php");
    exit;
}

if (!isset($_SESSION['content'])) {
    $_SESSION['content'] = '../intro/intro.php';
}

$content = $_SESSION['content'];

if (isset($_SESSION['moveto'])) {
    $content = '../' . $_SESSION['moveto'] . '/' . $_SESSION['moveto'] . '.php';
    $_SESSION['content'] = $content;
    $_SESSION['currentPosition'] = 0; 
    unset($_SESSION['moveto']);
}


if (isset($_GET['content'])) {
    $contentParam = $_GET['content'];

    if ($contentParam === 'field-one') {
        $content = '../field-one/field-one.php';
    }
}

if (isset($_POST['useItem'])) {
    $itemToUse = $_POST['useItem'];
    $character->useItem($itemToUse);

    header("Location: game.php");
    exit;
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
    <div id="game-container">
        <div id="character-stats">
            <?php
            // Display character information
            echo "<p>Name: " . $character->name . "</p>";
            echo "<p>Level: " . $character->level . "</p>";
            echo "<p>Health: " . $character->currentHealth . "/" . $character->maxHealth . "</p>";
            ?>
            <form method="post">
                <button type="submit" name="reset">Reset</button>
            </form>
        </div>

        <div id="game-content">
            <div id="map-screen">
                <?php
                include($content);
                ?>
                <div class="move-buttons">
                    <form method="post">
                        <input type="hidden" name="playerRow" value="<?php echo $playerRow; ?>">
                        <input type="hidden" name="playerCol" value="<?php echo $playerCol; ?>">
                        <button type="submit" name="moveUp">Up</button>
                        <button type="submit" name="moveDown">Down</button>
                        <button type="submit" name="moveLeft">Left</button>
                        <button type="submit" name="moveRight">Right</button>
                    </form>
                </div>
            </div>

            <div id="player-inventory">
                <p>Inventory:</p>
                <ul>
                    <?php
                    if (isset($character) && $character->inventory) {
                        foreach ($character->inventory->getInventory() as $itemName => $quantity) {
                            echo "<li>";
                            echo "$itemName: $quantity ";
                            echo "<form method='post' style='display: inline;'>";
                            echo "<input type='hidden' name='useItem' value='$itemName'>";
                            echo "<button type='submit'>Use</button>";
                            echo "</form>";
                            echo "</li>";
                        }
                    }
                    ?>
                </ul>
            </div>


        <div id="textbox">
            <div id="text-content">
                <?php

                if (isset($_SESSION['itemPickedUp']) && $_SESSION['itemPickedUp']) {

                    selector($content, $currentPosition, $itemPickup);
                    $_SESSION['itemPickedUp'] = false; 
                    // Regular text display
                    selector($content, $currentPosition);
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>



<?php
include('../functions/character.php');
include('../functions/text.php');
include ('battle-functions.php');
session_start();
if (isset($_SESSION['character'])) {
    $character = $_SESSION['character'];
} else {
    header("Location: ../main/main.php");
    exit;
}

include('battle-text.php');


                
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../field-one/game.css">
    <title>Your Game Title</title>
   
</head>
<body>
    <div id="game-container">
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

        <div id="game-content">

        <?php
                    $enemy = $_SESSION['enemy'];
                     displayBattleFlow($character, $enemy);?>
            <div id="textbox">
                <div id="text-content">
                    
                     <div id="combat-log">
                        <?php
                        if (isset($_SESSION['combatLog'])) {
                            foreach ($_SESSION['combatLog'] as $logEntry) {
                                echo "<p>$logEntry</p>";
                            }
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div id = "enemy">
            <?php
                
                echo "<div id='enemy-info'>";
                echo "<h2>Enemy Encounter</h2>";
                echo "<p><strong>Name:</strong> " . htmlspecialchars($enemy['name']) . "</p>";
                echo "<p><strong>Health:</strong> " . htmlspecialchars($enemy['health']) . "</p>";
                echo "<p><strong>Strength:</strong> " . htmlspecialchars($enemy['strength']) . "</p>";
                echo "<p><strong>Vitality:</strong> " . htmlspecialchars($enemy['vitality']) . "</p>";
                echo "</div>";
            ?>
            </div>
        </div>
    </div>
</body>
</html>
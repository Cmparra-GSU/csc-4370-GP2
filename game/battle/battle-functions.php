<?php

function displayBattleFlow($player, $enemy) {
    if (!isset($_SESSION['combatLog'])) {
        $_SESSION['combatLog'] = array();
    }
    $playerTurn = true; 

    
    if ($playerTurn) {
        
        echo "<div class = attack>";
        echo "<form method='post'>";
        echo "<button type='submit' name='playerAction' value='attack'>Attack</button>";
        echo "<button type='submit' name='playerAction' value='heal'>Heal</button>";
        echo "</form>";
        echo "</div>";}
        
        if ($playerTurn && isset($_POST['playerAction'])) {


            $action = $_POST['playerAction'];
            if ($action === 'attack') {
                playerAttack($player, $enemy);
            } elseif ($action === 'heal') {
                $healAmount = healPlayer($player);
                $_SESSION['combatLog'][] = "Healed for $healAmount points.";
            }
    
            $playerTurn = false;
        }
    
        
        if (!$playerTurn) {
            enemyAttack($enemy, $player);
            $playerTurn = true; 
            header("Location: battle.php?battleAction=processed");
            exit;
        }
    
        $battleOutcome = checkBattleOutcome($player, $enemy);
    
        
       
}

function calculateDamage($attackerStrength, $defenderVitality) {
    
    $diceRoll = rand(1, 6);

    
    $damage = $diceRoll + floor($attackerStrength * 0.5) - floor($defenderVitality * 0.5);

    
    $damage = max($damage, 0);

    return $damage;
}


function playerAttack(&$player, &$enemy) {
    $damage = calculateDamage($player->stats['strength'], $enemy['vitality']);
    $enemy['health'] -= $damage;
    $_SESSION['enemy'] = $enemy; 

    
    $_SESSION['combatLog'][] = "Player attacked for $damage damage.";

    return $damage;
}

function enemyAttack(&$enemy, &$player) {
    $damage = calculateDamage($enemy['strength'], $player->stats['vitality']);
    $player->currentHealth -= $damage;
    $_SESSION['player'] = $player; 

    
    $_SESSION['combatLog'][] = "Enemy attacked for $damage damage.";

    if ($player->currentHealth <= 0) {
        handleGameOver();
    }

    return $damage;
}


function checkBattleOutcome($player, $enemy) {
    if ($enemy['health'] <= 0) {
        
        handleVictory($player, $enemy);
        return 'victory';
    } elseif ($player->currentHealth <= 0) {
        
        handleGameOver();
        return 'defeat';
    }
    return 'ongoing';
}

function handleVictory($player, $enemy) {
    
    $player->inventory->addItem($enemy['loot']);
    $player->cash += $enemy['cash'];

    $_SESSION['inBattle'] = false;
    header("Location: ../field-one/game.php");
    exit;
}

function handleGameOver() {
    $_SESSION['playerDefeated'] = true; 
    header("Location: ../field-one/game.php");
    exit;
}

function healPlayer(&$player) {
    
    $healAmount = floor($player->stats['vitality'] * 0.5) + 1;

    
    $player->currentHealth += $healAmount;

    
    if ($player->currentHealth > $player->maxHealth) {
        $player->currentHealth = $player->maxHealth;
    }

    
    return $healAmount;
}




?>
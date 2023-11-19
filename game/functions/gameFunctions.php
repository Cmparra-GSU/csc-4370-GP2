<?php
include_once("inventory.php");
include_once("items.php");

function triggerEvent($eventType, $playerCharacter) {
    echo "<script>console.log('Event triggered: $eventType');</script>";

    switch ($eventType) {
        case 'Potion':
        case 'StrengthSoul':
        case 'VitalitySoul':
            if (handleItemPickup($playerCharacter, $eventType)) {
                $_SESSION['itemPickedUp'] = true;
                $_SESSION['pickedItemName'] = $eventType; 
                return true;
            }
            break;
        case 'Enemy':
            $_SESSION['spotted'] = true;
            $_SESSION['enemy'] = selectEnemy();
            return true;
            
    }

}


function selectEnemy() {
    include('../field-one/field-one-enemies.php');
    $totalRate = 0;
    foreach ($enemies as $enemy) {
        $totalRate += $enemy['encounterRate'];
    }

    $rand = mt_rand(1, $totalRate);
    $currentRate = 0;

    foreach ($enemies as $enemyName => $enemy) {
        $currentRate += $enemy['encounterRate'];
        if ($rand <= $currentRate) {
            return $enemy; 
        }
    }
}




function handleItemPickup($playerCharacter, $itemName) {
    var_dump("handleItemPickup called with item: $itemName"); 

    
    $playerCharacter->inventory->addItem($itemName);

    
    return true; 
}

?>
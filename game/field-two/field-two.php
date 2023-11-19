<div id="game-grid">
    <table>
        <?php
        include('../functions/gameFunctions.php');
        include('field-two-text.php');
        include('field-two-matrix.php');
        include_once('../functions/text.php');
        include_once("../functions/inventory.php");
        include_once("../functions/items.php");
        
        $itemMatrix = &$_SESSION['itemMatrixFieldTwo'];
        $currentPosition = 0;
        $currentArea = 'field-two';
        $playerRow = isset($_COOKIE['playerRow']) ? $_COOKIE['playerRow'] : 1;
        $playerCol = isset($_COOKIE['playerCol']) ? $_COOKIE['playerCol'] : 1;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newPlayerRow = $playerRow; 
    $newPlayerCol = $playerCol; 

    
    if (isset($_POST['moveUp']) && $playerRow > 1) {
        $newPlayerRow--;
    } elseif (isset($_POST['moveDown']) && $playerRow < 10) {
        $newPlayerRow++;
    } elseif (isset($_POST['moveLeft']) && $playerCol > 1) {
        $newPlayerCol--;
    } elseif (isset($_POST['moveRight']) && $playerCol < 10) {
        $newPlayerCol++;
    }

    
    $isTargetCellWall = ($itemMatrix[$newPlayerRow - 1][$newPlayerCol - 1] == 2);
    if (!$isTargetCellWall) {
        
        $playerRow = $newPlayerRow;
        $playerCol = $newPlayerCol;
    }

            
            $cellValue = $itemMatrix[$playerRow - 1][$playerCol - 1];
            if (($cellValue > 20 && $cellValue < 30)) {

                    $itemName = '';
                    switch ($cellValue) {
                        case 21:
                            $itemName = 'Potion';
                            break;
                        case 22:
                            $itemName = 'StrengthSoul';
                            break;
                        case 23:
                            $itemName = 'VitalitySoul';
                            break;
                    }
                    if (triggerEvent($itemName, $character)) {
                        $_SESSION['itemPickedUp'] = true;
                        $itemMatrix[$playerRow - 1][$playerCol - 1] = 0;
                    }
            } elseif ($cellValue == 2) {
                
            } elseif ($cellValue == 3) {
                
                if (triggerEvent('Enemy', $character)) {
                    $itemMatrix[$playerRow - 1][$playerCol - 1] = 0;
                }
            } elseif ($cellValue == 9) {
                $cellValue = $itemMatrix[$playerRow - 1][$playerCol - 1];

                if ($cellValue == 9) {

                    $_SESSION['teleportMessage'] = true;
                }

            }

            
            setcookie('playerRow', $playerRow, time() + 3600);
            setcookie('playerCol', $playerCol, time() + 3600);
            header('Location: game.php');
            exit;
        }

        
        for ($row = 1; $row <= 10; $row++) {
            echo '<tr>';
            for ($col = 1; $col <= 10; $col++) {
                $cellValue = $itemMatrix[$row - 1][$col - 1];
                $isPlayerCell = ($row == $playerRow && $col == $playerCol);
                $isItemCell = ($cellValue == 1 || ($cellValue > 20 && $cellValue < 30));
                $isEnemyCell = ($cellValue == 3);
                $isWallCell = ($cellValue == 2);
                $isTeleportCell = ($cellValue == 9);

                echo '<td' . ($isPlayerCell ? ' class="grid-cell-content"' : '') . '>';
                if ($isPlayerCell) echo '<div class="player-cell"></div>';
                if ($isItemCell) echo '<div class="item-cell">' . '✨' . '</div>';
                if ($isEnemyCell) echo '<div class="enemy-cell">⚔</div>';
                if ($isWallCell) echo '<div class="wall-cell"">-</div>';
                if ($isTeleportCell) echo '<div class="teleport-cell">╩</div>';
                echo '</td>';
            }
            echo '</tr>';
        }
        ?>
    </table>
</div>

<?php
include_once('../functions/character.php');

$playerRow = 0;
$playerCol = 0;
$currentArea = 'dead';

if (!isset($_SESSION['character'])) {
    
    header("Location: ../main/main.php");
    exit;
}

if (isset($_POST['reset'])) {
    
    if (isset($_SERVER['HTTP_COOKIE'])) {
        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
        foreach($cookies as $cookie) {
            $parts = explode('=', $cookie);
            $name = trim($parts[0]);
            setcookie($name, '', time() - 1000, '/');
        }
    }
    session_destroy();
    header("Location: ../main/main.php");
    exit;
}

?>


<div id="game-container">
    <h1>Game Over</h1>
    <p>Unfortunately, you have lost. Would you like to start a new game?</p>
    <form method="post">
        <button type="submit" name="reset" class="resetButton">NEW GAME</button>
    </form>
</div>

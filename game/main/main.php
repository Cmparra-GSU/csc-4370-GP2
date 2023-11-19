<?php
include('../functions/character.php');

$content = 'menu.php';
$hasSavedCharacter = isset($_COOKIE['savedCharacter']);

if (!$hasSavedCharacter) {
    if (isset($_GET['action']) && $_GET['action'] === 'new_game') {
        $content = 'character-creation.php';
    }
} else {
    if (isset($_GET['action']) && $_GET['action'] === 'load_game') {
        $content = 'load.php';
    }
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css"> 
    <title>The Game</title>
</head>
<body>
    <div id="game-container">
    <h1 class="logo">
    <span>L</span>
    <span>a</span>
    <span>b</span>
    <span>y</span>
    <span>r</span>
    <span>i</span>
    <span>n</span>
    <span>t</span>
    <span>h</span>
    <span> </span>
    <span>o</span>
    <span>f</span>
    <span> </span>
    <span>E</span>
    <span>n</span>
    <span>i</span>
    <span>g</span>
    <span>m</span>
    <span>a</span>
    <span>s</span>
    </h1>


<br><br><br>
        
        <div id="content">
            <?php include($content); ?>
        </div>
    </div>
</body>
</html>

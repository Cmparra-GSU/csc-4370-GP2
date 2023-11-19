<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['characterName'])) {
        
        $characterName = $_POST['characterName'];

        
        $character = new Character($characterName);

        

        
        $character->saveCharacter();

        
        echo '<div id="character-creation-container">';
        echo '<p>Creating Character...</p>';
        echo '</div>';

        
        header("refresh: 3; url=../field-one/game.php");
        exit;
    }
}
?>

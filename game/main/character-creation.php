<?php

include_once '../functions/character.php'; 

session_start();


$characterName = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['characterName'])) {

        $characterName = $_POST['characterName'];
        $character = new Character($characterName);
        $_SESSION['characterName'] = $characterName;
        $_SESSION['character'] = $character;
        $_SESSION['position'] = 0;
        header("Location: ../field-one/game.php");

        exit;
    }
}
?>


    <div id="character-creation-container">
        <h2>Create Your Character</h2>
        <br>
        <form method="post" action="character-creation.php">
            <label for="character-name">Character Name:</label><br><br>
            <input type="text" name="characterName" id="character-name" required value="<?php echo htmlspecialchars($characterName); ?>"><br><br>
            <div class="menu-buttons">
                <button type="submit">Create Character</button>
            </div>
        </form>
    </div>


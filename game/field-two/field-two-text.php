<?php

$first= [

];

$itemPickupText = isset($_SESSION['pickedItemName']) ? 'A ' . $_SESSION['pickedItemName'] : 'An item';

$itemPickup = [
    [
        'speaker' => 'You',
        'text' => $itemPickupText . '.', 
        'next' => 'first'
    ],
];

$battle = [
    [
        'speaker' => '',
        'text' => 'Spotted by the enemy!',
        'moveto' => 'battle',
    ],
];

$teleporterText = [

    [
    'speaker' => 'Teleporter',
    'text' => 'You step onto the teleporter platform.',
        'moveto' => 'field-three',
],
];

?>


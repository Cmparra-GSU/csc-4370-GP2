<?php
include('intro-text.php');
include('intro-visuals.php');
$playerRow = isset($_COOKIE['playerRow']) ? $_COOKIE['playerRow'] : 1;
$playerCol = isset($_COOKIE['playerCol']) ? $_COOKIE['playerCol'] : 1;
$currentPosition = 0; 
$currentArea = 'intro'; 




?>
<?php 

require_once 'libraries/Event.php';
require_once 'libraries/Game.php';
//require_once 'libraries/Gameplay.php';
require_once 'libraries/GameState.php';
require_once 'libraries/BoardGame.php';
require_once 'libraries/Inning.php';
require_once 'libraries/Result.php';
require_once 'libraries/Scorecard.php';
require_once 'libraries/Team.php';
require_once 'libraries/TeamInning.php';
require_once 'vendor/oodle/krumo/class.krumo.php';

$game = new Game( 'hou', 'nya', 'Doubleday Field' );

$game_result = $game->play_game();


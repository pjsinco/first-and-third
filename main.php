<?php
require_once 'libraries/class-game-state.php';
require_once 'libraries/class-result.php';
require_once 'vendor/oodle/krumo/class.krumo.php';

$game_state = new GameState();

$game_state->outs = 0;
$game_state->inning = 3;
$game_state->half = 'top';
$game_state->bases = 5;
$game_state->zero_outs = true;
$game_state->two_outs = false;
$game_state->home_team_runs = 3;
$game_state->away_team_runs = 2;
$game_state->p_sym = 'x';
$game_state->against = 'b';
$game_state->infield = 'c' ;
$game_state->fielding = 2;
$game_state->double_cols = false;
$game_state->star14 = false;
$game_state->batter_speed = 'n';
$game_state->on_1b_speed = 's';
$game_state->on_2b_speed = null;
$game_state->on_3b_speed = 'f';
$game_state->play_it_safe = null;


// get a random value to look up
$possibles = array( 1, 9, 12, 14, 21, 29, 37 );
$val = ( string ) rand( 0, count( $possibles ) - 1 );

echo $possibles[$val] . PHP_EOL;
$result = new Result( $possibles[$val], $game_state );
//$result = new Result( 12, $game_state );
k($result);
?>

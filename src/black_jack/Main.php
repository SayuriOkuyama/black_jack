<?php

namespace BlackJack;

require_once('Game.php');
require_once('Player.php');
require_once('Dealer.php');
require_once('Deck.php');
require_once('Judge.php');


// プレイヤーを生成する
$player = new Player();
// ディーラーを生成する
$dealer = new Dealer();
// デッキを生成する
$deck = new Deck();
// 判定係を生成する
$judge = new Judge();

// 上記インスタンスを渡してゲームを開始する
$game = new Game($player, $dealer, $deck, $judge);

// ゲームスタート
$game->start();

// プレイヤーのターン
$under21 = $game->playerTurn();

// プレイヤーの得点が21を超えていなければ
if ($under21) {
    // ディーラーのターン
    $game->dealerTurn();
}

// 結果発表
$game->showResult($under21);

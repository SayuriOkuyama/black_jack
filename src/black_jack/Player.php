<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

class Player implements User
{
    // 表示名を定義
    public string $userName = "あなた";
    // プレイヤーのカードを保持する
    public array $drawnCards;
    // プレイヤーの得点を保持
    public int $userScore;

    // カードを引いて、
    public function drawCard(Deck $deck)
    {
        return $deck->drawCard();
    }
}

<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

class Dealer implements User
{
    // 表示名を定義
    public string $userName = "ディーラー";
    // ディーラーのカードを保持 [[$mark,$numAl].[$mark,$numAl],...]
    public array $drawnCards = [];
    // ディーラーのスコアを保持
    public int $userScore;

    // カードを引く
    public function drawCard(Deck $deck)
    {
        return $deck->drawCard();
    }
}

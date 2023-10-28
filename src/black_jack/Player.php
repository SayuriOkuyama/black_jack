<?php

namespace BlackJack;

require_once('User.php');
require_once('Deck.php');

class Player implements User
{
    // 表示名を定義
    public string $userName = "あなた";
    // プレイヤーのカードを保持する [[$mark,$numAl].[$mark,$numAl],...]
    public array $drawnCards;
    // プレイヤーの得点を保持
    public int $userScore;

    // カード（インスタンス）を引く
    public function drawCard(Deck $deck): object
    {
        return $deck->drawCard();
    }

    public function selectContinue(): bool
    {
        while (true) {
            $continue = trim(fgets(STDIN));
            if ($continue == "Y") {
                return true;
            } elseif ($continue == "N") {
                return false;
            } else {
                echo "Y か N を入力してください";
            }
        }
    }
}

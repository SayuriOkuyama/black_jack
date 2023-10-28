<?php

namespace BlackJack;

require_once('Deck.php');

class Judge
{
    // カードのランク表 ['A' => 1, '2' => 2, ... 'Q' => 12, 'K' => 13 ]
    private array $cardRanks;

    public function __construct()
    {
        define('CARD_RANK', (function () {
            $cardRanks = [];
            // A から K まで回す
            $rank = 1;
            foreach (Deck::CARD_NUM as $cardNum) {
                // 1 から始めてランクを割り当てていく
                $cardRanks[$cardNum] = $rank;
                $rank++;
            }
            // ['A' => 1, '2' => 2, ... 'Q' => 12, 'K' => 13 ]
            $this->cardRanks = $cardRanks;
        })());
    }

    // スコアを算出して返す
    public function calculateScore(array $drawnCards, User $user): int
    {
        // カード情報の数字（アルファベット）をキーとするカードランクを取得
        // $drawnCards [["ハート","A"],["ハート","8"],...]
        $ranks = array_map(fn ($drawnCard) => $this->cardRanks[$drawnCard[1]], $drawnCards);;

        // ランクを合計してスコアに格納
        $user->userScore = array_sum($ranks);

        // 得点を返す
        return $user->userScore;
    }

    // 勝敗判定
    public function judgeWinner(Player $player, Dealer $dealer, $under21): void
    {
        // プレイヤーの得点が21を超えていない場合
        if ($under21) {

            echo "あなたの得点は{$player->userScore}です。" . PHP_EOL;
            echo "ディーラーの得点は{$dealer->userScore}です。" . PHP_EOL;

            // それぞれの得点の、21との差を求める
            $playerDifference = abs($player->userScore - 21);
            $dealerDifference = abs($dealer->userScore - 21);

            // 差が小さい方が勝ち
            if ($playerDifference < $dealerDifference) {
                echo "あなたの勝ちです！" . PHP_EOL;
            } elseif ($playerDifference > $dealerDifference) {
                echo "ディーラーの勝ちです。" . PHP_EOL;
            } elseif ($playerDifference === $dealerDifference) {
                echo "引き分けです。" . PHP_EOL;
            }
        } else {
            echo "あなたの得点は{$player->userScore}です。" . PHP_EOL;
            echo "あなたの得点が21を超えました。" . PHP_EOL;
            echo "ディーラーの勝ちです。" . PHP_EOL;
        }
    }
}

<?php

namespace BlackJack;

require_once('Player.php');
require_once('Dealer.php');
require_once('Deck.php');

// ゲーム全体の進行を扱う
class Game
{
    //プレイヤー、ディーラー、デッキのインスタンスを受け取りゲームの準備
    public function __construct(public Player $player, public Dealer $dealer, public Deck $deck)
    {
    }

    // ゲームスタート
    public function start(): void
    {
        // ゲーム開始の合図
        echo "ブラックジャックを開始します。" . PHP_EOL;

        // 表示用の情報を入れる箱
        $info = [];

        // プレイヤーとディーラーがそれぞれカードを２枚ずつ引く
        foreach ([$this->player, $this->dealer] as $user) {
            for ($i = 1; $i <= 2; $i++) {
                // カードインスタンスを引く
                $card = $user->drawCard($this->deck);
                // カードの情報を取得 [$mark,$numAl]
                $cardInfo = $card->getCardInfo();
                // ユーザーの手持ちカードに加える [[$mark,$numAl].[$mark,$numAl],...]
                $user->drawnCards[] = $cardInfo;
                // 表示用の情報をまとめる [[$user,$mark,$numAl],[user,$mark,$numAl]]
                $info[] = array_merge([$user->userName], $cardInfo);
            }
        }

        // 配列の最後の要素を削除し、ディーラーの２枚目の情報を削除
        array_pop($info);

        // プレイヤーの２枚、ディーラーの１枚目のカードの開示
        $this->showCard($info);

        echo "ディーラーの引いた2枚目のカードはわかりません。" . PHP_EOL;
    }

    public function showCard(array $allInfo): void
    {
        foreach ($allInfo as $info) {
            echo "{$info[0]}の引いたカードは{$info[1]}の{$info[2]}です。" . PHP_EOL;
        }
    }
}

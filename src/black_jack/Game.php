<?php

namespace BlackJack;

require_once('Player.php');
require_once('Dealer.php');
require_once('Deck.php');
require_once('Judge.php');

// ゲーム全体の進行を扱う
class Game
{
    //プレイヤー、ディーラー、デッキのインスタンスを受け取りゲームの準備
    public function __construct(public Player $player, public Dealer $dealer, public Deck $deck, public Judge $judge)
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
                $allInfo[] = array_merge([$user->userName], $cardInfo);
            }
        }

        // 配列の最後の要素を削除し、ディーラーの２枚目の情報を削除
        array_pop($allInfo);

        // プレイヤーの２枚、ディーラーの１枚目のカードの開示
        foreach ($allInfo as $info) {
            $this->showCard($info);
        }

        echo "ディーラーの引いた2枚目のカードはわかりません。" . PHP_EOL;
    }

    public function showCard(array $info): void
    {
        echo "{$info[0]}の引いたカードは{$info[1]}の{$info[2]}です。" . PHP_EOL;
    }

    // プレイヤーターン。スコアを確認し、続けるか決める
    public function playerTurn(): void
    {
        $continue = true;

        while ($continue) {
            // 現時点でのスコアを算出
            $this->player->userScore = $this->judge->calculateScore($this->player->drawnCards, $this->player);

            echo "あなたの現在の得点は{$this->player->userScore}です。カードを引きますか？（Y/N）" . PHP_EOL;
            // もう一枚引くかの分岐
            $continue = $this->player->selectContinue();

            if ($continue) {
                // カードインスタンスを引く
                $card = $this->player->drawCard($this->deck);
                // カードの情報を取得 [$mark,$numAl]
                $cardInfo = $card->getCardInfo();
                // ユーザーの手持ちカードに加える [[$mark,$numAl].[$mark,$numAl],...]
                $this->player->drawnCards[] = $cardInfo;
                // 表示用にユーザー名も加える
                $info = array_merge([$this->player->userName], $cardInfo);
                // 取得結果を表示する
                $this->showCard($info);
            }
        }
    }

    public function DealerTurn(): void
    {
        // ディーラーの２枚目のカードを開示
        echo "ディーラーの引いた2枚目のカードは{$this->dealer->drawnCards[1][0]}の{$this->dealer->drawnCards[1][1]}でした。" . PHP_EOL;

        // 現時点でのスコアを算出
        $this->dealer->userScore = $this->judge->calculateScore($this->dealer->drawnCards, $this->dealer);

        while ($this->dealer->userScore < 17) {
            echo "ディーラーのの現在の得点は{$this->dealer->userScore}です。" . PHP_EOL;

            // カードインスタンスを引く
            $card = $this->dealer->drawCard($this->deck);
            // カードの情報を取得 [$mark,$numAl]
            $cardInfo = $card->getCardInfo();

            // ユーザーの手持ちカードに加える [[$mark,$numAl].[$mark,$numAl],...]
            $this->dealer->drawnCards[] = $cardInfo;
            // 表示用にユーザー名も加える
            $info = array_merge([$this->dealer->userName], $cardInfo);

            // 取得結果を表示する
            $this->showCard($info);

            // 現時点でのスコアを算出
            $this->dealer->userScore = $this->judge->calculateScore($this->dealer->drawnCards, $this->dealer);
        }
    }

    // 結果表示
    public function showResult(): void
    {
        echo "あなたの得点は{$this->player->userScore}です。" . PHP_EOL;
        echo "ディーラーの得点は{$this->dealer->userScore}です。" . PHP_EOL;

        echo $this->judge->judgeWinner($this->player, $this->dealer);

        echo "ブラックジャックを終了します。" . PHP_EOL;
    }
}

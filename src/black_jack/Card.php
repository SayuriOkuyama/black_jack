<?php

namespace BlackJack;

class Card
{
    // カード生成時に、マークと数値（もしくはアルファベット）をそれぞれ受け取る
    public function __construct(public string $mark, public string $numberOrAlphabet)
    {
    }

    // マークを返す
    public function getCardInfo()
    {
        return [$this->mark, $this->numberOrAlphabet];
    }

    // // 数値部分を返す
    // public function getNum()
    // {
    //     return ;
    // }
}

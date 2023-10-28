<?php

namespace BlackJack;

interface User
{
    // カードを引く
    public function drawCard(Deck $deck);

    // もう一枚引くか選択
    public function selectContinue();
}

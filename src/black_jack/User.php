<?php

namespace BlackJack;

interface User
{
    // カードを引く
    public function drawCard(Deck $deck);
}

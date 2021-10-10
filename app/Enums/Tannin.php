<?php

namespace App\Enums;

enum Tannin : string
{
    case None = '';
    case Tannin = 'Tannin [T3]';
    case RestedTannin = 'Rested Tannin [T4]';
    case AgedTannin = 'Aged Tannin [T5]';
}
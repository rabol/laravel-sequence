<?php
declare(strict_types=1);

namespace Guava\Sequence\Enums;


enum ResetFrequency: string
{
    case Yearly = 'yearly';
    case Monthly = 'monthly';
    case Daily = 'daily';
}

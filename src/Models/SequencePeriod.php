<?php

declare(strict_types=1);

namespace Guava\Sequence\Models;

use Guava\Sequence\Database\Factories\SequencePeriodFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $date
 * @property int $ordinal_number
 */
class SequencePeriod extends Model
{
    use HasFactory;

    public $table = 'sequence_periods';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return SequencePeriodFactory::new();
    }

    /**
     * @var array<string>
     */
    protected $fillable = [
        'date',
        'ordinal_number',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'ordinal_number' => 'integer',
    ];
}

<?php
declare(strict_types=1);

namespace Guava\Sequence;

use DateTimeInterface;
use Guava\Sequence\Models\SequencePeriod;
use Guava\Sequence\Models\SequenceRule;

class SequenceQuery
{
    /**
     * Find sequence rule for given type.
     *
     * @param string $type
     * @return  SequenceRule|null
     */
    public function findSequenceRule(string $type): ?SequenceRule
    {
        return SequenceRule::query()
            ->where('type', $type)
            ->first();
    }

    /**
     * Find sequence period for given sequence rule and date.
     *
     * @param SequenceRule $sequenceRule
     * @param DateTimeInterface $date
     * @return  SequencePeriod|null
     */
    public function findSequencePeriod(SequenceRule $sequenceRule, DateTimeInterface $date): ?SequencePeriod
    {
        return $sequenceRule->periods()
            ->when($sequenceRule->needsYearlyReset(), function ($query) use ($date) {
                $query->whereYear('date', $date->format('Y'));
            })
            ->when($sequenceRule->needsMonthlyReset(), function ($query) use ($date) {
                $query->whereMonth('date', $date->format('m'));
            })
            ->when($sequenceRule->needsDailyReset(), function ($query) use ($date) {
                $query->whereDay('date', $date->format('d'));
            })
            ->first();
    }

    /**
     * Create new sequence period for given sequence rule and date.
     *
     * @param SequenceRule $sequenceRule
     * @param DateTimeInterface $date
     * @return  SequencePeriod
     */
    public function createSequencePeriod(SequenceRule $sequenceRule, DateTimeInterface $date): SequencePeriod
    {
        return $sequenceRule->periods()->create([
            'date' => $date->format('Y-m-d'),
            'ordinal_number' => 1,
        ]);
    }
}

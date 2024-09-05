<?php

declare(strict_types=1);

namespace Guava\Sequence;

use DateTimeInterface;
use InvalidArgumentException;

class SequenceFactory
{
    /**
     * The instance of sequence query helper.
     *
     * @var \Guava\Sequence\SequenceQuery
     */
    protected $query;

    /**
     * The sequence factory constructor.
     */
    public function __construct(SequenceQuery $query)
    {
        $this->query = $query;
    }

    /**
     * Create instance of sequence.
     */
    public function create(string $type, DateTimeInterface $date): Sequence
    {
        $sequenceRule = $this->query->findSequenceRule($type);

        if ($sequenceRule === null) {
            throw new InvalidArgumentException("Cannot find sequence rule for \"{$type}\" type.");
        }

        $sequencePeriod = $this->query->findSequencePeriod($sequenceRule, $date);

        if ($sequencePeriod === null) {
            $sequencePeriod = $this->query->createSequencePeriod($sequenceRule, $date);
        }

        return new Sequence(
            $sequencePeriod,
            $sequenceRule->pattern,
            $date
        );
    }
}

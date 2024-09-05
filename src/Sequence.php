<?php
declare(strict_types=1);

namespace Guava\Sequence;

use DateTimeInterface;
use Guava\Sequence\Models\SequencePeriod;
use Illuminate\Support\Stringable;

class Sequence
{
    /**
     * The period instance to use on sequence.
     *
     * @var  \Guava\Sequence\Models\SequencePeriod
     */
    protected $period;

    /**
     * The date to use on sequence.
     *
     * @var  DateTimeInterface
     */
    protected $date;

    /**
     * The number pattern to use on sequence.
     *
     * @var  string
     */
    protected $pattern;

    /**
     * The sequence constructor.
     *
     * @param \Guava\Sequence\Models\SequencePeriod $period
     * @param string $pattern
     * @param DateTimeInterface $date
     */
    public function __construct(SequencePeriod $period, string $pattern, DateTimeInterface $date)
    {
        $this->period = $period;
        $this->pattern = $pattern;
        $this->date = $date;
    }

    /**
     * Get the sequence number.
     *
     * @return  string
     */
    public function getNumber(bool $increment = false): string
    {
//        dd(str($this->getPattern())
//            ->pipe(fn(Stringable $str) => str(strtr($str->toString(), [
//            '{number}'      => $this->getOrdinalNumber(),
//            '{day}'         => $this->date->format('d'),
//            '{month}'       => $this->date->format('m'),
//            '{year}'        => $this->date->format('Y'),
//            '{day_short}'   => $this->date->format('j'),
//            '{month_short}' => $this->date->format('n'),
//            '{year_short}'  => $this->date->format('y'),
//        ]))));
        $result = strtr(
            str($this->getPattern())
                ->replaceMatches(
                    '/\{number:(\d+)\}/',
                    fn($matches) => str_pad(
                        (string)$this->getOrdinalNumber(),
                        (int)$matches[1],
                        "0",
                        STR_PAD_LEFT
                    )
                )
                ->toString(),
            [
                '{number}' => $this->getOrdinalNumber(),
                '{day}' => $this->date->format('d'),
                '{month}' => $this->date->format('m'),
                '{year}' => $this->date->format('Y'),
                '{day_short}' => $this->date->format('j'),
                '{month_short}' => $this->date->format('n'),
                '{year_short}' => $this->date->format('y'),
            ]
        );

        if ($increment) {
            $this->increment();
        }

        return $result;
    }

    /**
     * Get the ordinal number of sequence.
     *
     * @return  int
     */
    public function getOrdinalNumber(bool $increment = false): int
    {
        $result = $this->period->ordinal_number;

        if ($increment) {
            $this->increment();
        }

        return $result;
    }

    /**
     * Get the pattern of sequence.
     *
     * @return  string
     */
    public function getPattern(): string
    {
        return $this->pattern;
    }

    /**
     * Increment ordinal number of period.
     *
     * @return  void
     */
    public function increment(): void
    {
        $this->period->increment('ordinal_number');
    }
}

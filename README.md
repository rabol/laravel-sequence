# Laravel Sequence

This is a fork for Laravel 11 of the original package [nextgen-tech/laravel-sequence](github.com/nextgen-tech/laravel-sequence) with a few minor tweaks / enhancements.

Generate sequential numbers with pattern (e.g. for invoice numbers)

## Features

* Easy integration
* Multiple pattern placeholders
* Support for three most common reset frequencies
* Automatically creating new ordinal number based on reset frequency
* Laravel 11 support

## Installation

```sh
composer require nextgen-tech/laravel-sequence
```

## Usage

```php
use Carbon\Carbon;
use Guava\Sequence\Enums\ResetFrequency;
use Guava\Sequence\Models\SequenceRule;
use Guava\Sequence\SequenceFactory;

/**
 * Create new sequence rule. It needs to be done only once.
 */
SequenceRule::create([
    'type'            => 'invoice',
    'pattern'         => '{number}/COMPANY/{year}',
    'reset_frequency' => ResetFrequency::Yearly,
]);

/**
 * Make sequence factory via container or DI.
 */
$factory = app(SequenceFactory::class);

/**
 * Create sequence by passing sequence type and date (e.g. issue date of invoice).
 */
$sequence = $factory->create(
    'invoice',
    Carbon::createFromFormat('Y-m-d', '2021-06-01')
);

/**
 * Public methods of sequence.
 */
$ordinal = $sequence->getOrdinalNumber(); // e.g. 21
$number  = $sequence->getNumber();        // e.g. 21/COMPANY/2021
$pattern = $sequence->getPattern();       // e.g. {number}/COMPANY/{year}

/**
 * After use of generated number, manual increment of ordinal number is required.
 */
$sequence->increment();
```

## Reset Frequencies

Sequences supports three most commonly used reset frequencies. `\Guava\Sequence\Enums\ResetFrequency` class should be used when creating new sequence rule.

* `ResetFrequency::Yearly` - resets ordinal number at the beginning of new year
* `ResetFrequency::Monthly` - resets ordinal number at the beginning of new month
* `ResetFrequency::Daily` - resets ordinal number at the beginning of new day

## Pattern Placeholders

| Placeholder               | Description                                                                              | Example |
|---------------------------|------------------------------------------------------------------------------------------|---------|
| `{number}`                | generated, ordinal number                                                                | 4       |
| `{number:<x>}`            | generated, ordinal number, padded to the given length. Replace `<x>` by the desired length | 0004    |
| `{day}`, `{DD}`           | day of passed date with leading zero                                                     | 05      |
| `{month}`, `{MM}`         | month of passed date with leading zero                                                   | 03      |
| `{year}`, `{YYYY}`        | full year of passed date                                                                 | 2021    |
| `{day_short}`, `{D}`      | day of passed date without leading zero                                                  | 5       |
| `{month_short}`, `{M}`    | month of passed date without leading zero                                                | 3       |
| `{year_short}`, `{YY}`    | short year of passed date                                                                | 21      |

## Credits
This package is a fork of [nextgen-tech/laravel-sequence](https://github.com/nextgen-tech/laravel-sequence)

- Credits to the original author [Krzysztof Grabania](https://github.com/Dartui)
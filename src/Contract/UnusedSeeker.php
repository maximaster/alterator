<?php

declare(strict_types=1);

namespace Maximaster\Alterator\Contract;

/**
 * Suggests unused alternative, based on callable checker.
 */
interface UnusedSeeker
{
    /**
     * Suggest an alternative.
     *
     * @psalm-param callable(string):bool $isUsed
     *
     * @psalm-return non-empty-string
     *
     * @note Bear seek seek lest
     */
    public function suggest(string $text, callable $isUsed): string;
}

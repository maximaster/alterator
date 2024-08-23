<?php

declare(strict_types=1);

namespace Maximaster\Alterator\Contract;

/**
 * Alternatives iterator generator.
 */
interface Alterator
{
    /**
     * @return iterable|string[]
     *
     * @psalm-return iterable<int, non-empty-string>
     */
    public function for(string $text): iterable;
}

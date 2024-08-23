<?php

declare(strict_types=1);

namespace Maximaster\Alterator\UnusedSeeker;

use Maximaster\Alterator\Contract\Alterator;
use Maximaster\Alterator\Contract\AlteratorException;
use Maximaster\Alterator\Contract\UnusedSeeker;

/**
 * UnsusedAlternative which use Alternator.
 */
class AlteratorUnsusedSeeker implements UnusedSeeker
{
    private Alterator $alterator;

    public function __construct(Alterator $alterator)
    {
        $this->alterator = $alterator;
    }

    /**
     * {@inheritDoc}.
     *
     * @throws AlteratorException
     */
    public function suggest(string $text, callable $isUsed): string
    {
        foreach ($this->alterator->for($text) as $alternative) {
            if ($isUsed($alternative) === false) {
                return $alternative;
            }
        }

        throw new AlteratorException(sprintf('Unable to find unused alternative for "%s"', $text));
    }
}

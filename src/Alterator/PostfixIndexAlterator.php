<?php

declare(strict_types=1);

namespace Maximaster\Alterator\Alterator;

use Generator;
use Maximaster\Alterator\Contract\Alterator;

/**
 * Alternatives iterator generator which insert index at the end of an input.
 */
class PostfixIndexAlterator implements Alterator
{
    public const DEFAULT_TEMPLATE = ' (%d)';
    public const DEFAULT_LAST_INDEX = PHP_INT_MAX;

    private string $template;

    /** @psalm-var non-empty-string */
    private string $templateRegex;

    private int $lastIndex;

    /**
     * @psalm-param non-empty-string $template Template for sprintf
     * @psalm-param int<1, max> $lastIndex Last allowed index
     */
    public function __construct(string $template = self::DEFAULT_TEMPLATE, int $lastIndex = self::DEFAULT_LAST_INDEX)
    {
        $this->template = $template;
        $this->templateRegex = $this->compileTemplateRegex($template);
        $this->lastIndex = $lastIndex;
    }

    public function for(string $text): Generator
    {
        $index = 0;
        $match = [];
        if (preg_match($this->templateRegex, $text, $match) === 1) {
            $index = (int) $match[1];
            $text = preg_replace('/' . preg_quote($match[0]) . '$/', '', $text);
        }

        while (true) {
            if (++$index > $this->lastIndex) {
                break;
            }

            yield $index => sprintf('%s' . $this->template, $text, $index);
        }
    }

    /**
     * @psalm-param non-empty-string $template
     *
     * @psalm-return non-empty-string
     */
    private function compileTemplateRegex(string $template): string
    {
        $regex = '/';

        foreach (preg_split('/(%d)/', $template, -1, PREG_SPLIT_DELIM_CAPTURE) as $part) {
            switch ($part) {
                case '%d':
                    $regex .= '(\d+)';
                    break;
                default:
                    $regex .= preg_quote($part);
            }
        }

        return $regex . '$/';
    }
}

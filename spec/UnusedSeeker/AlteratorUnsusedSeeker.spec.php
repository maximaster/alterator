<?php

declare(strict_types=1);

use Maximaster\Alterator\Alterator\PostfixIndexAlterator;
use Maximaster\Alterator\UnusedSeeker\AlteratorUnsusedSeeker;

describe(AlteratorUnsusedSeeker::class, function (): void {
    it('should suggest available alternative for clean input', function (): void {
        $unusedSeeker = new AlteratorUnsusedSeeker(
            new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5)
        );

        expect($unusedSeeker->suggest('hello', static fn () => false))->toBe('hello (1)');
    });

    it('should suggest available alternative for alternative input', function (): void {
        $unusedSeeker = new AlteratorUnsusedSeeker(
            new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5)
        );

        expect($unusedSeeker->suggest('hello (1)', static fn () => false))->toBe('hello (2)');
    });

    it('should not suggest unavailable alternative', function (): void {
        $unusedSeeker = new AlteratorUnsusedSeeker(
            new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5)
        );

        expect(fn () => $unusedSeeker->suggest('hello', static fn () => true))
            ->toThrow('Unable to find unused alternative for "hello"');
    });
});

<?php

declare(strict_types=1);

use Maximaster\Alterator\Alterator\PostfixIndexAlterator;

describe(PostfixIndexAlterator::class, function (): void {
    it('should iterate clear name', function (): void {
        $alterator = new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5);

        expect(iterator_to_array($alterator->for('hello')))->toBe([
            1 => 'hello (1)',
            2 => 'hello (2)',
            3 => 'hello (3)',
            4 => 'hello (4)',
            5 => 'hello (5)',
        ]);
    });

    it('should iterate alternative name', function (): void {
        $alterator = new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5);

        expect(iterator_to_array($alterator->for('hello (1)')))->toBe([
            2 => 'hello (2)',
            3 => 'hello (3)',
            4 => 'hello (4)',
            5 => 'hello (5)',
        ]);
    });

    it('should not iterate over limit', function (): void {
        $alterator = new PostfixIndexAlterator(PostfixIndexAlterator::DEFAULT_TEMPLATE, 5);

        expect(iterator_to_array($alterator->for('hello (5)')))->toBe([]);
    });
});

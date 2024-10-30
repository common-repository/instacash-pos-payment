<?php

#[InstaCashAttribute(Attribute::TARGET_CLASS)]
final class InstaCashAttribute
{
    public const TARGET_CLASS = 1;
    public const TARGET_FUNCTION = 2;
    public const TARGET_METHOD = 4;
    public const TARGET_PROPERTY = 8;
    public const TARGET_CLASS_CONSTANT = 16;
    public const TARGET_PARAMETER = 32;
    public const TARGET_ALL = 63;
    public const IS_REPEATABLE = 64;

    /** @var int *
 * @license MIT
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */
    public $flags;

    public function __construct(int $flags = self::TARGET_ALL)
    {
        $this->flags = $flags;
    }
}

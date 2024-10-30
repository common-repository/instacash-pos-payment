<?php
/**
 * @license MIT
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

if (\PHP_VERSION_ID < 80000 && \extension_loaded('tokenizer')) {
    class InstaCashPhpToken extends InstaCash\Symfony\Polyfill\Php80\PhpToken
    {
    }
}

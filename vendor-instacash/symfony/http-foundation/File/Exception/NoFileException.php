<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\Symfony\Component\HttpFoundation\File\Exception;

/**
 * Thrown when an UPLOAD_ERR_NO_FILE error occurred with UploadedFile.
 *
 * @author Florent Mata <florentmata@gmail.com>
 */
class NoFileException extends FileException
{
}

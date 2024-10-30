<?php
/**
 * @license MIT
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\GuzzleHttp;

use InstaCash\Psr\Http\Message\MessageInterface;

final class BodySummarizer implements BodySummarizerInterface
{
    /**
     * @var int|null
     */
    private $truncateAt;

    public function __construct(int $truncateAt = null)
    {
        $this->truncateAt = $truncateAt;
    }

    /**
     * Returns a summarized message body.
     */
    public function summarize(MessageInterface $message): ?string
    {
        return $this->truncateAt === null
            ? \InstaCash\GuzzleHttp\Psr7\Message::bodySummary($message)
            : \InstaCash\GuzzleHttp\Psr7\Message::bodySummary($message, $this->truncateAt);
    }
}

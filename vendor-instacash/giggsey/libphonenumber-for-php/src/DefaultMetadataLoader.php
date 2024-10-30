<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

class DefaultMetadataLoader implements MetadataLoaderInterface
{
    public function loadMetadata($metadataFileName)
    {
        return include $metadataFileName;
    }
}

<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

interface MetadataLoaderInterface
{
    /**
     * @param string $metadataFileName File name (including path) of metadata to load.
     * @return mixed
     */
    public function loadMetadata($metadataFileName);
}

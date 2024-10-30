<?php
/**
 * @license Apache-2.0
 *
 * Modified by fintrous on 25-January-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace InstaCash\libphonenumber;

interface MetadataSourceInterface
{
    /**
     * Gets phone metadata for a region.
     * @param string $regionCode the region code.
     * @return PhoneMetadata the phone metadata for that region, or null if there is none.
     */
    public function getMetadataForRegion($regionCode);

    /**
     * Gets phone metadata for a non-geographical region.
     * @param int $countryCallingCode the country calling code.
     * @return PhoneMetadata the phone metadata for that region, or null if there is none.
     */
    public function getMetadataForNonGeographicalRegion($countryCallingCode);
}

<?php declare( strict_types = 1 );
/**
 * Format phone numbers to the required format.
 * php version 7.4.33
 *
 * @category Woocommerce-plugin
 * @package  instacashPos
 * @author   Fintrous Group Kft. <fintrous.com>
 * @license  GNU General Public License v3.0
 * @link     https://instacash.hu/
 */

namespace InstaCash\POS;

use InstaCash\libphonenumber\PhoneNumberUtil;
use InstaCash\libphonenumber\PhoneNumber;

/**
 * Phone number library extend.
 */
class Phone
{

    protected const DEFAULT_REGION = 'HU';

    /**
     * Number of Phone area code characters.
     *
     * @var int
     */
    protected $areaCodeLength;

    /**
     * Phone number manipulator class.
     *
     * @var \libphonenumber\PhoneNumberUtil
     */
    protected $phoneUtil;

    /**
     * Phone number handler class.
     *
     * @var \libphonenumber\PhoneNumber
     */
    protected $phoneNumber;

    /**
     * Init class.
     *
     * @param string $rawNumber
     */
    public function __construct( $rawNumber )
    {
        $this->phoneUtil      = PhoneNumberUtil::getInstance();
        $this->phoneNumber    = $this->phoneUtil->parse($rawNumber, self::DEFAULT_REGION);
        $this->areaCodeLength = $this->phoneUtil->getLengthOfNationalDestinationCode($this->phoneNumber);
    }

    /**
     * Check phone number validity.
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->phoneUtil->isValidNumber($this->phoneNumber);
    }

    /**
     * Check phone number internationality.
     *
     * @return boolean
     */
    public function isInternational()
    {
        return $this->phoneUtil->getRegionCodeForNumber($this->phoneNumber) !== self::DEFAULT_REGION;
    }

    /**
     * get Area code from number string.
     *
     * @return string
     */
    public function getAreaCode()
    {
        if (null === $this->phoneNumber->getNationalNumber() ) {
            return '';
        }
        return substr($this->phoneNumber->getNationalNumber(), 0, $this->areaCodeLength);
    }

    /**
     * get personal number from number string.
     *
     * @return string
     */
    public function getSubscriberNumber()
    {
        if (null === $this->phoneNumber->getNationalNumber() ) {
            return '';
        }
        return substr($this->phoneNumber->getNationalNumber(), $this->areaCodeLength);
    }

    /**
     * get the code of its region.
     *
     * @return int|null
     */
    public function getCountryCode()
    {
        return $this->phoneNumber->getCountryCode();
    }

    /**
     * Get number type.
     *
     * @return int
     */
    public function getNumberType()
    {
        return $this->phoneUtil->getNumberType($this->phoneNumber);
    }

    /**
     * Get base phone number.
     *
     * @return string
     */
    public function stripCountryCode()
    {
        return $this->getAreaCode() . $this->getSubscriberNumber();
    }

}

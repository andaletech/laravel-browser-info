<?php

namespace Andaletech\BrowserInfo;

use Illuminate\Contracts\Support\Arrayable;


/**
 * A class that provides relevent info about an accepted language such as the country, variation, and q.
 * 
 * @author Kolado Sidibe <kolado.sidibe@gmail.com>
 * @package Andaletech\BrowserInfo
 * @license MIT
 */

class AcceptedLanguage implements Arrayable, \ArrayAccess
{
    protected $rawLanguage;
    protected $language;
    protected $country;
    protected $variant;
    protected $q;
    protected $arrayed = [];
    public function __construct(string $lang, $q = 1.0)
    {
        $this->rawLanguage = $lang;
        $this->q = empty($q) ? 1.0 : $q;
        $this->setLanguageDetails($lang);
        $this->arrayed = [
            'raw_language' => $this->rawLanguage,
            'language' => $this->language,
            'country' => $this->country,
            'variant' => $this->variant,
            'q' => $this->q
        ];
    }

    /**
     * Get the value of language
     * 
     * @return string The accepted language as provided.
     */ 
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Get the value of country
     * 
     * @return string The country.
     */ 
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Get the language group
     * 
     * @return string The accepted language as provided.
     */ 
    public function getGroup()
    {
        return $this->language;
    }

    /**
     * Get the value of q
     * 
     * @return int|float The Q value of the accepted language.
     */ 
    public function getQ()
    {
        return $this->q;
    }

    public function toArray()
    {
        return $this->arrayed;
    }

    /**
     * Check to see if the browser supports the given language.
     * 
     * Return true if so, false otherwise.
     *
     * @param string $lang
     * @param bool $strict if strict is true, ********** then a test for "en" will not be matched if the browser ****
     * @return bool true if the browser supports the given lang. False otherwise.
     */
    public function supports(string $lang, $strict = false)
    {
        if(strcasecmp($this->rawLanguage, $lang) == 0)
        {
            return true;
        }
        if($strict)//no point continiuing
        {
            return false;
        }
        $details = $this->getLanguageDetails($lang);
        return strcasecmp($this->language, $details['language']) == 0;
    }


    /**
     * Determine if the given attribute exists.
     *
     * @param  mixed  $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->arrayed);
    }

    /**
     * Get the value for a given offset.
     *
     * @param  mixed  $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->arrayed[$offset] : null;
    }

    /**
     * Set the value for a given offset.
     *
     * @param  mixed  $offset
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * Unset the value for a given offset.
     *
     * @param  mixed  $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
    }

    public function setLanguageDetails(string $lang)
    {
        $split = explode('-', $lang);
        $details = $this->getLanguageDetails($lang);
        $this->language = $details['language'];
        $this->country = $details['country'];
        $this->variant = $details['variant'];
    }

    /**
     * Get the string representation of the Language.
     *
     * @return string
     */
    public function __toString()
    {
        return $this['language'];
    }
    /*#################### Protected Methods Section ####################*/
    protected function getLanguageDetails(string $lang)
    {
        $details = [];
        $split = explode('-', $lang);
        $details['language'] = $split[0];
        $details['country'] = array_has($split, 1) ? $split[1] : '';
        $details['variant'] = array_has($split, 2) ? $split[2] : '';
        return $details;
    }
}
<?php
/**
 * Date: 28.12.15
 * Time: 15:39
 */
namespace AjaxFormValidationBundle\Service;


class LocalizedConfigs
{

    /** @var array */
    private $config;

    /** @var string */
    private $locale;

    public function __construct(array $config, $locale)
    {
        $this->config = $config;
        $this->locale = $locale;
    }


    /**
     * @param string $field
     * @param null $locale
     *
     * @return string
     */
    public function getFormat($field, $locale = null)
    {
        if (null === $locale)
        {
            $locale = $this->locale;
        }

        if (!isset($this->config['formats'][$locale]))
        {
            $locale = 'default';
        }

        return $this->config['formats'][$locale][$field];
    }


}
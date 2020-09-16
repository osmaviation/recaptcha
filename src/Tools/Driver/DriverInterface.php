<?php

namespace OSMAviation\Recaptcha\Tools\Driver;

interface DriverInterface
{

    /**
     * Url getter
     *
     * @return string
     */
    public function getUrl();

    /**
     * Url setter
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url);

    /**
     * Get http response
     *
     * @param array $parameters
     * @return array|boolean
     */
    public function call($parameters = []);

}

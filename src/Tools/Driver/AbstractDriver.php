<?php

namespace OSMAviation\Recaptcha\Tools\Driver;

abstract class AbstractDriver
{
    protected $url;

    /**
     * @inheritDoc
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @inheritDoc
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    protected function errorLog(\Exception $e) {
        app('log')->error('[Recaptcha] request error: ' . $e->getMessage());
    }

}

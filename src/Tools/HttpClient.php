<?php

namespace OSMAviation\Recaptcha\Tools;

use Illuminate\Support\Facades\Http;

class HttpClient
{

    protected $url;

    /**
     * Url getter
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Url setter
     *
     * @param string $url
     * @return self
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get http response
     *
     * @param array $parameters
     * @return array|boolean
     */
    public function call($parameters = [])
    {
        try {
            return Http::timeout(app('config')->get('recaptcha.options.timeout', 1))
                ->get($this->url, $parameters)
                ->throw()
                ->json();
        } catch (\Exception $e) {
            app('log')->error('[Recaptcha] request error: ' . $e->getMessage());
            return false;
        }
    }
}

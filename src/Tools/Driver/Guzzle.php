<?php

namespace OSMAviation\Recaptcha\Tools\Driver;

use Illuminate\Support\Facades\Http;

class Guzzle extends AbstractDriver implements DriverInterface
{

    /**
     * @inheritDoc
     */
    public function call($parameters = [])
    {
        try {

            return Http::timeout(app('config')->get('recaptcha.options.timeout', 1))
                ->get($this->url, $parameters)
                ->throw()
                ->json();

        } catch (\Exception $e) {
            $this->errorLog($e);
            return false;
        }
    }
}

<?php

namespace OSMAviation\Recaptcha\Tools\Driver;

class Native extends AbstractDriver implements DriverInterface
{

    /**
     * @inheritDoc
     */
    public function call($parameters = [])
    {
        try {

            $url = $this->url;

            $checkResponse = null;

            if (count($parameters)) {
                $url .= '?' . http_build_query($parameters);
            }

            $checkResponse = file_get_contents($url);

            if (is_null($checkResponse) || empty($checkResponse)) {
                return false;
            }

            return json_decode($checkResponse, true);
        } catch (\Exception $e) {
            $this->errorLog($e);
            return false;
        }
    }
}

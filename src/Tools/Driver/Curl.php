<?php

namespace OSMAviation\Recaptcha\Tools\Driver;

class Curl extends AbstractDriver implements DriverInterface
{

    /**
     * @inheritDoc
     */
    public function call($parameters = [])
    {
        try {
            $url = $this->url;

            if (count($parameters)) {
                $url .= '?' . http_build_query($parameters);
            }
            $checkResponse = null;

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, app('config')->get('recaptcha.options.timeout', 1));
            if (app('config')->get('recaptcha.options.curl_verify') === false) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            }

            $checkResponse = curl_exec($curl);

            if (false === $checkResponse) {
                throw new \Exception(curl_error($curl));
            }

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

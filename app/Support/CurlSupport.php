<?php

namespace App\Support;

abstract class CurlSupport
{
    /**
     * build
     *
     * @var array */
    protected $build;

    /**
     * url
     *
     * @var string */
    protected $url;

    /**
     * customRequest [POST | PUT | GET | DELETE]
     *
     * @var string */
    protected $customRequest;

    /**
     * callback
     *
     * @var array */
    protected $callback;

    /**
     * Constructor of CurlSupport
     */
    public function __construct()
    {
        
    }

    /**
     * get method callback
     * 
     */
    public function callback()
    {
        return $this->callback;
    }

    /**
     * CURL Request
     * 
     */
    public function request(): CurlSupport
    {
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => $this->customRequest,
            CURLOPT_POSTFIELDS => http_build_query($this->build),
            CURLOPT_HTTPHEADER => array(
                'Content-Length: ' . strlen(http_build_query($this->build))
            ),
        ));

        if (USAR_SSL) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
            curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
        }

        $this->callback = json_decode(curl_exec($ch));

        curl_close($ch);

        return $this;
    }
}

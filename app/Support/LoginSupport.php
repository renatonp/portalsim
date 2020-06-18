<?php

namespace App\Support;

class LoginSupport extends CurlSupport
{
    /**
     * Constructor of LoginSupport
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Capturar cadastro do cliente no E-CIDADE
     *
     * @param string $document
     * @return mixed
     */
    public function login($document)
    {
        $this->url = API_URL . API_LOGIN;
        $this->customRequest = "POST";

        $this->build = [
            'json' => json_encode([
                'sTokeValiadacao' => API_TOKEN,
                'sExec'           => API_CONSULTA_LOGIN,
                'z01_cgccpf'      => $document,
            ])
        ];

        return $this->request()->callback();
    }
}

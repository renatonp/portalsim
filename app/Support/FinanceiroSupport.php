<?php

namespace App\Support;

class FinanceiroSupport extends CurlSupport
{
    /**
     * Constructor of ImovelSupport
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Buscar ITBI’s quitados referente ao imóvel informado
     *
     * @param string $registration (matricula do imóvel)
     * @return mixed
     */
}

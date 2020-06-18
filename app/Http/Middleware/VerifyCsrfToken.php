<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'enviarmensagem',
        'validaautenticidade2',
        'faleconosco',
        'faleconosco/*',
        'logout',
        'pat_cadastro',
        'pat_documentos',
        'pat_validarCpf',
        'pat_informacoes',
        'validaconsultaauxilio',
        'cgm_validarCpf',
        'atualizaCGM',
        'cadastro_documentos',
    ];
}

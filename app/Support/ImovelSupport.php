<?php

namespace App\Support;

class ImovelSupport extends CurlSupport
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
    public function listItbiImmobile($registration)
    {
        $this->url = API_URL . API_ITBI;
        $this->customRequest = "POST";

        $this->build = [
            'json' => json_encode([
                'sTokeValiadacao'    => API_TOKEN,
                'sExec'              => API_LISTA_ITBI,
                's_limit'            => "0",
                'i_matricula_imovel' => $registration
            ])
        ];

        return $this->request()->callback();
    }

    /**
     * Lista de imoveis
     *
     * @param string $pagination
     * @param string $document
     * @return mixed
     */
    public function listProperties($pagination, $document, $sExec = null)
    {
        $this->url = 'http://vds3010x5.startdedicated.com:8090/api-ecidade-online-integracao-cerdidoes-paginacao/integracaoCerdidoes.RPC.php';
        $this->customRequest = "POST";

        $this->build = [
            'json' => json_encode([
                'sExec'           => empty($sExec) ? API_MATRICULA_CONSULTA : $sExec,
                'z01_cgccpf'      => $document,
                'sTokeValiadacao' => API_TOKEN,
                'i_paginacao'     => !empty($pagination) ? $pagination - 1 : 0,
            ])
        ];

        return $this->request()->callback();
    }

    /**
     * Lista informações do imóvel apartir da matricula
     *
     * @param string $registration
     * @param string $document
     * @return mixed
     */
    public function getPropertie($registration, $document)
    {
        $this->url = API_URL . API_IMOVEL;
        $this->customRequest = "POST";

        $this->build = [
            'json' => json_encode([
                'sExec'             => API_CONSULTA_IMOVEL,
                'i_cpfcnpj'         => $document,
                'sTokeValiadacao'   => API_TOKEN,
                'i_codigo_maticula' => $registration
            ])
        ];

        return $this->request()->callback();
    }

    /**
     * Confere se o imóvel foi baixado ou não
     *
     * @param string $registration
     * @param string $document
     * @return mixed
     */
    public function getImovelBaixado($registration, $document)
    {
        $this->url = API_URL . API_CERTIDAO;
        $this->customRequest = "POST";

        $this->build = [
            'json' => json_encode([
                'sExec'             => API_IMOVEL_CERTIDAO,
                'z01_cgccpf'         => $document,
                'sTokeValiadacao'   => API_TOKEN,
                'i_codigo_maticula' => $registration
            ])
        ];

        return $this->request()->callback();
    }
}

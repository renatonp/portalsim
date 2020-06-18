<?php
    // if (!defined('DESTINO_FALE_CONOSCO')) define('DESTINO_FALE_CONOSCO',    'contatosim@marica.rj.gov.br');

    if (!defined('MAX_PROC_LECOM'))           define('MAX_PROC_LECOM', 1);

    if (!defined('USAR_SSL'))           define('USAR_SSL',          false);
    if (!defined('SSL_LECOM'))          define('SSL_LECOM',         'ca_pmm_local.crt');
    if (!defined('SSL_API_VERIFICA'))   define('SSL_API_VERIFICA',  false);
    if (!defined('SSL_API'))            define('SSL_API',           'ca_pmm_local.crt');

    // if (!defined('DESTINO_FALE_CONOSCO'))       define('DESTINO_FALE_CONOSCO',      'giovanni.carelli@plano.inf.br');
    // if (!defined('DESTINO_FALE_CONOSCO_PAT'))   define('DESTINO_FALE_CONOSCO_PAT',  'giovanni@cadsconsultoria.com.br');

    if (!defined('DESTINO_FALE_CONOSCO')) define('DESTINO_FALE_CONOSCO',    'mizael.barbosa@gmail.com');
    if (!defined('DESTINO_FALE_CONOSCO_PAT')) define('DESTINO_FALE_CONOSCO_PAT',    'mizael.pardinho@gmail.com');

    // if (!defined('SISTEMACAMINHOBASE')) define('SISTEMACAMINHOBASE',    'https://lecomdev.pmm.local');
    if (!defined('SISTEMACAMINHOBASE')) define('SISTEMACAMINHOBASE',    'https://bpm.cadsconsultoria.com.br');
    if (!defined('CAMINHORELATIVO'))    define('CAMINHORELATIVO',       'sso/api/v1/authentication');

    // if (!defined('REQUISICAO'))         define('REQUISICAO',            'bpm/api/v1/process-definitions/38/versions/4/start');
    if (!defined('REQUISICAO'))         define('REQUISICAO',            '/bpm/api/v1/process-definitions/49/versions/1/start');
    if (!defined('INCIDENTE'))          define('INCIDENTE',             '/bpm/api/v1/process-definitions/34/versions/5/start');
    if (!defined('CAMINHO'))            define('CAMINHO',               '/bpm/api/v1/process-definitions/:processo/versions/:versao/start');

    if (!defined('LECOMFORMS'))         define('LECOMFORMS',            ':8080/form-app/process-instances/activity-forms');

    if (!defined('USUARIO'))            define('USUARIO',               'portal');
    if (!defined('SENHA'))              define('SENHA',                 'lecom');

    // Definições de variáveis para a Integração com a API e-Cidades
     if (!defined('API_URL')) define('API_URL', 'http://vds3010x5.startdedicated.com:8090/api-ecidade-online/');
    //if (!defined('API_URL')) define('API_URL', 'http://vds3010x5.startdedicated.com:8090/api-ecidade-online-integracao-certidao-inscricao/');

    if (!defined('API_TOKEN')) define('API_TOKEN', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJodHRwczpcL1wvYXBpLWVjaWRhZGUtb25saW5lLmxvY2FsIiwiYXVkIjoiaHR0cDpcL1wvcG9ydGFsLXNpbS5sb2NhbCIsImlhdCI6MTU4MDcyNTQ1OCwibmJmIjoxNTgwNzI1NDU4LCJ1aWQiOjEsInVuYW1lIjoicG9ydGFsX3NpbSIsInVybCI6Imh0dHBzOlwvXC9zaW0ubWFyaWNhLnJqLmdvdi5iclwvIn0.CqqJdAWMw9FZPsxbfCnOeeZkFeVAh4DndHNOITQ3Up0');

    // Login
    if (!defined('API_LOGIN'))              define('API_LOGIN',             'protocoloAtualizacaoLogin.RPC.php');
    if (!defined('API_CONSULTA_LOGIN'))     define('API_CONSULTA_LOGIN',    'consultaLogin');
    if (!defined('API_VERIFICA_CADASTRO'))  define('API_VERIFICA_CADASTRO', 'verificarCadastroUsuAtualizado');
    if (!defined('API_INSERIR_USUARIO'))    define('API_INSERIR_USUARIO',   'usuarioExternoInserirAtualizado');

    //CGM
    if (!defined('API_CGM'))                        define('API_CGM',                       'protocoloCadastroAutomaticoCgm.RPC.php');
    if (!defined('API_CONSULTA_CGM'))               define('API_CONSULTA_CGM',              'consultaCgm');
    if (!defined('API_CONSULTA_ENDERECO_CGM'))      define('API_CONSULTA_ENDERECO_CGM',     'buscaEnderecoCgm');
    if (!defined('API_CONSULTA_ESTADOS_CGM'))       define('API_CONSULTA_ESTADOS_CGM',      'buscaEstado');
    if (!defined('API_CONSULTA_MUNICIPIOS_CGM'))    define('API_CONSULTA_MUNICIPIOS_CGM',   'buscaMunicipio');
    if (!defined('API_CONSULTA_BAIRROS_CGM'))       define('API_CONSULTA_BAIRROS_CGM',      'buscaBairros');
    if (!defined('API_CONSULTA_RUAS_CGM'))          define('API_CONSULTA_RUAS_CGM',         'buscaRuas');
    if (!defined('API_ATUALIZA_ENDERECO_CGM'))      define('API_ATUALIZA_ENDERECO_CGM',     'salvaEnderecoCgm');
    if (!defined('API_USUARIO_EXTERNO_CGM'))        define('API_USUARIO_EXTERNO_CGM',       'usuarioExternoInserirAtualizado');
    if (!defined('API_ATUALIZA_CGM'))               define('API_ATUALIZA_CGM',              'atualizarCgm');
    if (!defined('API_SERVIDOR_CGM'))               define('API_SERVIDOR_CGM',              'consultaServidor');

    //CERTIDÃO
    if (!defined('API_CERTIDAO'))               define('API_CERTIDAO',              'integracaoCerdidoes.RPC.php');
    if (!defined('API_LISTA_IMOVEIS_CERTIDAO')) define('API_LISTA_IMOVEIS_CERTIDAO','integracaolistacertidoesimoveis');
    if (!defined('API_IMOVEL_CERTIDAO'))        define('API_IMOVEL_CERTIDAO',       'integracaocertidaoimovelmatricula');
    if (!defined('API_VALOR_VENAL_CERTIDAO'))   define('API_VALOR_VENAL_CERTIDAO',  'integracaocertidaovalorvenal');
    if (!defined('API_ITBI_CERTIDAO'))          define('API_ITBI_CERTIDAO',         'integracaocertidaoquitacaoitbi');
    if (!defined('API_NUMERO_PORTA_CERTIDAO'))  define('API_NUMERO_PORTA_CERTIDAO', 'integracaoverificacaocertidaoporta');
    if (!defined('API_CONTRIBUINTE_CERTIDAO'))  define('API_CONTRIBUINTE_CERTIDAO', 'integracaocertidaoimovelcontribuinte');
    if (!defined('API_AUTENTICIDADE_CERTIDAO')) define('API_AUTENTICIDADE_CERTIDAO','integracaoverificacaocertidaoimovel');

    // IMÓVEL
    if (!defined('API_IMOVEL'))                 define('API_IMOVEL',                'integracaoImobiliario.RPC.php');
    if (!defined('API_MOVEL'))                  define('API_MOVEL',                 'integracaoMobiliario.RPC.php');
    if (!defined('API_CONSULTA_IMOVEL'))        define('API_CONSULTA_IMOVEL',       'integracaoconsultainformacoesimoveis');
    if (!defined('API_BIC_IMOVEL'))             define('API_BIC_IMOVEL',            'integracaobicimovelresumida');
    if (!defined('API_MATRICULA_CONSULTA'))     define('API_MATRICULA_CONSULTA',    'integracaolistaimoveiscontribuinte');


    // TAXAS
    if (!defined('API_TAXAS'))                  define('API_TAXAS',                 'integracaoLancamentoDebitoTaxas.RPC.php');
    if (!defined('API_GRUPO_TAXAS'))            define('API_GRUPO_TAXAS',           'integracaoemitirdebitobuscagrupotaxa');
    if (!defined('API_LISTA_INSCRICAO_TAXAS'))  define('API_LISTA_INSCRICAO_TAXAS', 'integracaolistainscricoescontribuinte');
    if (!defined('API_VALOR_TAXAS'))            define('API_VALOR_TAXAS',           'integracaoemitirdebitobuscavaloresgrupotaxa');
    if (!defined('API_EMITIR_BOLETO_TAXAS'))    define('API_EMITIR_BOLETO_TAXAS',   'integracaoemitirdebitotaxas');

    // CONSULTAS
    if (!defined('API_CONSULTA'))               define('API_CONSULTA',              'protocoloAtualizacaoLogin.RPC.php');
    if (!defined('API_CGM_CONSULTA'))           define('API_CGM_CONSULTA',          'consultaLogin');


    // ITBI
    if (!defined('API_ITBI'))                   define('API_ITBI',                  'integracaoItbi.RPC.php');
    if (!defined('API_LISTA_ITBI'))             define('API_LISTA_ITBI',            'integracaolistaitbiquitacao');
    if (!defined('API_IMOVEL_ITBI'))            define('API_IMOVEL_ITBI',           'integracaoitbidadosimovel');
    if (!defined('API_DIVIDAS_ITBI'))           define('API_DIVIDAS_ITBI',          'integracaoverificardebitosdividaimovel');
    if (!defined('API_GUIA_ITBI'))              define('API_GUIA_ITBI',             'integracaoemissaoguiaitbi');
    if (!defined('API_TRANSACAO_ITBI'))         define('API_TRANSACAO_ITBI',        'integracaoconsultaritbitransacao');
    if (!defined('API_FPGTO_ITBI'))             define('API_FPGTO_ITBI',            'integracaoconsultarformaspagamento');
    if (!defined('API_LISTA_ADQUIRENTES_ITBI'))             define('API_LISTA_ADQUIRENTES_ITBI',            'integracaocgmtransmitenteadquirente');

    // AVERBAÇÃO
    if (!defined('API_AVERBACAO'))              define('API_AVERBACAO',             'integracaoAvebacao.RPC.php');
    if (!defined('API_TIPO_AVERBACAO'))         define('API_TIPO_AVERBACAO',        'integracaotipoaverbacao');
    if (!defined('API_ADQUIRENTE_AVERBACAO'))   define('API_ADQUIRENTE_AVERBACAO',  'integracaoinseriradquiriteaverbacao');

    if (!defined('API_URL_GFD'))   define('API_URL_GFD',  'http://vds3010x5.startdedicated.com:8090/api-ecidade-online-integracao-geral-financeira-debitos-01/');
    if (!defined('API_GFD'))   define('API_GFD',  '/integracaoGeralFinanceiraDebitos.RPC.php');


<?php

Route::get('/',                                     'Site\SiteController@index')->name('principal');
// Route::get('/home',                                'Site\SiteController@index')->name('principal');


Route::get('/cartaoGratuidadeEstacionamento',           'Site\CartaoGratuidadeEstacionamentoController@index')->name('cartaoGratuidadeEstacionamento');

// ************************************************

Route::get('/fomenta',                               'Site\SiteController@fomenta')->name('fomenta');
Route::get('/info',                                  'Site\SiteController@info')->name('info');
Route::post('/esqueceuSenha',                        'Site\SiteController@esqueceuSenha')->name('esqueceuSenha');
Route::post('/resetPassword',                        'Site\SiteController@resetPassword')->name('resetPassword');

// Route::get('/certidaoNegativaPositiva',              'Site\SiteController@certidaoNegativaPositiva')->name('certidaoNegativaPositiva');

Route::get('/register/consultaCEP/{id}',            'Auth\RegisterController@consultaCEP');
Route::get('/noticias',                             'Site\SiteController@noticias')->name('noticias');
Route::post('/enviarmensagem',                      'Site\SiteController@enviarmensagem')->name('enviarmensagem');
Route::post('/valida_cpf_login',                    'Site\SiteController@valida_cpf_login')->name('valida_cpf_login');
Route::get('/valida_cpf_cadastro/{id}',             'Site\SiteController@valida_cpf_cadastro')->name('valida_cpf_cadastro');
Route::get('/contato',                              'Site\SiteController@contato')->name('contato');
// Route::get('/faleconosco/assunto/{solicitacao}',    'Site\SiteController@pesquisa_solicitacao');
Route::get('/faleconosco',                          'Site\SiteController@faleconosco')->name('faleconosco');
Route::get('/servicos/{guia}/{aba?}',               'Site\SiteController@servicos')->name('servicos');
Route::get('/validaUsuario',                        'Site\SiteController@validaUsuario')->name('validaUsuario');
Route::get('/outrosservicos',                       'Site\SiteController@outrosservicos')->name('outrosservicos');
Route::get('/fileDownload/{id}',                    'Site\SiteController@fileDownload')->name('fileDownload');

Route::get('/certidaoAutenticacao',                 'Site\SiteController@certidaoAutenticacao')->name('certidaoAutenticacao');
Route::post('/validaautenticidade2',                'Site\SiteController@validaAutenticidade')->name('validaautenticidade2');
Route::get('/lecomAtualizaCgm/{chamado?}/{status?}',    'Site\SiteController@lecomAtualizaCgm')->name('lecomAtualizaCgm');

Route::get('/PAT/{guia?}/{aba?}',           'Site\SocialController@servicossociais')->name('PAT');
Route::get('/PAT_CADASTRO',                         'Site\SocialController@pat')->name('PAT_CADASTRO');
Route::get('/consultarsituacao',                    'Site\SocialController@consultarsituacao')->name('consultarsituacao');
Route::get('/solicitarauxilio',                     'Site\SocialController@solicitarauxilio')->name('solicitarauxilio');
Route::get('/pat_cadastro/{cpf}',                   'Site\SocialController@pat_cadastro')->name('pat_cadastro');
Route::get('/validaCpfDep/{cpf}',                   'Site\SocialController@validaCpfDep')->name('validaCpfDep');
Route::post('/pat_documentos',                      'Site\SocialController@pat_documentos')->name('pat_documentos');
Route::post('/pat_validarCpf',                      'Site\SocialController@pat_validarCpf')->name('pat_validarCpf');
Route::post('/pat_informacoes',                     'Site\SocialController@pat_informacoes')->name('pat_informacoes');
Route::post('/pat_recurso',                         'Site\SocialController@pat_recurso')->name('pat_recurso');
Route::post('/validaconsultaauxilio',               'Site\SocialController@pat3')->name('validaconsultaauxilio');
Route::post('/imprimirprotocolo',                   'Site\SocialController@imprimirprotocolo')->name('imprimirprotocolo');
Route::get('/pat_documentos_remove/{arquivo}',      'Site\SocialController@pat_documentos_remove')->name('pat_documentos_remove');
Route::get('/patConsultaCid10',                     'Site\SocialController@patConsultaCid10')->name('patConsultaCid10');

Route::get('/certidaoNegativaPositiva',             'Site\SocialController@certidaoNegativaPositiva')->name('certidaoNegativaPositiva');
Route::post('/certnegativa_validarCpf',             'Site\SocialController@certnegativa_validarCpf')->name('certnegativa_validarCpf');


Auth::routes(['verify' => true]);

Route::post('/login',                                 'Site\SiteController@login')->name('login');

Route::group([  'namespace' => 'Site',
                'middleware' => 'verified'
                ], function () {
    Route::get('/home',                     'HomeController@index')->name('home');

    // Route::get('/servicos/cidadao',                         ['uses' => 'HomeController@servicos'])->name('servicos');
    Route::get('/detectaEtapa/{chamado}',                   ['uses' => 'HomeController@detectaEtapa'])->name('detectaEtapa');
    Route::get('/formulario/{guia}/{assunto}/{servico}',    ['uses' => 'HomeController@formulario'])->name('formulario');
    Route::get('/formularioEdita/{chamado}',                ['uses' => 'HomeController@formularioEdita'])->name('formularioEdita');
    Route::get('/formularioEditaCGM',                       ['uses' => 'HomeController@formularioEditaCGM'])->name('formularioEditaCGM');
    Route::get('/servicos_documentos',                      ['uses' => 'HomeController@servicos_documentos'])->name('servicos_documentos');
    Route::get('/servicos_tributos',                        ['uses' => 'HomeController@servicos_tributos'])->name('servicos_tributos');

    Route::get('/alvara_consulta',          ['uses' => 'HomeController@alvara_consulta'])->name('alvara_consulta');
    Route::get('/alvara_certidao',          ['uses' => 'HomeController@alvara_certidao'])->name('alvara_certidao');
    Route::get('/certidao/{id}',            ['uses' => 'HomeController@certidao'])->name('certidao');
    Route::get('/iptu_abatimento',          ['uses' => 'HomeController@iptu_abatimento'])->name('iptu_abatimento');
    Route::get('/iptu_cadastramento',       ['uses' => 'HomeController@iptu_cadastramento'])->name('iptu_cadastramento');
    Route::get('/iss_guia',                 ['uses' => 'HomeController@iss_guia'])->name('iss_guia');
    Route::get('/iss_pagamento',            ['uses' => 'HomeController@iss_pagamento'])->name('iss_pagamento');
    Route::get('/acompanhamento',           ['uses' => 'HomeController@filtroConsulta'])->name('acompanhamento');
    Route::post('/acompanhamento',          ['uses' => 'HomeController@acompanhamento'])->name('acompanhamento');

    Route::get('/formularioBPM',            ['uses' => 'HomeController@formularioBPM'])->name('formularioBPM');

    Route::get('/cadAvisos',                ['uses' => 'HomeController@cadAvisos'])->name('cadAvisos');
    Route::get('/avisoEdit/{id}',           ['uses' => 'HomeController@avisoEdit'])->name('avisoEdit');
    Route::get('/avisoNovo',                ['uses' => 'HomeController@avisoNovo'])->name('avisoNovo');
    Route::post('/avisoSave',               ['uses' => 'HomeController@avisoSave'])->name('avisoSave');

    Route::get('/alterarSenha',             ['uses' => 'HomeController@alterarSenha'])->name('alterarSenha');
    Route::post('/alterarSenha',            ['uses' => 'HomeController@alterarSenhaSave'])->name('alterarSenha');
	Route::get('/itbionline',               ['uses' => 'HomeController@itbionline'])->name('itbionline');
    Route::get('/sigelu',                   ['uses' => 'SigeluController@abrirServico'])->name('sigelu');

});

// Route::group([  'namespace' => 'Cgm',
//                 'middleware' => 'verified'
//                 ], function () {

//     Route::get('/perfil',                       ['uses' => 'CgmController@perfil'])->name('perfil');
//     Route::post('/perfil',                      ['uses' => 'CgmController@perfilSave'])->name('perfil');

// });

Route::group([  'namespace' => 'Cadastro',
                ], function () {

    // *** Novo Cadastro do CGM
    Route::get('/atualizaCGM',                          ['uses' => 'CadastroController@atualizaCGM'])->name('atualizaCGM');
    Route::get('/atualizaCGMIPTU',                      ['uses' => 'CadastroController@atualizaCGMIPTU'])->name('atualizaCGMIPTU');
    Route::get('/cgm_validarCpf',                       ['uses' => 'CadastroController@cgm_direcionarForm'])->name('cgm_validarCpf');
    Route::get('/alteraIPTU',                           ['uses' => 'CadastroController@alteraIPTU'])->name('alteraIPTU');
    Route::post('/cgm_validarCpf',                      ['uses' => 'CadastroController@cgm_validarCpf'])->name('cgm_validarCpf');
    Route::post('/gravar_cadastro',                     ['uses' => 'CadastroController@gravar_cadastro'])->name('gravar_cadastro');
    Route::post('/cadastro_documentos',                 ['uses' => 'CadastroController@cadastro_documentos'])->name('cadastro_documentos');
    Route::get('/cadastro_documentos_remove/{arquivo}', ['uses' => 'CadastroController@cadastro_documentos_remove'])->name('cadastro_documentos_remove');

});

Route::group([  'namespace' => 'Cidadao',
    'middleware' => 'verified'
    ], function () {

    Route::get('/fracionamento',                    ['uses' => 'CadastroController@fracionamento'])->name('fracionamento');
    Route::get('/certidaoAmbiental',                ['uses' => 'CertidaoController@certidaoAmbiental'])->name('certidaoAmbiental');
    Route::get('/autorizacaoAmbiental',             ['uses' => 'CertidaoController@autorizacaoAmbiental'])->name('autorizacaoAmbiental');
    Route::get('/certidaoZoneamento',               ['uses' => 'CertidaoController@certidaoZoneamento'])->name('certidaoZoneamento');
    Route::get('/certidaoLancamento',               ['uses' => 'CertidaoController@certidaoLancamento'])->name('certidaoLancamento');
    Route::get('/certidaoDebitosTributos',          ['uses' => 'CertidaoController@certidaoDebitosTributos'])->name('certidaoDebitosTributos');
    Route::get('/certidaoValorVenal',               ['uses' => 'CertidaoController@certidaoValorVenal'])->name('certidaoValorVenal');

    Route::get('/certidaoNegativa',                 ['uses' => 'CertidaoController@certidaoNegativa'])->name('certidaoNegativa');
    Route::get('/certidaoNumeroPorta',              ['uses' => 'CertidaoController@certidaoNumeroPorta'])->name('certidaoNumeroPorta');
    Route::get('/certidaoITBI',                     ['uses' => 'CertidaoController@certidaoITBI'])->name('certidaoITBI');

    Route::get('/certidaoQuitacaoItbi/{matricula}',            ['uses' => 'CertidaoController@certidaoQuitacaoItbi'])->name('certidaoQuitacaoItbi');

    Route::get('/certidaoNegativaImprimir/{id}',    ['uses' => 'CertidaoController@certidaoNegativaImprimir'])->name('certidaoNegativaImprimir');
    Route::get('/certidaoValorVenalImprimir/{id}',  ['uses' => 'CertidaoController@certidaoValorVenalImprimir'])->name('certidaoValorVenalImprimir');
    Route::get('/certidaoITBIImprimir/{matr}/{guia}',  ['uses' => 'CertidaoController@certidaoITBIImprimir'])->name('certidaoITBIImprimir');
    Route::get('/certidaoNumeroPortaImprimir/{id}', ['uses' => 'CertidaoController@certidaoNumeroPortaImprimir'])->name('certidaoNumeroPortaImprimir');

    // Route::get('/certidaoAutenticacao',             ['uses' => 'CertidaoController@certidaoAutenticacao'])->name('certidaoAutenticacao');
    // Route::post('/validaautenticidade',             ['uses' => 'CertidaoController@validaAutenticidade'])->name('validaautenticidade');

    Route::get('/cadastroCGM',                      ['uses' => 'CgmController@cadastroCGM'])->name('cadastroCGM');
    Route::post('cgm_informacoes_adicionais',       ['uses' => 'CgmController@cgm_informacoes_adicionais'])->name('cgm_informacoes_adicionais');
    Route::post('cgm_informacoes_contato',          ['uses' => 'CgmController@cgm_informacoes_contato'])->name('cgm_informacoes_contato');
    Route::post('cgm_informacoes_pessoais',         ['uses' => 'CgmController@cgm_informacoes_pessoais'])->name('cgm_informacoes_pessoais');
    Route::post('cgm_endereco_correspondencia',     ['uses' => 'CgmController@cgm_endereco_correspondencia'])->name('cgm_endereco_correspondencia');
    Route::post('cgm_endereco',                     ['uses' => 'CgmController@cgm_endereco'])->name('cgm_endereco');
    Route::post('cgm_documentos',                   ['uses' => 'CgmController@cgm_documentos'])->name('cgm_documentos');
    Route::get('cgm_documentos_excluir/{id}',       ['uses' => 'CgmController@cgm_documentos_excluir'])->name('cgm_documentos_excluir');
    Route::get('cgm_valida_email/{token}',          ['uses' => 'CgmController@cgm_valida_email'])->name('cgm_valida_email');
    Route::get('consultaCEPcgm/{id}',               ['uses' => 'CgmController@consultaCEPcgm'])->name('consultaCEPcgm');
    Route::get('recuperaRuasCGM/{id}',              ['uses' => 'CgmController@recuperaRuasCGM'])->name('recuperaRuasCGM');
    Route::get('cancelaEnvioEmail',                 ['uses' => 'CgmController@cancelaEnvioEmail'])->name('cancelaEnvioEmail');
    Route::get('recuperaMunicipiosCGM/{estado}',    ['uses' => 'CgmController@recuperaMunicipiosCGM'])->name('recuperaMunicipiosCGM');
    Route::get('/licencaMaternidade',               ['uses' => 'ServidorController@solicitarLicencaMaternidade'])->name('licencaMaternidade');
    Route::get('/licencaPremio',                    ['uses' => 'ServidorController@solicitarLicencaPremio'])->name('licencaPremio');
    Route::get('/auxilioTransporte',                    ['uses' => 'ServidorController@solicitarAuxílioTransporte'])->name('auxilioTransporte');

    Route::get('/lotacaoServidor',                    ['uses' => 'ServidorController@alterarLotacaoServidor'])->name('lotacaoServidor');


    Route::get('/consultaInformacoes',              ['uses' => 'ImovelController@consultaInformacoes'])->name('consultaInformacoes');
    Route::get('/imovelInformacao/{id}',            ['uses' => 'ImovelController@imovelInformacao'])->name('imovelInformacao');
    Route::get('/imprimeInformacoes/{id}',          ['uses' => 'ImovelController@imprimeInformacoes'])->name('imprimeInformacoes');
    Route::get('/averbacaoImovel/{processo?}',                  ['uses' => 'ImovelController@averbacaoImovel'])->name('averbacaoImovel');
    Route::get('/listaImoveis/{cpf}/{matr?}',       ['uses' => 'ImovelController@listaImoveisAverbacao'])->name('listaImoveis');
    Route::get('/listaItbiImovel/{matr}',           ['uses' => 'ImovelController@listaItbiImovel'])->name('listaItbiImovel');
    Route::get('/listaAdquirentes/{matr}/{guia}',   ['uses' => 'ImovelController@listaAdquirentes'])->name('listaAdquirentes');
    Route::post('/averbacao_gravar',                ['uses' => 'ImovelController@averbacao_gravar'])->name('averbacao_gravar');
    Route::post('averbacao_documentos',             ['uses' => 'ImovelController@averbacao_documentos'])->name('averbacao_documentos');
    Route::get('averbacao_documentos_excluir/{id}', ['uses' => 'ImovelController@averbacao_documentos_excluir'])->name('averbacao_documentos_excluir');

    Route::get('recupera_cgm/{cpf}', ['uses' => 'ImovelController@recuperaCGM'])->name('recupera_cgm');
    Route::get('recupera_endereco_cgm/{cpf}', ['uses' => 'ImovelController@recuperaEnderecoCGM'])->name('recupera_endereco_cgm');
    Route::get('recupera_cgm_endereco/{cpf}', ['uses' => 'ImovelController@recuperaCgmEndereco'])->name('recupera_cgm_endereco');
    Route::get('lancamentoITBI', ['uses' => 'ImovelController@lancamentoITBI'])->name('lancamentoITBI');
    Route::get('recupera_adquirentes_imovel/{guia}', ['uses' => 'ImovelController@recupera_adquirentes_imovel'])->name('recupera_adquirentes_imovel');
    Route::get('verifica_status_lecom/{matricula}', ['uses' => 'ImovelController@verifica_status_lecom'])->name('verifica_status_lecom');
    Route::post('pendencias_gravar', ['uses' => 'ImovelController@pendencias_gravar'])->name('pendencias_gravar');
    Route::get('verifica_debitos/{matricula}', ['uses' => 'ImovelController@verifica_debitos'])->name('verifica_debitos');





    Route::get('/boletosTaxas',                                 ['uses' => 'TaxasController@boletosTaxas'])->name('boletosTaxas');
    Route::get('/taxasconsultacgm/{cpf}',                       ['uses' => 'TaxasController@taxasconsultacgm'])->name('taxasconsultacgm');
    Route::get('/taxasconsultainscricao/{cpf}',                 ['uses' => 'TaxasController@taxasconsultainscricao'])->name('taxasconsultainscricao');
    Route::get('/taxasconsultamatricula/{cpf}/{matr?}',         ['uses' => 'TaxasController@taxasconsultamatricula'])->name('taxasconsultamatricula');
    Route::get('/taxasconsultavalor/{tipo}/{valor}/{grupo}',    ['uses' => 'TaxasController@taxasconsultavalor'])->name('taxasconsultavalor');
    Route::post('/emitirboletotaxa',                            ['uses' => 'TaxasController@emitirboletotaxa'])->name('emitirboletotaxa');

    Route::get('/lancamentoITBI',                               ['uses' => 'ItbiController@lancamentoITBI'])->name('lancamentoITBI');
    Route::get('/editarAverbacao/{id}',                         ['uses' => 'ImovelController@editarAverbacao'])->name('editarAverbacao');
    Route::get('/editarItbi/{id}',                              ['uses' => 'ItbiController@editarItbi'])->name('editarItbi');
    Route::get('/baixarguiaitbi/{id}',                          ['uses' => 'ItbiController@baixarguiaitbi'])->name('baixarguiaitbi');
    Route::get('/itbitransacao/{id}',                           ['uses' => 'ItbiController@itbitransacao'])->name('itbitransacao');
    Route::get('/itbiconsultaCGM/{cpf}',                        ['uses' => 'ItbiController@itbiconsultaCGM'])->name('itbiconsultaCGM');
    Route::get('itbi_documentos_remove/{arquivo}',              ['uses' => 'ItbiController@itbi_documentos_remove'])->name('itbi_documentos_remove');
    Route::post('itbi_documentos_transacao',                    ['uses' => 'ItbiController@itbi_documentos_transacao'])->name('itbi_documentos_transacao');
    Route::post('itbi_documentos_transmitente',                 ['uses' => 'ItbiController@itbi_documentos_transmitente'])->name('itbi_documentos_transmitente');
    Route::post('itbi_documentos_adquirente',                   ['uses' => 'ItbiController@itbi_documentos_adquirente'])->name('itbi_documentos_adquirente');
    Route::post('itbi_documentos_imovel',                       ['uses' => 'ItbiController@itbi_documentos_imovel'])->name('itbi_documentos_imovel');
    Route::post('itbi_lancar',                                  ['uses' => 'ItbiController@itbi_lancar'])->name('itbi_lancar');
});


Route::get('/cartaoGratuidadeEstacionamento',           'Site\CartaoGratuidadeEstacionamentoController@index')->name('cartaoGratuidadeEstacionamento');
Route::post('/imageUploadPost',                         'Site\CartaoGratuidadeEstacionamentoController@imageUploadPost')->name('imageUploadPost');
Route::post('/salvarCartaoGratuidadeEstacionamento',    'Site\CartaoGratuidadeEstacionamentoController@salvarCartaoGratuidadeEstacionamento')->name('salvarCartaoGratuidadeEstacionamento');
Route::post('/removerCartaoGratuidadeDocumento/',       'Site\CartaoGratuidadeEstacionamentoController@removerCartaoGratuidadeDocumento')->name('removerCartaoGratuidadeDocumento');

Route::get('/atualizaCGM',                  ['uses' => 'SiteController@index'])->name('atualizaCGM');
Route::get('/alteraIPTU',                   ['uses' => 'SiteController@index'])->name('alteraIPTU');
Route::get('/certidaoNegativaPositiva',     ['uses' => 'SiteController@index'])->name('certidaoNegativaPositiva');

Route::group([  'namespace' => 'Financeiro'], function (){
    Route::get('/selecaoDebito',['uses' => 'FinanceiroController@selecaoDebito'])->name('selecaoDebito');
    Route::get('/debitosAbertos',['uses' => 'FinanceiroController@debitosAbertos'])->name('debitosAbertos');
    Route::post('/relatorioDebitosAbertos',['uses' => 'FinanceiroController@relatorioDebitosAbertos'])->name('relatorioDebitosAbertos');
    Route::get('/pagamentosEfetuados',['uses' => 'FinanceiroController@pagamentosEfetuados'])->name('pagamentosEfetuados');
    Route::get('/extratoFinanceiro',['uses' => 'FinanceiroController@extratoFinanceiro'])->name('extratoFinanceiro');
    Route::post('/filtroExtratoFinanceiro',['uses' => 'FinanceiroController@filtroExtratoFinanceiro'])->name('filtroExtratoFinanceiro');

    Route::post('/integracaoPesquisaTipoDebitos',['uses' => 'FinanceiroController@integracaoPesquisaTipoDebitos'])->name('integracaoPesquisaTipoDebitos');
    Route::post('/integracaoPesquisaDebitos',['uses' => 'FinanceiroController@integracaoPesquisaDebitos'])->name('integracaoPesquisaDebitos');
    Route::post('/integracaoReciboDebitos',['uses' => 'FinanceiroController@integracaoReciboDebitos'])->name('integracaoReciboDebitos');
    Route::post('/integracaoRelatorioTotalDebitos',['uses' => 'FinanceiroController@integracaoRelatorioTotalDebitos'])->name('integracaoRelatorioTotalDebitos');

    Route::post('/integracaoPagamentosEfetuados',['uses' => 'FinanceiroController@integracaoPagamentosEfetuados'])->name('integracaoPagamentosEfetuados');
    Route::post('/integracaoRelatorioPagamentosEfetuados',['uses' => 'FinanceiroController@integracaoRelatorioPagamentosEfetuados'])->name('integracaoRelatorioPagamentosEfetuados');
    Route::get('/pesquisarMatricula',['uses' => 'FinanceiroController@pesquisarMatricula'])->name('pesquisarMatricula');
    Route::get('/pesquisarInscricao',['uses' => 'FinanceiroController@pesquisarInscricao'])->name('pesquisarInscricao');
});

<?php

namespace App\Services;
use DB;
 
class ServicosService
{
     
    public function guias()
    {
        // $registros = DB::connection('lecom')
        //     ->table('v_catalogo_sim')
        //     ->select(DB::raw('count(*) as guia_count, guia'))
        //     ->where('visivel', '=', 'sim' )
        //     ->orderBy('guia', 'asc')
        //     ->groupBy('guia')
        //     ->get();

        $registros = DB::connection('mysql')
            ->table('menu_guias')
            ->where('ativo', '=', 1 )
            ->orderBy('texto', 'asc')
            ->get();

        return $registros->all();
    }

    public function fases()
    {
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->select(DB::raw('count(*) as fase_count, fase'))
            ->orderBy('fase', 'asc')
            ->groupBy('fase')
            ->get();
        
        return $registros->all();
    }
     
    public function desc_guia($guia)
    {
        $registros = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=', $guia )
            ->limit(1)
            ->get();

        return $registros->all();
    }

    public function servicos($assunto)
    {
        $registros = DB::connection('mysql')
            ->table('menu')
            ->where('assunto', '=', $assunto )
            ->where('ativo', '=', 1 )
            ->orderBy('servico', 'asc')
            ->get();

        return $registros->all();
    }


    public function servicos_fc()
    {
        $registros = DB::connection('mysql')
            ->table('menu')
            ->where('ativo', '=', 1 )
            ->orderBy('servico', 'asc')
            ->get();

        return $registros->all();
    }
    
    public function servicos_qtd()
    {
        $registros = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->orderBy('qtd', 'desc')
            ->limit(8)
            ->get();

        return $registros->all();
    }
 
    public function solicitacoes()
    {
        $registros = DB::connection('lecom')
            ->table('v_fale_conosco')
            ->select(DB::raw('count(*) as solicitacao_count, solicitacao'))
            ->orderBy('solicitacao', 'asc')
            ->groupBy('solicitacao')
            ->get();

        return $registros->all();
    }
    
    public function assuntos()
    {
        $registros = DB::connection('lecom')
            ->table('v_fale_conosco')
            ->orderBy('assunto', 'asc')
            // ->pluck('assunto');
            ->get();

        return $registros->all();
    }
}
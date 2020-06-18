@extends('layouts.tema01')
@section('content')
    <div class="container">
      <div class="row">
        <div class="span12">
            <img src="img/fomenta/BANNER_TOPO.png" style="" alt=""/>
            <p></p>
        </div>
        <div class="span6">
           <img src="img/fomenta/TIT_OQUEE.png" alt=""/>
            <p style="text-align:justify">É uma ação da Prefeitura de Maricá que disponibilizará linhas de crédito emergenciais para os
                micros e pequenos empresários. Devido à pandemia, ação assumiu caráter emergencial, e irá
                ofertar duas linhas de crédito: de R$ 300,00 à R$ 21.000,00 (vinte e um mil reais) e outra de
                R$21.001,00 à R$40.000 (quarenta mil) em condições diferenciadas.</p>
        </div>

        <div class="span6">
            <img src="img/fomenta/TIT_TAXA.png" alt=""/>
            <p style="text-align:justify">Serão duas linhas de crédito específicas com o microcrédito sendo ofertado a juros zero. Para a
                linha de crédito empresarial os juros serão de 3% a.a. e tarifas subsidiadas. As duas linhas
                emergenciais terão um prazo de carência de 12 meses para início do pagamento das
                prestações.</p>
        </div>
    </div>
    <div class="row">
        <div class="span12">
            <img src="img/fomenta/produtos.png" alt=""/>
             <p></p>
         </div>
        <div class="span6">
            <img src="img/fomenta/TIT_QUEMPODE.png" alt=""/>
             <p style="text-align:justify">A ação é destinada às pessoas jurídicas tendo como prioridade Micro e Pequenas empresas
                registradas no Simples Nacional.</p>
         </div>
         <div class="span6">
             <img src="img/fomenta/TIT_COMO_INSCREVER.png" alt=""/>
             <p style="text-align:justify">Munido das informações através do nosso site, o empresário deverá clicar no link indicado (no
                final da página), onde será redirecionado para o site da AgeRio, e será preenchido um cadastro
                inicial para primeira análise da viabilidade da oferta do crédito. Em seguida, o empresário
                receberá um e-mail com novas orientações e juntada de documentos.</p>
         </div>
    </div>
    <div class="row">
         <div class="span12">
             <img src="img/fomenta/TIT_DOCUMENTOS.png" alt=""/>
             <span>
                {{-- <img src="img/fomenta/documentos.png" alt=""/><br> --}}
                <img src="img/fomenta/doc_01.png" alt=""/><br>
                <a href="{{ route('certidaoNegativaPositiva') }}">
                    <img src="img/fomenta/doc_02.png" alt=""/><br>
                </a>
                <img src="img/fomenta/doc_03.png" alt=""/><br>
             </span>
         </div>
    </div>
    <div class="row">
         <div class="span6">
            <img src="img/fomenta/TIT_ANALISE.png" alt=""/>
             <p style="text-align:justify">As análises de crédito ficarão a cargo da Agência de Fomento do Estado do Rio de Janeiro
                (AgeRio), instituição financeira governamental que conta com 16 anos de experiência e um 
                corpo funcional altamente qualificado para realização das ações, obedecendo para tanto a
                ordem de chegada, a partir da data do envio de todas as documentações estabelecidas.</p>
         </div>

         <div class="span6">
             <img src="img/fomenta/TIT_QUANTO.png" alt=""/>
             <p style="text-align:justify">Será feito uma análise do valor solicitado pelo valor liberado pela instituição financeira a partir
                da análise de crédito e das documentações realizadas pela Agerio, variando conforme a análise
                realizada. Pode-se obter o valor total ou parcial da linha de crédito escolhida. O valor será
                pago em Real.</p>
         </div>
    </div>
    <div class="row">
         <div class="span6">
            <img src="img/fomenta/TIT_APARTIR.png" alt=""/>
             <p style="text-align:justify">As inscrições serão abertas a partir de 07 de maio. Os valores serão disponibilizados de acordo
                com o correto envio das documentações e das análises realizadas pela instituição financeira,
                respeitando a ordem de envio das propostas.</p>
         </div>
         <div class="span6">
             <img src="img/fomenta/TIT_QUNTIDADE.png" alt=""/>
             <p style="text-align:justify">Serão atendidos quantas micro empresas forem possíveis, até atingir o valor total
                disponibilizado. Há autorização legal de oferta de até R$ 30 milhões.</p>
         </div>
    </div>
    <div class="row">
         <div class="span6">
            <img src="img/fomenta/TIT_RESPOSTA.png" alt=""/>
             <p style="text-align:justify">Os prazos serão variáveis respeitando todas as determinações legais de análise de crédito a fim
                de garantir a lisura do processo e das garantias estabelecidas da responsabilidade da análise,
                terão um limite de até 120 dias, a contar da entrega dos documentos.</p>
         </div>
         <div class="span6">
             <a href="{{ asset('/docs/Simulador_Marica.xls') }}" download="Simulador Maricá">
                <img src="img/fomenta/simulador.png" alt=""/>
            </a>
             <p></p>
         </div>
    </div>
    <div class="row">
        <div class="span2">
        </div>
        <div class="span8">
            <img src="img/fomenta/contato.png" alt=""/>
            <br>
            <a href="mailto:sacfomentamarica@marica.rj.gov.br" target="_blank">
                <img src="img/fomenta/sac.png" alt=""/>
            </a>
        </div>
        <div class="span2">
        </div>
    </div>
    <br>
    <div class="row">
         <div class="span2">
        </div>
        <div class="span8">
            <a href="https://www.agerio.com.br/credito-emergencial-marica/" target="_blank">
                <img src="img/fomenta/solicitar.png" alt=""/>
            </a>
        </div>
        <div class="span2">
        </div>
      </div>
    </div>
</div>
<br>
<br>
<br>
@endsection

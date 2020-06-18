@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>{{ __('CONTATO') }}</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Contato') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row ">
            <div class="span12">

                <h3><b>Serviços Integrados Municipal (SIM)</b></h3>
                <h3>Unidade Centro</h3>
                <p>Rua Álvares de Castro, 272 - Centro - Maricá - RJ</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3674.8253903996324!2d-42.82245458540009!3d-22.91981034409718!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x99ed9ca6dd76a9%3A0xcda09d92cae94079!2sR.%20%C3%81lvares%20de%20Castro%2C%20272%20-%20Eldorado%2C%20Maric%C3%A1%20-%20RJ%2C%2024900-000!5e0!3m2!1spt-BR!2sbr!4v1579658824501!5m2!1spt-BR!2sbr" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                <br>
                <br>
                <br>
                <h3>Unidade Itaipuaçu</h3>
                <p>Terminal Rodoviário José Ferreira<br>
                Rua Professor Cardoso de Menezes (antiga rua1)<br>
                Jardim Atlântico - Itaipuaçu</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3673.6729290909743!2d-42.964294885081976!3d-22.96226958498368!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9989359e97fd7f%3A0x589f4f99e3818d4e!2sTerminal+de+integr+a%C3%A7%C3%A3o+Rodovi%C3%A1rio+Jos%C3%A9+Ferreira+da+Silva!5e0!3m2!1spt-BR!2sbr!4v1550612642633" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                <br>
                <br>
                <br>
                <h3>Unidade Inoã</h3>
                <p>Avenida Gilberto Carvalho, 1120 - Inoã (loteamento Vivendas de Itaipuaçu)<br>
                (Referência Galpão da Secretaria de Conservação)</p>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3675.235585261024!2d-42.94532418508298!3d-22.904679885012907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x998e0a7bab19bf%3A0x582d2f1356ca4b2b!2sAv.+Gilberto+Carvalho%2C+Maric%C3%A1+-+RJ%2C+24900-000!5e0!3m2!1spt-BR!2sbr!4v1550612829078" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>






            </div>
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
@endsection

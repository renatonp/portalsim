<section id="featured">
    <!-- start slider -->
    <!-- Slider -->
    <a href="{{ route('PAT', 1 ) }}">
    <div id="nivo-slider">
        <div class="nivo-slider">
            <!-- Slide #1 image -->
            {{-- <img src="img/slides/nivo/bg-1.jpg" alt="" title="#caption-1" /> --}}
            <!-- Slide #2 image -->
            {{-- <img src="img/slides/nivo/bg-2.jpg" alt="" title="#caption-2" /> --}}
            <!-- Slide #3 image -->
            {{-- <img src="img/slides/nivo/bg-3.jpg" alt="" title="#caption-3" /> --}}
            <!-- Slide #4 image -->
            {{-- <img src="img/slides/nivo/bg-4.jpg" alt="" title="#caption-4" /> --}}
            <!-- Slide #5 image -->
            {{-- <img src="img/slides/nivo/bg-5.jpg" alt="" title="#caption-5" /> --}}
            <!-- Slide #5 image -->
            <img src="img/slides/nivo/PAT_SITE1.png" alt="" title="#caption-6" />
        </div>
        <div class="container">
            <div class="row">
                <div class="span12">
                    <!-- Slide #1 caption -->
                    <div class="nivo-caption" id="caption-1">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                            <p>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                            </p>
                            {{-- <a href="#" class="btn btn-theme">Saiba Mais</a> --}}
                        </div>
                    </div>
                    <!-- Slide #2 caption -->
                    <div class="nivo-caption" id="caption-2">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                            <p>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                            </p>
                            {{-- <a href="#" class="btn btn-theme">Saiba Mais</a> --}}
                        </div>
                    </div>
                    <!-- Slide #3 caption -->
                    <div class="nivo-caption" id="caption-3">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                            <p>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                            </p>
                            {{-- <a href="#" class="btn btn-theme">Saiba Mais</a> --}}
                        </div>
                    </div>
                    <!-- Slide #4 caption -->
                    <div class="nivo-caption" id="caption-4">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                            <p>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                            </p>
                            {{-- <a href="#" class="btn btn-theme">Saiba Mais</a> --}}
                        </div>
                    </div>
                    <!-- Slide #5 caption -->
                    <div class="nivo-caption" id="caption-5">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                            <p>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                            </p>
                            {{-- <a href="#" class="btn btn-theme">Saiba Mais</a> --}}
                        </div>
                    </div>
                    <!-- Slide #6 caption -->
                    <div class="nivo-caption" id="caption-6">
                        <div>
                            <h2><strong>SIM</strong><br>Serviços Integrados Municipal</h2>
                                Para modernizar a administração municipal, especialmente a tributária e o atendimento à população, a Prefeitura de Maricá criou o SIM – Serviços Integrados Municipal.<br>
                                Em um só lugar são oferecidos serviços importantes ao contribuinte, como Ouvidoria, Procon, Plantão Fiscal, Atendimento Empresarial, Junta Comercial do Estado do Rio (Jucerja), Casa do Empreendedor, entre outros, levando conforto e agilidade ao alcance de todos.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </a>
    <!-- end slider -->
</section>








{{-- <div class="slider_container">
    <div class="flexslider">
        @if(!empty($noticias))
            <ul class="slides">
                @foreach ($noticias as $noticia)
                    <li>
                        <a href="{{ $noticia['url'] }}" target="_BLANK"><img
    src="{{ asset('img/slide/'.$noticia['image'] ) }}" alt="" title="" /></a>
<div class="flex-caption">
    <div class="caption_title_line">
        <h2>{{ $noticia['title'] }}</h2>
        <p>{{ $noticia['text'] }}</p>
    </div>
</div>
<div class="flex-navigation1">
    <button type="button" class="btn bnt-slide">
        {{ __('Lorem') }}
    </button>
</div>
<div class="flex-navigation2">
    <button type="button" class="btn bnt-slide">
        {{ __('Ipsum') }}
    </button>
</div>
</li>
@endforeach
</ul>
@endif
</div>
</div> --}}

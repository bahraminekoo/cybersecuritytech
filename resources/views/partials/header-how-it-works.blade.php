
 <!--   <div class="video-header wrap">

        <div class="fullscreen-video-wrap">
            <video src="<?php //echo get_field('header_video', 'options'); ?>" muted="muted" autoplay="autoplay" loop="loop" type="video/mp4"></video>
        </div>
        <div class="header-overlay">
            <div class="header-content">
                <nav class="navbar navbar-expand-lg navbar-light justify-content-around my-2 my-md-0 mr-md-3">
                    <a class="navbar-brand brand" href="{{ home_url('/') }}">
                        @php
                            //echo get_field("logo", "options")
                        @endphp
                    </a>
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon">Menu</span>
                    </button>
                    <div class="collapse navbar-collapse navbar-md-collapse" id="collapsibleNavbar">
                        {{--@if (has_nav_menu('primary_navigation'))
                            {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-nav-custom justify-content-around', 'container' => false]) !!}
                        @endif--}}
                    </div>
                </nav>
                <h1>GOOD MORNING</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Impedit hic eaque rerum cupiditate officiis
                    recusandae iusto quaerat architecto odio illum.</p>
                <a class="btn btn-success my-btn mt-4">KNOW MORE &gt;</a>
            </div>
        </div>
    </div>-->

   <div class="video-header-container">
    <div class="video">
        <video autoload="autoload" autoplay="autoplay" loop="loop" muted="muted">
            <source src="<?php echo get_field('header_video', 'options'); ?>" type="video/mp4">
        </video>
    </div>
    <div class="header-text">
        <header class="banner container">
            <nav class="navbar navbar-expand-lg navbar-light justify-content-around my-2 my-md-0 mr-md-3">
                <a class="navbar-brand brand" href="{{ home_url('/') }}">
                    @php
                        echo get_field("logo", "options")
                    @endphp
                </a>
                <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon">Menu</span>
                </button>
                <div class="collapse navbar-collapse navbar-md-collapse" id="collapsibleNavbar">
                    @if (has_nav_menu('primary_navigation'))
                        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'navbar-nav justify-content-around', 'container' => false]) !!}
                    @endif
                </div>
            </nav>
        </header>
        <?php $cta = get_field('header_cta', 'options'); ?>
        <section class="section section-header-cta section-cta">
            <div class="content">
                <div class="copy">
                    <div class="header-cta-title" style="color: <?php echo $cta['text_color']; ?>">
                        <?php echo $cta['title']; ?>
                    </div>
                    <div class="header-cta-desc" style="color: <?php echo $cta['text_color']; ?>">
                        <?php echo $cta['description']; ?>
                    </div>
                </div>
                @php
                    $color1 = $cta["btn_color_1"];
                    $color2 = $cta["btn_color_2"];

                    $btn = $cta["btn_link"];
                    $btn_title = $btn["title"];
                    $btn_url = $btn["url"];
                    $btn_target = $btn["target"];

                @endphp
                <a
                        href="{{ $btn_url }}"
                        target="{{ $btn_target }}"
                        class="c-btn c-btn--rounded text-uppercase u-gradient-color font-weight-bold"
                        style="--cta-btn-color1:{{$color1}}; --cta-btn-color2:{{$color2}}">
                    {{ $btn_title }}
                </a>
            </div>
        </section>

    </div>
    </div>

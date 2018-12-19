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

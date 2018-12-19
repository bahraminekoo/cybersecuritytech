<section class="section section--full section-cta" style="{{ App\print_style_background_color() }}">
    <div class="content">
        <div class="copy">
          <div style="{{ App\print_style_color('text_color')}}">
            <?php App\print_title_sub_field(); ?>
          </div>
        </div>
        @php
          $color1 = get_sub_field("btn_color_1");
          $color2 = get_sub_field("btn_color_2");

          $btn = get_sub_field("btn_link");
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

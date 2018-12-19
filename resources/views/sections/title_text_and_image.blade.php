<section class="section section--full section-title-text-and-image" style="{{ App\print_style_background_color() }}">
    <div class="content">
        <div class="copy">
            <?php App\print_title_sub_field(); ?>
            <?php App\print_text_sub_field(); ?>
        </div>
        <div class="o-image">
          <?php App\print_picture_responsive(); ?>
        </div>
    </div>
</section>

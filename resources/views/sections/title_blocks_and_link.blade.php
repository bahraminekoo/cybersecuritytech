<section class="section section-title-blocks-and-link" style="{{ App\print_style_background_color() }}">
    <div class="content">
        <div class="copy">
            <?php App\print_title_sub_field(); ?>
        </div>
    </div>
    <div class="row blocks">
        @php
            if(have_rows('blocks')) {
                $count = 0;
                while(have_rows('blocks')) {
                     the_row();
                     $count++;
                     $title = get_sub_field('title');
                     $content = get_sub_field('content');
                     @endphp
                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6" >
                            <div id="border-<?php echo $count; ?>"></div>
                            <div class="title">
                                {{ $title }}
                            </div>
                            <div class="content">
                                {{ $content }}
                            </div>
                        </div>
                     @php
                }
            }
        @endphp
    </div>
    <div class="row link aligncenter">
        <?php $link = get_sub_field('link'); ?>
        <a href="<?php echo $link['url']; ?>"><?php echo $link['title']; ?></a>
    </div>
</section>

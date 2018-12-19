<section class="section section--full section-abilities-slider" style="{{ App\print_style_background_color() }}">
    <div class="container">
        <div class="row">
            <div id="abilities-carousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#abilities-carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#abilities-carousel" data-slide-to="1"></li>
                    <li data-target="#abilities-carousel" data-slide-to="2"></li>
                    <li data-target="#abilities-carousel" data-slide-to="3"></li>
                    <li data-target="#abilities-carousel" data-slide-to="4"></li>
                    <li data-target="#abilities-carousel" data-slide-to="5"></li>
                </ol>
                <div class="carousel-inner">

                    @php if( have_rows('slider')): @endphp
                    @php while( have_rows('slider')): @endphp
                    @php the_row(); @endphp
                    @php if(get_row_layout() == 'abilities'): @endphp
                    @php if(have_rows('blocks')): @endphp
                    @php $blocks = [];$count = 0; @endphp
                    @php while(have_rows('blocks')): @endphp
                    @php
                        the_row();
                        $count++;
                    @endphp
                    @php
                        $blocks[$count]['title'] = get_sub_field('title');
                        $blocks[$count]['image'] = get_sub_field('image');
                        $blocks[$count]['content'] = get_sub_field('content');
                    @endphp
                    @php endwhile; @endphp
                    @php endif; @endphp
                    @php endif; @endphp
                    @php if(get_row_layout() == 'abilities_footer'): @endphp
                    @php $footer_content = get_sub_field('content');  @endphp
                    @php $bold_content = get_sub_field('bold_content'); @endphp
                    @php endif; @endphp
                    @php endwhile; @endphp
                    @php endif; @endphp
                    @php
                        foreach($blocks as $index => $item) {
                            $active = 'noactive';
                            if($index == 1) {
                                $active = 'active';
                            }
                    @endphp
                    <div class="carousel-item @php echo $active; @endphp ability-item">
                        <img class="img-fluid" src="@php echo $item['image']['url']; @endphp" alt="1 slide" width="135"
                             height="135">
                        <div class="ability-title">@php echo $item['title']; @endphp</div>
                        <div class="ability-content">@php echo $item['content']; @endphp</div>
                    </div>
                    @php
                        }
                    @endphp
                </div>
                <a class="left carousel-control" href="#abilities-carousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#abilities-carousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </div>
        </div>
    </div>
</section>

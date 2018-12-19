<section class="section section--full section-testimonials" style="{{ App\print_style_background_color() }}">
	<div class="content">
		@php $testimonials = get_field('testimonials'); @endphp

		@if( have_rows('testimonials') )
		<div id="carousel" class="cs_flexslider">
			<ul class="client-slides">
				@php while ( have_rows('testimonials') ) : the_row(); @endphp
				<li class="slide">
					<img class="image img-fluid float-left" src="{{ the_sub_field('image') }}" alt="{{ the_sub_field('name_title__company_country') }}" />
					<div class="text">
						<span class="msg">{!! the_sub_field('full_message') !!}</span>
						<span class="name">{{ the_sub_field('name_title__company_country') }}</span>
					</div>
				</li>
				@php endwhile; @endphp
			</ul>
		</div>
		@endif

	</div>
</section>

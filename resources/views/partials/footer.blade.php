<footer class="container-fluid content-info">
	<div class="container">
		{{ dynamic_sidebar('sidebar-footer') }}

		<div class="row main-sec justify-content-between">
			@if(is_active_sidebar('first-footer-widget-area'))
			{!! dynamic_sidebar('first-footer-widget-area') !!}
			@endif

			@if(is_active_sidebar('second-footer-widget-area'))
			{!! dynamic_sidebar('second-footer-widget-area') !!}
			@endif

			@if(is_active_sidebar('third-footer-widget-area'))
			{!! dynamic_sidebar('third-footer-widget-area') !!}
			@endif

			@if(is_active_sidebar('fourth-footer-widget-area'))
			{!! dynamic_sidebar('fourth-footer-widget-area') !!}
			@endif

			@if(is_active_sidebar('fifth-footer-widget-area'))
			{!! dynamic_sidebar('fifth-footer-widget-area') !!}
			@endif

			@if(is_active_sidebar('sixth-footer-widget-area'))
			<div id="sixth-footer-widget-area" class="col-auto socials">
				{!! dynamic_sidebar('sixth-footer-widget-area') !!}

				<ul class="socials-link list">
					<li><a href="{{ get_field("linkedin_link", "options") }}"><img class="alignnone size-full wp-image-34" src="{{ get_field("linkedin_icon", "options") }}" alt="" width="250" height="252" /></a></li>
					<li><a href="{{ get_field("facebook_link", "options") }}"><img class="alignnone size-full wp-image-33" src="{{ get_field("facebook_icon", "options") }}" alt="" width="248" height="248" /></a></li>
					<li><a href="{{ get_field("twitter_link", "options") }}"><img class="alignnone size-full wp-image-30" src="{{ get_field("twitter_icon", "options") }}" alt="" width="246" height="250" /></a></li>
					<li><a href="{{ get_field("email_link", "options") }}"><img class="alignnone size-full wp-image-31" src="{{ get_field("email_icon", "options") }}" alt="" width="244" height="250" /></a></li>
					<li><a href="{{ get_field("youtube_link", "options") }}"><img class="alignnone size-full wp-image-32" src="{{ get_field("youtube_icon", "options") }}" alt="" width="242" height="244" /></a></li>
				</ul>
			</div>
			@endif

		</div>
	</div>

	<div class="copyright">
		{!! get_field("copyright", "options") !!}
	</div>
</footer>

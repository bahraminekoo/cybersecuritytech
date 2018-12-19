{{--
  Template Name: How It Works
--}}

@extends('layouts.app')

@section('content')
    @while(have_posts()) @php(the_post())
    @component('components/article')
        @include('partials.sections')
    @endcomponent
    @endwhile
@endsection

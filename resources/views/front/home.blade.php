@extends('front.layouts.app')

@section('main')

    @include('front.components.hero')
    @include('front.components.search')
    @include('front.components.popular_job')
    @include('front.components.featured_job')
    @include('front.components.latest')
  
@endsection
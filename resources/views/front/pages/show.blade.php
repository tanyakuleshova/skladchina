{{-- на входе страница $page --}}

@extends('layouts.app')

@section('title',$page->title)
@section('meta-description',$page->metaDescription)
@if($page->metaKeywords)
    @section('meta-keywords')
        <meta name="keywords" content="{{ $page->metaKeywords }}">
    @endsection
@endif
@section('content')
<div class="wrap">
	<div class="container">
		<div class="row">
                    <h1>{!! $page->name !!}</h1>
                    {!! $page->description !!}
		</div>
	</div>
</div>
@endsection

@extends('frontend.layouts.master')

@section('title', $page->title)

@section('content')
    <div class="page-content">
        <section class="py-5">
            <div class="container">
                <h1 class="mb-4">{{ $page->title }}</h1>
                <div>{!! $page->content !!}</div>
            </div>
        </section>
    </div>
@endsection

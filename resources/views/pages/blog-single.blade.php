@extends('layouts.app')
@section('title', $post->title)
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => $post->title, 'bannerImage' => 'images/page-banner-4.jpg'])

    <section id="blog-singel" class="pt-90 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-details mt-30">
                        <div class="thum">
                            <img src="{{ asset($post->image ?: 'images/blog/b-1.jpg') }}" alt="{{ $post->title }}">
                        </div>
                        <div class="cont">
                            <h3>{{ $post->title }}</h3>
                            <ul>
                                @if($post->published_at)<li><i class="fa fa-calendar"></i> {{ $post->published_at->format('d/m/Y') }}</li>@endif
                                @if($post->author)<li>{{ $post->author->name }}</li>@endif
                                @if($post->category)<li>{{ $post->category->name }}</li>@endif
                            </ul>
                            @if($post->excerpt)<p><strong>{{ $post->excerpt }}</strong></p>@endif
                            <div>{!! $post->content !!}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @if($recentPosts->isNotEmpty())
                    <div class="saidbar mt-30">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="saidbar-post mt-30">
                                    <h4>Autres articles</h4>
                                    <ul>
                                        @foreach($recentPosts as $recent)
                                        <li>
                                            <a href="{{ route('blog.show', $recent->id) }}">
                                                <div class="singel-post">
                                                    <div class="thum">
                                                        <img src="{{ asset($recent->image ?: 'images/blog/blog-post/bp-1.jpg') }}" alt="{{ $recent->title }}">
                                                    </div>
                                                    <div class="cont">
                                                        <h6>{{ $recent->title }}</h6>
                                                        @if($recent->published_at)<span>{{ $recent->published_at->format('d/m/Y') }}</span>@endif
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

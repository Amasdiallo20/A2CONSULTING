@extends('layouts.app')
@section('title', 'Blog')
@section('content')
    @include('partials.preloader')
    @include('partials.page-banner', ['title' => 'Blog', 'subtitle' => 'Actualités, conseils et ressources', 'bannerKey' => 'blog'])

    <section id="blog-page" class="pt-90 pb-120 gray-bg">
        <div class="container">
            @if($categories->isNotEmpty())
            <form method="GET" class="mb-30">
                <select name="category" onchange="this.form.submit()">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </form>
            @endif
            <div class="row">
                @forelse($posts as $post)
                <div class="col-12 col-lg-6">
                    <div class="singel-blog mt-30">
                        <div class="blog-thum">
                            <img src="{{ asset($post->image ?: 'images/blog/b-1.jpg') }}" alt="{{ $post->title }}">
                        </div>
                        <div class="blog-cont">
                            <a href="{{ route('blog.show', $post->id) }}"><h3>{{ $post->title }}</h3></a>
                            <ul>
                                @if($post->published_at)<li><i class="fa fa-calendar"></i> {{ $post->published_at->format('d/m/Y') }}</li>@endif
                                @if($post->category)<li>{{ $post->category->name }}</li>@endif
                            </ul>
                            <p>{{ $post->excerpt }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12"><p class="text-center mt-40">Aucun article pour le moment.</p></div>
                @endforelse
            </div>
            <div class="mt-40">{{ $posts->links() }}</div>
        </div>
    </section>
@endsection

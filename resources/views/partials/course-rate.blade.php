@php
    $visitorScore = (int) ($visitorRating ?? 0);
@endphp
<div class="course-rate-box" id="noter">
    <div class="course-rate-box__summary">
        <p class="course-rate-box__label">Avis des visiteurs</p>
        @include('partials.course-stars', ['course' => $course])
    </div>
    <form class="star-rate" action="{{ route('courses.rate', $course->id) }}" method="POST">
        @csrf
        <p class="star-rate__prompt">{{ $visitorScore ? 'Modifier votre note' : 'Noter cette formation' }}</p>
        <div class="star-rate__row">
            @for($star = 1; $star <= 5; $star++)
                <button
                    type="submit"
                    name="rating"
                    value="{{ $star }}"
                    class="star-rate__btn {{ $visitorScore >= $star ? 'is-on' : '' }}"
                    aria-label="{{ $star }} étoile{{ $star > 1 ? 's' : '' }}"
                >
                    <i class="fa fa-star"></i>
                </button>
            @endfor
        </div>
    </form>
    @if(session('rating_success'))
        <p class="course-rate-box__ok">{{ session('rating_success') }}</p>
    @endif
    @error('rating')
        <p class="course-rate-box__error">{{ $message }}</p>
    @enderror
</div>

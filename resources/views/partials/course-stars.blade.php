@php
    $average = $course->ratingAverage();
    $count = $course->ratingCount();
    $compact = !empty($compact);
@endphp
<div class="course-stars {{ $compact ? 'course-stars--compact' : '' }}" title="{{ $average ? number_format($average, 1, ',', ' ').' / 5' : 'Pas encore de note' }}">
    <span class="course-stars__icons" aria-hidden="true">
        @foreach($course->ratingStarStates() as $starState)
            @if($starState === 'full')
                <i class="fa fa-star"></i>
            @elseif($starState === 'half')
                <i class="fa fa-star-half-o"></i>
            @else
                <i class="fa fa-star-o"></i>
            @endif
        @endforeach
    </span>
    @if($count)
        <span class="course-stars__meta">{{ number_format($average, 1, ',', ' ') }} <span>({{ $count }})</span></span>
    @else
        <span class="course-stars__meta course-stars__meta--empty">Nouveau</span>
    @endif
</div>

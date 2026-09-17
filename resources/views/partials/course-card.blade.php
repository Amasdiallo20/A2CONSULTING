<div class="singel-course {{ $extraClass ?? '' }}">
    <div class="thum">
        <div class="image">
            <img src="{{ asset($course->image ?: 'images/course/cu-1.jpg') }}" alt="{{ $course->title }}">
        </div>
        <div class="price">
            <span>
                @if($course->isFree())
                    Gratuit
                @else
                    {{ format_price($course->price) }}
                @endif
            </span>
        </div>
    </div>
    <div class="cont">
        @if($course->category)
            <span>{{ $course->category->name }}</span>
        @endif
        <a href="{{ route('courses.show', $course->id) }}"><h4>{{ $course->title }}</h4></a>
        <div class="course-teacher">
            @if($course->teacher)
            <div class="thum">
                <a href="{{ route('teachers.show', $course->teacher->id) }}">
                    <img src="{{ asset($course->teacher->image ?: 'images/course/teacher/t-1.jpg') }}" alt="{{ $course->teacher->name }}">
                </a>
            </div>
            <div class="name">
                <a href="{{ route('teachers.show', $course->teacher->id) }}"><h6>{{ $course->teacher->name }}</h6></a>
            </div>
            @endif
            <div class="admin">
                <ul>
                    <li><i class="fa fa-user"></i><span>{{ $course->students_count }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>

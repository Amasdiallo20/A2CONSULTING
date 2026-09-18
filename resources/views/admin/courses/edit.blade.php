@extends('admin.layouts.app')

@section('title', 'Modifier un cours')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-edit me-2"></i> Modifier un cours</h1>
    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i> Retour
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.partials.form-errors')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $course->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="3">{{ old('description', $course->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="content" class="form-label">Contenu</label>
                        <textarea class="form-control rich-editor @error('content') is-invalid @enderror" 
                                  id="content" name="content" rows="10">{{ old('content', $course->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Enseignant</label>
                        <select class="form-select @error('teacher_id') is-invalid @enderror" 
                                id="teacher_id" name="teacher_id">
                            <option value="">Sélectionner un enseignant</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $course->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Catégorie</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id">
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $course->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="delivery_mode" class="form-label">Format *</label>
                        <select class="form-select @error('delivery_mode') is-invalid @enderror"
                                id="delivery_mode" name="delivery_mode" required>
                            @foreach(\App\Models\Course::DELIVERY_MODES as $modeValue => $modeLabel)
                                <option value="{{ $modeValue }}" {{ old('delivery_mode', $course->delivery_mode ?? 'hybride') === $modeValue ? 'selected' : '' }}>{{ $modeLabel }}</option>
                            @endforeach
                        </select>
                        @error('delivery_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="price_type" class="form-label">Type de prix *</label>
                        <select class="form-select @error('price_type') is-invalid @enderror" 
                                id="price_type" name="price_type" required>
                            <option value="free" {{ old('price_type', $course->price_type) == 'free' ? 'selected' : '' }}>Gratuit</option>
                            <option value="paid" {{ old('price_type', $course->price_type) == 'paid' ? 'selected' : '' }}>Payant</option>
                        </select>
                        @error('price_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="course-price-field">
                        <label for="price" class="form-label">Prix (GNF)</label>
                        <input type="number" step="1" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', integer_price($course->price)) }}" min="0">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="duration" class="form-label">Durée</label>
                        <input type="text" class="form-control @error('duration') is-invalid @enderror" 
                               id="duration" name="duration" value="{{ old('duration', $course->duration) }}" placeholder="ex: 10 heures">
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="lessons_count" class="form-label">Nombre de leçons</label>
                        <input type="number" class="form-control @error('lessons_count') is-invalid @enderror" 
                               id="lessons_count" name="lessons_count" value="{{ old('lessons_count', $course->lessons_count ?? 0) }}" min="0">
                        @error('lessons_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="quizzes_count" class="form-label">Nombre de quiz</label>
                        <input type="number" class="form-control @error('quizzes_count') is-invalid @enderror" 
                               id="quizzes_count" name="quizzes_count" value="{{ old('quizzes_count', $course->quizzes_count ?? 0) }}" min="0">
                        @error('quizzes_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @include('admin.partials.image-field', ['name' => 'image', 'current' => $course->image, 'label' => 'Image'])
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" {{ old('is_featured', $course->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                Mise en avant
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $course->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Actif
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Enregistrer
                </button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const type = document.getElementById('price_type');
    const field = document.getElementById('course-price-field');
    const input = document.getElementById('price');
    if (!type || !field || !input) return;

    const sync = () => {
        const paid = type.value === 'paid';
        field.style.display = paid ? '' : 'none';
        input.required = paid;
        if (!paid) {
            input.value = 0;
        }
    };

    type.addEventListener('change', sync);
    sync();
})();
</script>
@endpush

@endsection


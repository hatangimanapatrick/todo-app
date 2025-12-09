@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="shadow card">
                    <div class="text-white card-header bg-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Todo
                            </h4>
                            <div class="btn-group">
                                <a href="{{ route('todos.index') }}" class="btn btn-light btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i> Back
                                </a>
                                <a href="{{ route('todos.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> New
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('todos.update', $todo->id) }}" method="POST" id="editTodoForm">
                            @csrf
                            @method('PUT')

                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <h5 class="alert-heading">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                                    </h5>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-bold">
                                    <i class="fas fa-heading me-2"></i>Title *
                                </label>
                                <input type="text"
                                    class="form-control form-control-lg @error('title') is-invalid @enderror" id="title"
                                    name="title" value="{{ old('title', $todo->title) }}" placeholder="Enter todo title"
                                    required>
                                @error('title')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Enter todo description">{{ old('description', $todo->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="mb-4">
                                <label for="due_date" class="form-label fw-bold">
                                    <i class="fas fa-calendar-day me-2"></i>Due Date *
                                </label>
                                <input type="date"
                                    class="form-control form-control-lg @error('due_date') is-invalid @enderror"
                                    id="due_date" name="due_date"
                                    value="{{ old('due_date', $todo->due_date->format('Y-m-d')) }}" " min="{{ date('Y-m-d') }}" required>
                                                @error('due_date')
        <div class="invalid-feedback">
                                                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                                                    </div>
    @enderror
                                            </div>

                                            <!-- Status -->
                                            <div class="mb-4">
                                                <label class="form-label fw-bold d-block">
                                                    <i class="fas fa-toggle-on me-2"></i>Status
                                                </label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_completed" id="status_pending"
                                                        value="0"
                                                        {{ old('is_completed', $todo->is_completed) == 0 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_pending">
                                                        <span class="badge bg-warning">
                                                            <i class="fas fa-clock me-1"></i> Pending
                                                        </span>
                                                    </label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_completed" id="status_completed"
                                                        value="1"
                                                        {{ old('is_completed', $todo->is_completed) == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_completed">
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check-circle me-1"></i> Completed
                                                        </span>
                                                    </label>
                                                </div>


                                            <!-- Action Buttons -->
                                            <div class="pt-4 mt-5 d-flex justify-content-between align-items-center border-top">
                                                <div>
                                                    <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">
                                                        <i class="fas fa-times me-2"></i> Cancel
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger ms-2" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal">
                                                        <i class="fas fa-trash me-2"></i> Delete
                                                    </button>
                                                </div>
                                                <div class="btn-group">
                                                    <button type="submit" name="action" value="save" class="btn btn-primary">
                                                        <i class="fas fa-save me-2"></i> Save Changes
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="deleteModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="text-white modal-header bg-danger">
                                    <h5 class="modal-title">
                                        <i class="fas fa-trash me-2"></i>Delete Todo
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="alert alert-danger">
                                        <h5 class="alert-heading">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Warning!
                                        </h5>
                                        <p class="mb-0">This action cannot be undone. All data associated with this todo will be
                                            permanently deleted.</p>
                                    </div>

                                    <div class="mb-3 card">
                                        <div class="card-body">
                                            <h6 class="fw-bold">{{ $todo->title }}</h6>
                                                @if ($todo->description)
                                <p class="mb-2 small text-muted">{{ Str::limit($todo->description, 100) }}</p>
                                @endif
                                <div class="small">
                                    <span class="badge bg-{{ $todo->is_completed ? 'success' : 'warning' }} me-2">
                                        {{ $todo->is_completed ? 'Completed' : 'Pending' }}
                                    </span>
                                    <span class="text-muted">
                                        Due: {{ $todo->due_date->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                    </div>

                    <p class="mb-0">Are you sure you want to delete this todo?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i> Cancel
                    </button>
                    <form action="{{ route('todos.destroy', $todo->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i> Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .todo-current {
            transition: all 0.3s;
        }

        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .alert-info {
            background-color: rgba(52, 152, 219, 0.1);
            border-color: rgba(52, 152, 219, 0.2);
            color: #2c3e50;
        }

        .alert-success {
            background-color: rgba(39, 174, 96, 0.1);
            border-color: rgba(39, 174, 96, 0.2);
            color: #27ae60;
        }
    </style>
@endsection

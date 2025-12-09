@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="shadow card">
                    <div class="text-white card-header bg-primary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-plus-circle me-2"></i>Create New Todo
                            </h4>
                            <a href="{{ route('todos.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('todos.store') }}" method="POST" id="todoForm">
                            @csrf

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
                                    name="title" value="{{ old('title') }}" placeholder="Enter todo title" required>
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
                                    rows="4" placeholder="Enter todo description (optional)">{{ old('description') }}</textarea>
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
                                    id="due_date" name="due_date" value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}"
                                    required>
                                @error('due_date')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                                    </div>
                                @enderror

                            </div>




                            <!-- Submit Buttons -->
                            <div class="mt-5 d-flex justify-content-between">
                                <a href="{{ route('todos.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> Save Todo
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>


                </div>
            </div>


        </div>
    </div>

    <style>
        .form-control-lg {
            border-radius: 8px;
            padding: 15px;
            font-size: 1.1rem;
        }

        .todo-preview {
            min-height: 300px;
            transition: all 0.3s;
        }

        .todo-preview-content {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-check:checked+.btn-outline-success {
            background-color: #27ae60;
            color: white;
        }

        .btn-check:checked+.btn-outline-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-check:checked+.btn-outline-danger {
            background-color: #e74c3c;
            color: white;
        }

        .card-footer {
            border-top: 1px solid rgba(0, 0, 0, .125);
        }
    </style>
@endsection

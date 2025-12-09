@extends('layouts.app')

@section('content')
    <div class="py-4 container-fluid">
        <!-- Page Header -->
        <div class="mb-4 row">
            <div class="col-12">
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="mb-2 h2 fw-bold">My Todos</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Todos</li>
                            </ol>
                        </nav>
                    </div>
                    <div>
                        <a href="{{ route('todos.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i> New Todo
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <!-- Stats Summary -->
        <div class="mb-4 row">
            <div class="col-md-3">
                <div class="text-white card bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Todos</h6>
                                <h3 class="mb-0">{{ $stats['total'] }}</h3>
                            </div>
                            <i class="opacity-50 fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-white card bg-success">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Completed</h6>
                                <h3 class="mb-0">{{ $stats['completed'] }}</h3>
                            </div>
                            <i class="opacity-50 fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-white card bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Pending</h6>
                                <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                            </div>
                            <i class="opacity-50 fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-white card bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Completion Rate</h6>
                                <h3 class="mb-0">
                                    @if ($stats['total'] > 0)
                                        {{ round(($stats['completed'] / $stats['total']) * 100) }}%
                                    @else
                                        0%
                                    @endif
                                </h3>
                            </div>
                            <i class="opacity-50 fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Todos Table -->
        <div class="shadow card">
            <div class="py-3 card-header d-flex justify-content-between align-items-center">
                <h6 class="m-0 fw-bold text-primary">
                    <i class="fas fa-list me-2"></i>Todos List
                </h6>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-sort me-1"></i>Sort By
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'due_date']) }}">
                            Due Date
                        </a>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'created_at']) }}">
                            Created Date
                        </a>
                        <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['sort' => 'title']) }}">
                            Title
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($todos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th width="40%">Todo</th>
                                    <th width="15%">Due Date</th>
                                    <th width="15%">Status</th>
                                    <th width="25%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($todos as $todo)
                                    <tr
                                        class="{{ $todo->is_completed ? 'table-success' : ($todo->due_date < now() ? 'table-danger' : '') }}">
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input todo-checkbox" type="checkbox"
                                                    data-id="{{ $todo->id }}"
                                                    {{ $todo->is_completed ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-start">
                                                <div class="me-3">
                                                    <form action="{{ route('todos.toggle-status', $todo->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                            class="p-0 bg-transparent border-0 btn btn-sm">
                                                            @if ($todo->is_completed)
                                                                <i class="fas fa-check-circle text-success fa-lg"></i>
                                                            @else
                                                                <i class="far fa-circle text-secondary fa-lg"></i>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </div>
                                                <div>
                                                    <h6
                                                        class="mb-1 {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                                                        {{ $todo->title }}
                                                    </h6>
                                                    @if ($todo->description)
                                                        <p class="mb-0 text-muted small">
                                                            {{ Str::limit($todo->description, 80) }}</p>
                                                    @endif
                                                    <small class="text-muted">
                                                        Created: {{ $todo->created_at->format('M d, Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i
                                                    class="fas fa-calendar-day me-2 {{ $todo->due_date < now() && !$todo->is_completed ? 'text-danger' : 'text-primary' }}"></i>
                                                <div>
                                                    <div
                                                        class="{{ $todo->due_date < now() && !$todo->is_completed ? 'text-danger fw-bold' : '' }}">
                                                        {{ $todo->due_date->format('M d, Y') }}
                                                    </div>
                                                    <small class="text-muted">
                                                        @if ($todo->due_date < now() && !$todo->is_completed)
                                                            Overdue
                                                        @elseif($todo->due_date->diffInDays(now()) == 0)
                                                            Today
                                                        @elseif($todo->due_date->diffInDays(now()) == 1)
                                                            Tomorrow
                                                        @else
                                                            {{ $todo->due_date->diffForHumans() }}
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if ($todo->is_completed)
                                                <span class="px-3 py-2 badge bg-success">
                                                    <i class="fas fa-check me-1"></i> Completed
                                                </span>
                                            @else
                                                <span class="px-3 py-2 badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i> Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <form action="{{ route('todos.toggle-status', $todo->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $todo->is_completed ? 'btn-warning' : 'btn-success' }}">
                                                        @if ($todo->is_completed)
                                                            <i class="fas fa-undo me-1"></i> Mark Pending
                                                        @else
                                                            <i class="fas fa-check me-1"></i> Mark Complete
                                                        @endif
                                                    </button>
                                                </form>

                                                <a href="{{ route('todos.edit', $todo->id) }}"
                                                    class="btn btn-sm btn-primary ms-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <button type="button" class="btn btn-sm btn-danger ms-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $todo->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- Delete Modal -->
                                            <div class="modal fade" id="deleteModal{{ $todo->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirm Delete</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete this todo?</p>
                                                            <div class="alert alert-warning">
                                                                <strong>{{ $todo->title }}</strong>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('todos.destroy', $todo->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="mt-3 row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="bulkSelectAll">
                                    <label class="form-check-label ms-2" for="bulkSelectAll">
                                        Select all {{ $todos->count() }} todos
                                    </label>
                                </div>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" id="bulkComplete">
                                        <i class="fas fa-check me-1"></i> Mark Selected Complete
                                    </button>
                                    <button type="button" class="btn btn-warning" id="bulkPending">
                                        <i class="fas fa-undo me-1"></i> Mark Selected Pending
                                    </button>
                                    <button type="button" class="btn btn-danger" id="bulkDelete">
                                        <i class="fas fa-trash me-1"></i> Delete Selected
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4 row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    Showing {{ $todos->firstItem() }} to {{ $todos->lastItem() }} of
                                    {{ $todos->total() }} entries
                                </div>
                                <nav>
                                    {{ $todos->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="py-5 text-center">
                        <div class="empty-state">
                            <i class="mb-4 fas fa-clipboard-list fa-4x text-muted"></i>
                            <h3>No Todos Found</h3>
                            <p class="mb-4 text-muted">
                                @if (request('filter') || request('search'))
                                    Try adjusting your search or filter to find what you're looking for.
                                @else
                                    You haven't created any todos yet. Start by creating your first todo!
                                @endif
                            </p>
                            <a href="{{ route('todos.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus me-2"></i> Create Your First Todo
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- JavaScript for Bulk Actions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Select All Checkboxes
            const selectAll = document.getElementById('selectAll');
            const todoCheckboxes = document.querySelectorAll('.todo-checkbox');

            selectAll.addEventListener('change', function() {
                todoCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Bulk Select All
            const bulkSelectAll = document.getElementById('bulkSelectAll');
            bulkSelectAll.addEventListener('change', function() {
                todoCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Bulk Complete
            document.getElementById('bulkComplete').addEventListener('click', function() {
                const selectedIds = Array.from(todoCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.id);

                if (selectedIds.length === 0) {
                    alert('Please select at least one todo.');
                    return;
                }

                if (confirm(`Mark ${selectedIds.length} todo(s) as complete?`)) {
                    selectedIds.forEach(id => {
                        fetch(`/todos/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    });
                }
            });

            // Bulk Pending
            document.getElementById('bulkPending').addEventListener('click', function() {
                const selectedIds = Array.from(todoCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.id);

                if (selectedIds.length === 0) {
                    alert('Please select at least one todo.');
                    return;
                }

                if (confirm(`Mark ${selectedIds.length} todo(s) as pending?`)) {
                    selectedIds.forEach(id => {
                        fetch(`/todos/${id}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        }).then(() => {
                            window.location.reload();
                        });
                    });
                }
            });

            // Bulk Delete
            document.getElementById('bulkDelete').addEventListener('click', function() {
                const selectedIds = Array.from(todoCheckboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.dataset.id);

                if (selectedIds.length === 0) {
                    alert('Please select at least one todo.');
                    return;
                }

                if (confirm(`Delete ${selectedIds.length} todo(s)? This action cannot be undone.`)) {
                    // Create a form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/todos/bulk-delete';

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = document.querySelector('meta[name="csrf-token"]').content;
                    form.appendChild(csrf);

                    selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'ids[]';
                        input.value = id;
                        form.appendChild(input);
                    });

                    document.body.appendChild(form);
                    form.submit();
                }
            });

            // Auto-check if all checkboxes are checked
            function updateSelectAllCheckbox() {
                const allChecked = Array.from(todoCheckboxes).every(cb => cb.checked);
                selectAll.checked = allChecked;
                bulkSelectAll.checked = allChecked;
            }

            todoCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectAllCheckbox);
            });
        });
    </script>

    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .table-success {
            background-color: rgba(39, 174, 96, 0.1) !important;
        }

        .table-danger {
            background-color: rgba(231, 76, 60, 0.1) !important;
        }

        .empty-state {
            max-width: 400px;
            margin: 0 auto;
        }

        .btn-group .btn {
            border-radius: 6px !important;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .form-check-input:checked {
            background-color: #3498db;
            border-color: #3498db;
        }
    </style>
@endsection

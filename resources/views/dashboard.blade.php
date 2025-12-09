@extends('layouts.app')

@section('content')
<div class="py-4 container-fluid">
    <!-- Page Header -->
    <div class="mb-4 row">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2 h2 fw-bold">Dashboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Overview</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('todos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i> Add New Todo
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="mb-4 row">
        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-primary h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs fw-bold text-primary text-uppercase">
                                Total Todos
                            </div>
                            <div class="mb-0 text-gray-800 h5 fw-bold">{{ $totalTodos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-tasks fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-success h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs fw-bold text-success text-uppercase">
                                Completed
                            </div>
                            <div class="mb-0 text-gray-800 h5 fw-bold">{{ $completedTodos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-warning h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs fw-bold text-warning text-uppercase">
                                Pending
                            </div>
                            <div class="mb-0 text-gray-800 h5 fw-bold">{{ $pendingTodos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4 col-xl-3 col-md-6">
            <div class="py-2 shadow card border-left-info h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="mr-2 col">
                            <div class="mb-1 text-xs fw-bold text-info text-uppercase">
                                Completion Rate
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="mb-0 mr-3 text-gray-800 h5 fw-bold">
                                        @if($totalTodos > 0)
                                            {{ round(($completedTodos / $totalTodos) * 100) }}%
                                        @else
                                            0%
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mr-2 progress progress-sm">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $totalTodos > 0 ? ($completedTodos / $totalTodos) * 100 : 0 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="text-gray-300 fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Recent Todos -->
        <div class="col-xl-6 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-history me-2"></i>Recent Todos
                    </h6>
                    <a href="{{ route('todos.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($recentTodos->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTodos as $todo)
                                <div class="py-3 border-0 list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <form action="{{ route('todos.toggle-status', $todo->id) }}" method="POST" class="me-3">
                                                @csrf
                                                <button type="submit" class="p-0 bg-transparent border-0 btn btn-sm">
                                                    @if($todo->is_completed)
                                                        <i class="fas fa-check-circle text-success fa-lg"></i>
                                                    @else
                                                        <i class="far fa-circle text-secondary fa-lg"></i>
                                                    @endif
                                                </button>
                                            </form>
                                            <div>
                                                <h6 class="mb-1 {{ $todo->is_completed ? 'text-decoration-line-through text-muted' : '' }}">
                                                    {{ $todo->title }}
                                                </h6>
                                                @if($todo->description)
                                                    <p class="mb-0 text-muted small">{{ Str::limit($todo->description, 60) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted d-block">{{ $todo->created_at->diffForHumans() }}</small>
                                            <span class="badge bg-{{ $todo->is_completed ? 'success' : ($todo->due_date < now() ? 'danger' : 'warning') }}">
                                                Due: {{ $todo->due_date->format('M d') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-clipboard-list fa-3x text-muted"></i>
                            <p class="text-muted">No recent todos found.</p>
                            <a href="{{ route('todos.create') }}" class="btn btn-primary btn-sm">
                                Create Your First Todo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Todos -->
        <div class="col-xl-6 col-lg-6">
            <div class="mb-4 shadow card">
                <div class="flex-row py-3 card-header d-flex align-items-center justify-content-between">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-calendar-alt me-2"></i>Upcoming Todos
                    </h6>
                    <a href="{{ route('todos.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($upcomingTodos->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($upcomingTodos as $todo)
                                        <tr class="{{ $todo->due_date < now() ? 'table-danger' : '' }}">
                                            <td>
                                                <strong>{{ Str::limit($todo->title, 25) }}</strong>
                                                @if($todo->due_date < now())
                                                    <span class="badge bg-danger ms-1">Overdue</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="{{ $todo->due_date < now() ? 'text-danger fw-bold' : '' }}">
                                                    {{ $todo->due_date->format('M d, Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($todo->is_completed)
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <form action="{{ route('todos.toggle-status', $todo->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-{{ $todo->is_completed ? 'warning' : 'success' }}">
                                                            {{ $todo->is_completed ? 'Undo' : 'Complete' }}
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="py-4 text-center">
                            <i class="mb-3 fas fa-calendar-check fa-3x text-muted"></i>
                            <p class="text-muted">No upcoming todos. Great job!</p>
                            <p class="small text-muted">All your todos are completed or you haven't created any.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-lg-12">
            <div class="mb-4 shadow card">
                <div class="py-3 card-header">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-chart-pie me-2"></i>Todo Distribution
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="todoChart"></canvas>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4">
                                <h4 class="small fw-bold">Completion Progress</h4>
                                <div class="mb-3 progress">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $totalTodos > 0 ? ($completedTodos / $totalTodos) * 100 : 0 }}%">
                                    </div>
                                </div>

                                <h4 class="mt-4 small fw-bold">Todo Status</h4>
                                <div class="mb-2 d-flex align-items-center">
                                    <div class="bg-success rounded-circle me-2" style="width: 15px; height: 15px;"></div>
                                    <span>Completed: {{ $completedTodos }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="bg-warning rounded-circle me-2" style="width: 15px; height: 15px;"></div>
                                    <span>Pending: {{ $pendingTodos }}</span>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('todos.create') }}" class="mb-2 btn btn-primary w-100">
                                        <i class="fas fa-plus me-2"></i>Add New Todo
                                    </a>
                                    <a href="{{ route('todos.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-list me-2"></i>View All Todos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Todo Chart
        const ctx = document.getElementById('todoChart').getContext('2d');
        const todoChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Completed', 'Pending'],
                datasets: [{
                    data: [{{ $completedTodos }}, {{ $pendingTodos }}],
                    backgroundColor: ['#27ae60', '#f39c12'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed;
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    .border-left-primary {
        border-left: 4px solid #3498db !important;
    }
    .border-left-success {
        border-left: 4px solid #27ae60 !important;
    }
    .border-left-warning {
        border-left: 4px solid #f39c12 !important;
    }
    .border-left-info {
        border-left: 4px solid #17a2b8 !important;
    }
    .page-header {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>
@endsection

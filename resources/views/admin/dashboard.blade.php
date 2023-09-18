@extends('layouts.main')
@section('container')
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $dashboard->dashboard_name }}</h3>
                    <p class="mb-0">{{ $dashboard->description }}</p>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $dashboard->dashboard_name }}</h3>
                    <p class="mb-0">{{ $dashboard->description }}</p>
                </div>
                <a href="/admin-panel" type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-0 ms-md-auto mb-md-0 mb-2 me-md-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-md-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Admin Panel</span>
                </a>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#addDashboardModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="btn-inner--text">Add Dashboard Panel</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#settingDashboardModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-cog"></i>
                    </span>
                    <span class="btn-inner--text">Dashboard Setting</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-icon btn-outline-danger d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                    data-bs-toggle="modal" data-bs-target="#deleteDashboardModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                    <span class="btn-inner--text">Delete Dashboard</span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="settingDashboardModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/dashboard/{{ $dashboard->id }}">
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Dashboard Setting
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    {{-- <input type="number" name="id" value="{{ $dashboard->id }}" required hidden> --}}
                                    <div class="form-group">
                                        <label for="dashboard-name" class="col-form-label">Dashboard
                                            Name:</label>
                                        <input type="text" class="form-control" id="dashboard-name" name="dashboard_name"
                                            value="{{ old('dashboard_name', $dashboard->dashboard_name) }}">
                                        @error('dashboard_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="dashboard-description" class="col-form-label">Description:</label>
                                        <textarea class="form-control" id="dashboard-description" name="description" required>{{ old('description', $dashboard->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteDashboardModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/dashboard/{{ $dashboard->id }}">
                                @method('DELETE')
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Dashboard
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    <h5>Are you sure you want
                                        to delete dashboard {{ $dashboard->dashboard_name }} ?</h5>
                                    {{-- <input type="number" name="panel_id" value="{{ $panel->id }}"
                                        required hidden> --}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="addDashboardModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/panel">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add new Panel
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    <input type="number" name="dashboard_id" value="{{ $dashboard->id }}" required
                                        hidden>
                                    <div class="form-group">
                                        <label for="panel-name" class="col-form-label">Panel
                                            Name:</label>
                                        <input type="text" class="form-control" id="panel-name" name="panel_name"
                                            value="{{ old('panel_name') }}" required>
                                        @error('panel_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="parameter_id" class="col-form-label">Parameter:</label>
                                        <select class="form-control" id="parameter_id" name="parameter_id" required>
                                            @foreach ($parameters as $parameter)
                                                <option value="{{ $parameter->id }}">
                                                    {{ $parameter->name . ' (Identifier: ' . $parameter->slug . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('parameter_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="parameter" class="col-form-label">Parameter:</label>
                                        <select class="form-control" id="parameter" name="parameter">
                                            @foreach ($parameters as $parameter)
                                                <option value="{{ $parameter->id }}">
                                                    {{ $parameter->name . ' | ' . $parameter->slug }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('th_L_enable')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    {{-- <div class="form-group">
                                        <label for="type" class="col-form-label">Type:</label>
                                        <input type="number" class="form-control" id="type" name="type"
                                            value="{{ old('type') }}" required>
                                        @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="size" class="col-form-label">Size (1 - 12):</label>
                                        <input type="number" class="form-control" id="size" name="size"
                                            value="{{ old('size', 1) }}" required>
                                        @error('size')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="order" class="col-form-label">Order:</label>
                                        <input type="number" class="form-control" id="order" name="order"
                                            value="{{ old('order') }}" required>
                                        @error('order')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row mt-4">
        {{-- <h3 class="col-12 text-center opacity-5">No data available.</h3> --}}
        @if (!$dashboard->panels->count())
            <h3 class="col-12 text-center opacity-5">No data available.</h3>
        @else
            @foreach ($dashboard->panels as $panel)
                @if ($panel->parameter)
                    <div class="col-md-{{ $panel->size }} mb-3">
                        <div class="card border shadow-xs mb-4 h-100">
                            <div class="full-background bg-primary opacity-3 p-auto"></div>
                            <div class="card-header border-bottom pb-0">
                                <div class="d-sm-flex align-items-center mb-3">
                                    <div>
                                        <h6 class="font-weight-semibold text-lg mb-0">{{ $panel->panel_name }}</h6>
                                    </div>
                                    <div class="ms-auto d-flex">
                                        {{-- <button type="button" class="btn btn-sm btn-white mb-0">
                                    Setting
                                </button> --}}
                                        {{-- <button type="button"
                                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-2"
                                    data-bs-toggle="modal" data-bs-target="#deleteModalPanel-{{ $panel->id }}">
                                    <span class="btn-inner--icon">
                                        <i class="fa-solid fa-external-link-alt"></i>
                                    </span>
                                </button> --}}
                                        <a href="{{ url('admin-panel/parameter/' . $panel->parameter->id) }}"
                                            type="button"
                                            class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-external-link-alt"></i>
                                            </span>
                                        </a>
                                        <button type="button"
                                            class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModalPanel-{{ $panel->id }}">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                                            data-bs-toggle="modal" data-bs-target="#editModalPanel-{{ $panel->id }}">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-gear"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModalPanel-{{ $panel->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="/admin-panel/panel/{{ $panel->id }}">
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Panel
                                                        </h5>
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body mx-3">
                                                        @csrf
                                                        {{-- <input type="number" name="panel_id" value="{{ $panel->id }}"
                                                    required hidden> --}}
                                                        <div class="form-group">
                                                            <label for="dashboard-name" class="col-form-label">Panel
                                                                Name:</label>
                                                            <input type="text" class="form-control"
                                                                id="dashboard-name" name="panel_name"
                                                                value="{{ old('panel_name', $panel->panel_name) }}"
                                                                required>
                                                            @error('panel_name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        {{-- <div class="form-group">
                                                    <label for="parameter" class="col-form-label">Parameter:</label>
                                                    <input type="number" class="form-control" id="parameter"
                                                        name="parameter_id"
                                                        value="{{ old('parameter_id', $panel->parameter_id) }}"
                                                        required>
                                                    @error('parameter_id')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div> --}}
                                                        <div class="form-group">
                                                            <label for="parameter_id"
                                                                class="col-form-label">Parameter:</label>
                                                            <select class="form-control" id="parameter_id"
                                                                name="parameter_id" required>
                                                                @foreach ($parameters as $parameter)
                                                                    <option value="{{ $parameter->id }}"
                                                                        {{ $panel->parameter->id == $parameter->id ? 'selected' : '' }}>
                                                                        {{ $parameter->name . ' (Identifier: ' . $parameter->slug . ')' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('parameter_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="size" class="col-form-label">Size (1 -
                                                                12):</label>
                                                            <input type="number" class="form-control" id="size"
                                                                name="size" value="{{ old('size', $panel->size) }}"
                                                                required>
                                                            @error('size')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="order" class="col-form-label">Order:</label>
                                                            <input type="number" class="form-control" id="order"
                                                                name="order" value="{{ old('order', $panel->order) }}"
                                                                required>
                                                            @error('order')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-dark">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="deleteModalPanel-{{ $panel->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="/admin-panel/panel/{{ $panel->id }}">
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Panel
                                                        </h5>
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body mx-3">
                                                        @csrf
                                                        <h5>Are you sure you want
                                                            to delete panel {{ $panel->panel_name }} ?</h5>
                                                        {{-- <input type="number" name="panel_id" value="{{ $panel->id }}"
                                                    required hidden> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($panel->parameter->type == 'number')
                                    {!! $charts[$loop->index]->container() !!}
                                    {!! $charts[$loop->index]->script() !!}
                                @else
                                    <div class="d-flex align-items-center h-100">
                                        <h1 class="mx-auto text-center">
                                            <span
                                                id="live_string-{{ $panel->parameter->id }}">{{ $panel->parameter->actual_string }}
                                            </span>
                                        </h1>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-{{ $panel->size }} mb-3">
                        <div class="card border shadow-xs mb-4 h-100">
                            <div class="full-background bg-primary opacity-3 p-auto"></div>
                            <div class="card-header border-bottom pb-0">
                                <div class="d-sm-flex align-items-center mb-3">
                                    <div>
                                        <h6 class="font-weight-semibold text-lg mb-0">{{ $panel->panel_name }}</h6>
                                    </div>
                                    <div class="ms-auto d-flex">
                                        <button type="button"
                                            class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModalPanel-{{ $panel->id }}">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-trash"></i>
                                            </span>
                                        </button>
                                        <button type="button"
                                            class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                                            data-bs-toggle="modal" data-bs-target="#editModalPanel-{{ $panel->id }}">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-gear"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="editModalPanel-{{ $panel->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="/admin-panel/panel/{{ $panel->id }}">
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Edit Panel
                                                        </h5>
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body mx-3">
                                                        @csrf
                                                        {{-- <input type="number" name="panel_id" value="{{ $panel->id }}"
                                                    required hidden> --}}
                                                        <div class="form-group">
                                                            <label for="dashboard-name" class="col-form-label">Panel
                                                                Name:</label>
                                                            <input type="text" class="form-control"
                                                                id="dashboard-name" name="panel_name"
                                                                value="{{ old('panel_name', $panel->panel_name) }}"
                                                                required>
                                                            @error('panel_name')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="parameter_id"
                                                                class="col-form-label">Parameter:</label>
                                                            <select class="form-control" id="parameter_id"
                                                                name="parameter_id" required>
                                                                @foreach ($parameters as $parameter)
                                                                    <option value="{{ $parameter->id }}">
                                                                        {{ $parameter->name . ' (Identifier: ' . $parameter->slug . ')' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('parameter_id')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="size" class="col-form-label">Size (1 -
                                                                12):</label>
                                                            <input type="number" class="form-control" id="size"
                                                                name="size" value="{{ old('size', $panel->size) }}"
                                                                required>
                                                            @error('size')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="order" class="col-form-label">Order:</label>
                                                            <input type="number" class="form-control" id="order"
                                                                name="order" value="{{ old('order', $panel->order) }}"
                                                                required>
                                                            @error('order')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-dark">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="deleteModalPanel-{{ $panel->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <form method="post" action="/admin-panel/panel/{{ $panel->id }}">
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Delete Panel
                                                        </h5>
                                                        <button type="button" class="btn-close text-dark"
                                                            data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body mx-3">
                                                        @csrf
                                                        <h5>Are you sure you want
                                                            to delete panel {{ $panel->panel_name }} ?</h5>
                                                        {{-- <input type="number" name="panel_id" value="{{ $panel->id }}"
                                                    required hidden> --}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-white"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-start p-3 w-100">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="w-100">
                                            <h3>PARAMETER IS MISSING</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection

@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $parameter->name }}</h3>
                    <p class="mb-0">Identifier: {{ $parameter->slug }}</p>
                    <p class="mb-0">Type: {{ $parameter->type }}</p>
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
                    data-bs-toggle="modal" data-bs-target="#settingParameterModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-cog"></i>
                    </span>
                    <span class="btn-inner--text">Parameter Setting</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-icon btn-outline-danger d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                    data-bs-toggle="modal" data-bs-target="#deleteParameterModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                    <span class="btn-inner--text">Delete Parameter</span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="settingParameterModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/parameter/{{ $parameter->id }}">
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Parameter Setting
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf

                                    <div class="row">
                                        {{-- <div class="form-group col">
                                            <label for="type" class="col-form-label">Type:</label>
                                            <select class="form-control" id="type" name="type">
                                                <option value="number"
                                                    {{ old('type', $parameter->type) == 'number' ? 'selected' : '' }}>
                                                    Number</option>
                                                <option value="string"
                                                    {{ old('type', $parameter->type) == 'string' ? 'selected' : '' }}>
                                                    String
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div> --}}
                                        <div class="form-group col">
                                            <label for="parameter-name" class="col-form-label">Parameter
                                                Name:</label>
                                            <input type="text" class="form-control" id="parameter-name" name="name"
                                                value="{{ old('name', $parameter->name) }}">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="unit" class="col-form-label">Unit:</label>
                                            <input type="text" class="form-control" id="unit" name="unit"
                                                value="{{ old('unit', $parameter->unit) }}">
                                            @error('unit')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="max" class="col-form-label">Max Value:</label>
                                            <input type="number" step="any" class="form-control" id="max"
                                                name="max" value="{{ old('max', $parameter->max) }}">
                                            @error('max')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="max" class="col-form-label">Min Value:</label>
                                            <input type="number" step="any" class="form-control" id="min"
                                                name="min" value="{{ old('min', $parameter->min) }}">
                                            @error('min')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="th_H_enable" class="col-form-label">Enable Threshold
                                                High:</label>
                                            <select class="form-control" id="th_H_enable" name="th_H_enable">
                                                <option value="1"
                                                    {{ old('th_H_enable', $parameter->th_H_enable) == '1' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="0"
                                                    {{ old('th_H_enable', $parameter->th_H_enable) == '0' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                            @error('th_H_enable')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="th_H" class="col-form-label">Threshold
                                                High:</label>
                                            <input type="number" step="any" class="form-control" id="th_H"
                                                name="th_H" value="{{ old('th_H', $parameter->th_H) }}">
                                            @error('th_H')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="th_L_enable" class="col-form-label">Enable Threshold
                                                Low:</label>
                                            <select class="form-control" id="th_L_enable" name="th_L_enable">
                                                <option value="1"
                                                    {{ old('th_L_enable', $parameter->th_L_enable) == '1' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="0"
                                                    {{ old('th_L_enable', $parameter->th_L_enable) == '0' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                            @error('th_L_enable')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="th_L" class="col-form-label">Threshold
                                                Low:</label>
                                            <input type="number" step="any" class="form-control" id="th_L"
                                                name="th_L" value="{{ old('th_L', $parameter->th_L) }}">
                                            @error('th_L')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="log_enable" class="col-form-label">Enable Log:</label>
                                            <select class="form-control" id="log_enable" name="log_enable">
                                                <option value="1"
                                                    {{ old('log_enable', $parameter->log_enable) == '1' ? 'selected' : '' }}>
                                                    Yes</option>
                                                <option value="0"
                                                    {{ old('log_enable', $parameter->log_enable) == '0' ? 'selected' : '' }}>
                                                    No
                                                </option>
                                            </select>
                                            @error('log_enable')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="log_interval" class="col-form-label">Log Interval
                                                (second):</label>
                                            <input type="number" step="none" min="1" class="form-control"
                                                id="log_interval" name="log_interval"
                                                value="{{ old('log_interval', $parameter->log_interval) }}">
                                            @error('log_interval')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col">
                                            <label for="topic_id" class="col-form-label">Connection:</label>
                                            <select class="form-control" id="topic_id" name="topic_id">
                                                @foreach ($connections as $connection)
                                                    @foreach ($connection->topics as $topic)
                                                        <option value="{{ $topic->id }}"
                                                            {{ $parameter->topic_id == $topic->id ? 'selected' : '' }}>
                                                            Broker: {{ $connection->broker_address }} | Topic:
                                                            {{ $topic->topic }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            @error('log_enable')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="form-group col">
                                            <label for="json_path" class="col-form-label">JSON Path:</label>
                                            <input type="text" step="none" min="1" class="form-control"
                                                id="json_path" name="json_path"
                                                value="{{ old('json_path', $parameter->json_path) }}">
                                            @error('json_path')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
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
                <div class="modal fade" id="deleteParameterModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/parameter/{{ $parameter->id }}">
                                @method('DELETE')
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Parameter
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    <h5>Are you sure you want
                                        to delete parameter {{ $parameter->name }} ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal fade" id="settingDashboardModal" tabindex="-1" role="dialog"
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
                                        <label for="parameter" class="col-form-label">Parameter:</label>
                                        <input type="number" class="form-control" id="parameter" name="parameter_id"
                                            value="{{ old('parameter_id') }}" required>
                                        @error('parameter_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
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
                </div> --}}
            </div>
        </div>
    </div>
    <hr class="my-0">
    {{-- <div class="row mt-4">
        <h3 class="col-12 text-center opacity-5">No data available.</h3>
    </div> --}}
    <div class="row mt-4">
        <form class="" role="form">
            @csrf
            <div class="mb-3 row g-3">
                <div class="col-sm-12 col-lg-2">
                    <label for="datetimerange" class="col-form-label">Choose Range</label>
                </div>
                <div class="col-xs-auto col-lg-5">
                    <input type="text" name="datetimerange" id="datetimerange" value="{{ $datetimerange ?: '' }}"
                        class="form-control">
                </div>
                <div class="col-xs-auto col-lg-2">
                    <div class="form-group">
                        <select name="group" id="" class="form-control">
                            <option value="hour" {{ $group == 'hour' ? 'selected' : '' }}>By Hour</option>
                            <option value="date" {{ $group == 'date' ? 'selected' : '' }}>By Date</option>
                            <option value="none" {{ $group == 'none' ? 'selected' : '' }}>None</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-auto col-lg-2">
                    <button type="submit" value="Submit" name="apply" formmethod="post"
                        formaction="{{ url('admin-panel/parameter/' . $parameter->id) }}"
                        class="btn btn-dark">Apply</button>
                    {{-- <a class="btn btn-success" href="{{ url('admin-panel/export/parameter') }}"
                        target="_blank">Export</a> --}}
                    <button class="btn btn-outline-success" type="button"
                        onclick="window.open('{{ route('export_parameter_admin', ['datetimerange' => $datetimerange, 'parameter_name' => $parameter->name, 'parameter_id' => $parameter->id]) }}','_blank')">
                        <span class="btn-inner--icon">
                            <i class="text-success fa-solid fa-file-excel"></i>
                        </span>
                        <span class="btn-inner--text">Export</span>
                    </button>
                </div>
            </div>
        </form>
    </div>


    <div class="row mt-4">
        {{-- <div class="col-4 text-center opacity-5 border">WILL DO GAUGE</div> --}}
        @if ($parameter->type == 'number')
            {{-- <div class="col-lg-4 border py-2">
                <h4 class="text-center">Actual Value</h4>
                {!! $charts['chart_gauge']->container() !!}
                {!! $charts['chart_gauge']->script() !!}
            </div> --}}
            <div class="col-lg-4">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Actual Value <span id="alert-parameter"></span>
                                </h6>
                                {{-- <h6 class="font-weight-semibold text-lg">Actual Value <i
                                    class="fa-solid fa-exclamation-triangle ms-2 text-danger"></i>
                            </h6> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $charts['chart_gauge']->container() !!}
                        {!! $charts['chart_gauge']->script() !!}
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Historical Graph</h6>
                                {{-- <p class="text-sm">See information about all parameters</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $charts['chart_line']->container() !!}
                        {!! $charts['chart_line']->script() !!}
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-8 border py-2">
                <h4 class="text-center">Historical Graph</h4>
                {!! $charts['chart_line']->container() !!}
                {!! $charts['chart_line']->script() !!}
            </div> --}}
        @endif
        {{-- <div class="col-8 text-center opacity-5 border">WILL DO GRAPH</div> --}}
    </div>
    {{-- <div class="row mt-4">
        <div class="col-12 text-center opacity-5 border">WILL DO DATATABLE AND EXPORT WITH GRAPH</div>
    </div> --}}
    <div class="row mt-4">
        @if ($parameter->type == 'string')
            <div class="col-lg-6">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Actual Value</h6>
                                {{-- <p class="text-sm">See information about all parameters</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <h1><span id="live_string">{{ $parameter->actual_string }}</span></h1>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-6">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg">Historical Log</h6>
                            {{-- <p class="text-sm">See information about all parameters</p> --}}
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="historical_log" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($parameter->type == 'number')
            <div class="col-lg-6">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Alert Log</h6>
                                {{-- <p class="text-sm">See information about all parameters</p> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <table id="alert_log" class="display text-center" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Alert</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

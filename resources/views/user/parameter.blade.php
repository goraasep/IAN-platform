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
                <a href="{{ url()->previous() }}" type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-0 ms-md-auto mb-md-0 mb-2 me-md-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-md-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back</span>
                </a>
            </div>
        </div>
    </div>
    <hr class="my-0">
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
                        formaction="{{ url('dashboard/parameter/' . $parameter->id) }}" class="btn btn-dark">Apply</button>
                    <button class="btn btn-outline-success" type="button"
                        onclick="window.open('{{ route('export_parameter_user', ['datetimerange' => $datetimerange, 'parameter_name' => $parameter->name, 'parameter_id' => $parameter->id]) }}','_blank')">
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
        @if ($parameter->type == 'number')
            <div class="col-lg-4">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Actual Value <span id="alert-parameter"></span>
                                </h6>
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
        @endif
    </div>
    <div class="row mt-4">
        @if ($parameter->type == 'string')
            <div class="col-lg-6">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg">Actual Value</h6>
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

@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $device->name }}</h3>
                    <p class="mb-0">{{ $device->description }}</p>
                </div>
                <a href="/devices/" type="button"
                    class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Devices List</span>

                </a>
                <a href="/devices/{{ $device->uuid }}/edit" type="button"
                    class=" btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 me-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-gear d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Device Configuration</span>

                </a>
                <a type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                    <span class="btn-inner--icon">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>
                    <span class="btn-inner--text">Refresh</span>
                </a>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row">
        <div class="position-relative overflow-hidden">
            <div class="swiper mySwiper mt-4 mb-2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div>
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-2.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#1</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Secured</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category</p>
                                            <h5 class="text-dark font-weight-bolder">Banking</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
            <div class="card shadow-xs border">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Alert History</h6>
                            <p class="text-sm mb-sm-0 mb-2">These are list of alert occurances.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                View report
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="alert_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Alert</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-6">
            <div class="card shadow-xs border">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Parameter</h6>
                            <p class="text-sm mb-sm-0 mb-2">These are details about all peremeters on this device.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            {{-- <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                View report
                            </button> --}}
                            <button type="button" class="btn btn-sm btn-dark btn-icon mb-0 me-2" data-bs-toggle="modal"
                                data-bs-target="#addParamModal">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add Parameter</span>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="addParamModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/parameter">
                                            @csrf
                                            <input type="text" class="form-control" id="device-uuid" name="uuid"
                                                value="{{ $device->uuid }}" hidden required>
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new parameter
                                                </h5>
                                                <button type="button" class="btn-close text-dark"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    {{-- <span aria-hidden="true">×</span> --}}
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="parameter-name" class="col-form-label">Parameter
                                                        Name:</label>
                                                    <input type="text" class="form-control" id="parameter-name"
                                                        name="name" value="{{ old('name') }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="parameter-unit" class="col-form-label">Unit:</label>
                                                    <input type="text" class="form-control" id="parameter-unit"
                                                        name="unit" value="{{ old('unit') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="parameter-type" class="col-form-label">Type:</label>
                                                    <select class="form-select" id="parameter-type" name="type">
                                                        <option value="number">Number</option>
                                                        <option value="string">String</option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="parameter-th-H" class="col-form-label">Threshold
                                                                High:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" step="any" class="form-control"
                                                                id="parameter-th-H" name="th_H"
                                                                value="{{ old('th_H', 0) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-select" name="th_H_enable">
                                                                <option value="0">Disable</option>
                                                                <option value="1">Enable</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="parameter-th-L" class="col-form-label">Threshold
                                                                Low:</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <input type="number" step="any" class="form-control"
                                                                id="parameter-th-L" name="th_L"
                                                                value="{{ old('th_L', 0) }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <select class="form-select" name="th_L_enable">
                                                                <option value="0">Disable</option>
                                                                <option value="1">Enable</option>
                                                            </select>
                                                        </div>
                                                    </div>
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
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="parameter_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Value</th>
                                <th>Unit</th>
                                <th>Alert</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <p class="mb-0">String type parameter</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    @livewire('string-parameter', [
        'device_id' => $device->id,
    ])
    {{-- <div class="row my-4">
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-2 col-sm-3 mb-xl-0">
            <div class="card border shadow-xs mb-4">
                <div class="card-body text-start p-3 w-100">
                    <div class="row">
                        <div class="col-12">
                            <div class="w-100">
                                <p class="text-sm text-secondary mb-1">Door 1</p>
                                <h4 class="mb-2 font-weight-bold">Close</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <p class="mb-0">Number type parameter</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row my-4">
        <div class="col-lg-12">
            <div class="card shadow-xs border">
                <div class="card-header pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Voltage 1</h6>
                            <p class="text-sm mb-sm-0 mb-2">Here you have details Voltage 1.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                View report
                            </button>
                        </div>
                    </div>
                    <div class="d-sm-flex align-items-center">
                        <h3 class="mb-0 font-weight-semibold">12.5 V</h3>
                    </div>
                </div>
                <div class="card-body p-3 row">
                    <div class="col-lg-3">GAUGE</div>
                    <div class="col-lg-9">
                        Chart
                        <div class="chart mt-n6">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row my-4">
        <div class="col-lg-12">
            <div class="card shadow-xs border">
                <div class="card-header pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Voltage 2</h6>
                            <p class="text-sm mb-sm-0 mb-2">Here you have details Voltage 2.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                View report
                            </button>
                        </div>
                    </div>
                    <div class="d-sm-flex align-items-center">
                        <h3 class="mb-0 font-weight-semibold">12.5 V</h3>
                    </div>
                </div>
                <div class="card-body p-3 row">
                    <div class="col-lg-3">GAUGE</div>
                    <div class="col-lg-9">
                        Chart
                        <div class="chart mt-n6">
                            <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <p class="mb-0">Report</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row my-4">
        <div class="col-lg-12">
            <div class="card shadow-xs border">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Historical Log</h6>
                            <p class="text-sm mb-sm-0 mb-2">These are details about historical log.</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-white mb-0 me-2">
                                View report
                            </button>
                        </div>
                    </div>
                    <div class="pb-3 d-sm-flex align-items-center">
                        <div class="input-group w-sm-25 ms-auto">
                            <span class="input-group-text text-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="historical_log" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Created At</th>
                                @foreach ($parameters as $parameter)
                                    <th>{{ $parameter->name }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

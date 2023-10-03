@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $dashboard->dashboard_name }}</h3>
                    <p class="mb-0">{{ $dashboard->description }}</p>
                </div>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center ms-md-auto  mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#exportDashboardModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-file-excel"></i>
                    </span>
                    <span class="btn-inner--text">Export Dashboard</span>
                </button>
                {{-- modal --}}
                <div class="modal fade" id="exportDashboardModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Export Dashboard
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
                                        <label for="dashboard-name" class="col-form-label">Choose Range:</label>
                                        <input type="text" name="datetimerange" id="datetimerange" value=""
                                            class="form-control">
                                    </div>
                                    <input type="number" name="dashboard_id" value="{{ $dashboard->id }}" hidden>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" value="Submit" name="export" formmethod="get"
                                        formaction="/export/dashboard" formtarget="_blank"
                                        class="btn btn-success">Export</button>
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
                                        <h6 class="font-weight-semibold text-lg mb-0">{{ $panel->panel_name }} <span
                                                id="alert-parameter-{{ $panel->parameter->id }}"></h6>
                                    </div>
                                    <div class="ms-auto d-flex">
                                        <a href="{{ url('/dashboard/parameter/' . $panel->parameter->id) }}" type="button"
                                            class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                                            <span class="btn-inner--icon">
                                                <i class="fa-solid fa-external-link-alt"></i>
                                            </span>
                                        </a>
                                    </div>
                                    <!-- Modal -->
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
                                    </div>
                                    <!-- Modal -->
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

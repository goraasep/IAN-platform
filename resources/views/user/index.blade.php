@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">Dashboard List</h3>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row mt-4">
        @if (sizeof($dashboards) <= 0)
            <h3 class="col-12 text-center opacity-5">No dashboard available.</h3>
        @else
            @foreach ($dashboards as $dashboard)
                <div class="col-md-3 mb-3">
                    <div class="card border shadow-xs mb-4 h-100">
                        <div class="full-background bg-primary opacity-3 p-auto"></div>
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">{{ $dashboard->dashboard_name }}</h6>
                                </div>
                                <div class="ms-auto d-flex">
                                    <a href="{{ url('dashboard/' . $dashboard->id) }}" type="button"
                                        class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                                        <span class="btn-inner--icon">
                                            <i class="fa-solid fa-external-link-alt"></i>
                                        </span>
                                    </a>
                                </div>
                                <!-- Modal -->
                            </div>
                        </div>
                        <div class="card-body text-start p-3 w-100">
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p>{{ $dashboard->description }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

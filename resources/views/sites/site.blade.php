@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $site->name }}</h3>
                    <p class="mb-0">{{ $site->description }}</p>
                </div>
                <a href="/sites/" type="button"
                    class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Sites List</span>

                </a>
                <a href="/sites/{{ $site->slug }}/edit" type="button"
                    class=" btn btn-sm btn-white btn-icon d-flex align-items-center mb-0">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-gear d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Site Configuration</span>

                </a>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row my-4 d-flex justify-content-center">
        <div class="col-lg-4 d-flex justify-content-center"><img src="{{ asset('storage/images/' . $site->image) }}"
                alt="" style="height:auto;width:auto;max-height:400px;max-width:400px" alt=""
                onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';"></div>
        <div class="col-lg-4">
            <div id="map" style="max-height:400px"></div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-xs border" style="height: 400px">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Active alerts</h6>
                            <p class="text-sm mb-sm-0 mb-2">These are details about ongoing alerts</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0 overflow-auto">
                    <div class="table-responsive p-0  ">
                        <table class="table align-items-center justify-content-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 text-center">Parameter
                                    </th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 text-center">Alert
                                    </th>
                                    {{-- <th class="text-secondary text-xs font-weight-semibold opacity-7 text-center">Created At
                                    </th> --}}
                                </tr>
                            </thead>
                            @livewire('alert-list', ['site' => $site])
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <p class="mb-0">Overview</p>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    {{-- @livewire('overview-site', ['site' => $site]) --}}
    <div class="row mt-4">
        @if (!$site->devices->count())
            <h3 class="col-12 text-center opacity-5">No data available.</h3>
        @else
            @foreach ($site->devices as $device)
                @foreach ($device->parameters as $parameter)
                    @if ($parameter->show)
                        <div class="col-xl-2 col-sm-3 mb-xl-0">
                            <div class="card border shadow-xs mb-4">
                                <div class="full-background bg-primary opacity-3 p-auto"></div>
                                <div class="card-body text-start p-3 w-100">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="w-100">
                                                <a class="text-primary font-weight-bold text-sm text-uppercase"
                                                    href="{{ url('devices/' . $device->uuid) }}">{{ $device->name }}</a>
                                                <h5 class="font-weight-semibold text-lg mb-0">{{ $parameter->name }}
                                                </h5>
                                                <p class="text-sm text-secondary mb-1">Actual value:</p>
                                                <h4 class="mb-2 font-weight-bold">
                                                    <span id="live_{{ $parameter->slug }}"><i
                                                            class="text-warning fa-solid fa-exclamation"></i> </span>
                                                </h4>
                                                <div class="d-flex align-items-center">
                                                    <span class="text-sm">Last Updated: <span
                                                            id="updated_{{ $parameter->slug }}"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endforeach
        @endif
    </div>
@endsection

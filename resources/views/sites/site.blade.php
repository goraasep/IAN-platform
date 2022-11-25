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
        <img src="{{ asset('storage/images/' . $site->image) }}" class="col-lg-6 mx-auto" alt=""
            style="height:auto;width:auto;max-height:400px" alt=""
            onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';">
        <div class="col-lg-6">
            <div id="map" style="max-height:400px"></div>
        </div>
        {{-- ../assets/img/img-2.jpg --}}
        {{-- <img id="device_image" src="{{ asset('storage/images/' . $device->image) }}" class="col-lg-6"
            style="height:auto;width:auto;max-height:400px" alt=""
            onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';"> --}}
    </div>
    <div class="row mt-4">
        @for ($i = 0; $i < 12; $i++)
            <div class="col-xl-2 col-sm-3 mb-xl-0">
                <div class="card border shadow-xs mb-4">
                    <div class="full-background bg-primary opacity-3 p-auto"></div>
                    <div class="card-body text-start p-3 w-100">
                        <div class="row">
                            <div class="col-12">
                                <div class="w-100">
                                    <p class="text-primary font-weight-bold text-sm text-uppercase">KWH METER</p>
                                    <h5 class="font-weight-semibold text-lg mb-0">VOLTAGE R
                                    </h5>
                                    <p class="text-sm text-secondary mb-1">Actual value:</p>
                                    <h4 class="mb-2 font-weight-bold">
                                        <span id="live_">55 <i class="text-warning fa-solid fa-exclamation"></i> </span>
                                    </h4>
                                    <div class="d-flex align-items-center">
                                        <span class="text-sm">Last Updated: <span id="previous_">22-22-2222
                                                22:22:22</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endsection

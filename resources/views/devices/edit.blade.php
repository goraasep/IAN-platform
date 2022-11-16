@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $device->name }}</h3>
                    <p class="mb-0">{{ $device->description }}</p>
                </div>
                <a href="/devices/{{ $device->uuid }}" type="button"
                    class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Device</span>

                </a>
                <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                    <span class="btn-inner--icon">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>
                    <span class="btn-inner--text">Refresh</span>
                </button>
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
        <div class="col-12">
            <div class="card shadow-xs border">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Configuration</h6>
                            <p class="text-sm mb-sm-0 mb-2">Use this form to change device details.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="m-3">
                        <form action="/devices/{{ $device->uuid }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="device-name" class="col-form-label">Device Name:</label>
                                <input type="text" class="form-control" id="device-name" name="name"
                                    value="{{ old('name', $device->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="device-description" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="device-description" name="description">{{ old('description', $device->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="device-image">Image</label>
                                <input type="file" class="form-control" id="device-image" name="image">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

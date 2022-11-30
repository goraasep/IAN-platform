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
                {{-- <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                    <span class="btn-inner--icon">
                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </span>
                    <span class="btn-inner--text">Refresh</span>
                </button> --}}
                <div class="d-flex">
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-icon mb-0 me-2" data-bs-toggle="modal"
                        data-bs-target="#addParamModal">
                        <span class="btn-inner--icon me-2">
                            <i class="fa-solid fa-trash"></i>
                        </span>
                        <span class="btn-inner--text">Delete Device</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="addParamModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" action="/devices/{{ $device->uuid }}">
                                    @method('delete')
                                    @csrf
                                    <input type="text" class="form-control" id="device-uuid" name="uuid"
                                        value="{{ $device->uuid }}" hidden required>
                                    <div class="modal-header">
                                        <h6 class="modal-title" id="modal-title-notification">Your attention is required
                                        </h6>
                                        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="py-3 text-center">
                                            <i class="ni ni-bell-55 ni-3x"></i>
                                            <h4 class="text-gradient text-danger mt-4">Delete {{ $device->name }} ?</h4>
                                            <p>You will not be able to restore deleted device.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-dark">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    <div class="row my-4 d-flex justify-content-center">
        <img src="{{ asset('storage/images/' . $device->image) }}" class="col-lg-6" alt=""
            style="height:auto;width:auto;max-height:400px" alt=""
            onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';">
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
                                <label for="device-site">Assign to site: </label>
                                <select class="form-control" id="device-site" name="site_id">
                                    <option value="">None</option>
                                    @foreach ($sites as $site)
                                        <option value="{{ $site->id }}"
                                            {{ old('site_id', $device->site_id) == $site->id ? 'selected' : '' }}>
                                            {{ $site->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="device-image">Image</label>
                                <input type="file" class="form-control" id="device-image" name="image">
                            </div>
                            <button type="submit" class="btn btn-dark mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

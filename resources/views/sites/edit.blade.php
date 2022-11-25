@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $site->name }}</h3>
                    <p class="mb-0">{{ $site->description }}</p>
                </div>
                <a href="/sites/{{ $site->slug }}" type="button"
                    class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Site</span>

                </a>
                <div class="d-flex">
                    <button type="button" class="btn btn-sm  btn-outline-danger btn-icon mb-0 me-2" data-bs-toggle="modal"
                        data-bs-target="#deleteSiteModal">
                        <span class="btn-inner--icon me-2">
                            <i class="fa-solid fa-trash"></i>
                        </span>
                        <span class="btn-inner--text">Delete Site</span>
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="deleteSiteModal" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form method="post" action="/sites/{{ $site->slug }}">
                                    @method('delete')
                                    @csrf
                                    <input type="text" class="form-control" id="site-slug" name="slug"
                                        value="{{ $site->slug }}" hidden required>
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
                                            <h4 class="text-gradient text-danger mt-4">Delete {{ $site->name }} ?</h4>
                                            <p>You will not be able to restore deleted site.
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
        <img src="{{ asset('storage/images/' . $site->image) }}" class="col-lg-6 mx-auto" alt=""
            style="height:auto;width:auto;max-height:400px" alt=""
            onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';">
        <div class="col-lg-6">
            <div id="map" style="max-height:400px"></div>
        </div>
        {{-- <img src="{{ asset('storage/images/' . $device->image) }}" class="col-lg-6" alt=""
            style="height:auto;width:auto;max-height:400px" alt=""
            onerror="this.onerror=null;this.src='/assets/img/img-2.jpg';"> --}}
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
                        <form action="/sites/{{ $site->slug }}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="form-group">
                                <label for="site-name" class="col-form-label">Site Name:</label>
                                <input type="text" class="form-control" id="site-name" name="name"
                                    value="{{ old('name', $site->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="site-description" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="site-description" name="description">{{ old('description', $site->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="site-longitude" class="col-form-label">Longitude:</label>
                                <input type="number" step="any" class="form-control" id="site-longitude"
                                    name="lng" value="{{ old('lng', $site->lng) }}">
                                @error('lng')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="site-latitude" class="col-form-label">Latitude:</label>
                                <input type="number" step="any" class="form-control" id="site-latitude"
                                    name="lat" value="{{ old('lat', $site->lat) }}">
                                @error('lat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="site-image">Image</label>
                                <input type="file" class="form-control" id="site-image" name="image">
                            </div>
                            <button type="submit" class="btn btn-dark mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

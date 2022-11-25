@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Sites list</h6>
                            <p class="text-sm">See information about all sites</p>
                        </div>
                        <div class="ms-auto d-flex">
                            {{-- <button type="button" class="btn btn-sm btn-white me-2">
                                View all
                            </button> --}}
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add Site</span>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/sites" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new site
                                                </h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mx-4">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="site-name" class="col-form-label">Site Name:</label>
                                                    <input type="text" class="form-control" id="site-name" name="name"
                                                        value="{{ old('name') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="site-description"
                                                        class="col-form-label">Description:</label>
                                                    <textarea class="form-control" id="site-description" name="description">{{ old('description') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="site-longitude" class="col-form-label">Longitude:</label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="site-longitude" name="lng" value="{{ old('longitude') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="site-latitude" class="col-form-label">Latitude:</label>
                                                    <input type="number" step="any" class="form-control"
                                                        id="site-latitude" name="lat" value="{{ old('latitude') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-form-label" for="device-image">Image</label>
                                                    <input type="file" class="form-control" id="device-image"
                                                        name="image">
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
                    <table id="site_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Site</th>
                                <th>Address</th>
                                <th>Coordinate</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        {{-- <tfoot>
                            <tr>
                                <th>Device</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th></th>
                            </tr>
                        </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Devices list</h6>
                            <p class="text-sm">See information about all devices</p>
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
                                <span class="btn-inner--text">Add Device</span>
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/devices" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new device
                                                </h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="device-name" class="col-form-label">Device Name:</label>
                                                    <input type="text" class="form-control" id="device-name"
                                                        name="name" value="{{ old('name') }}">
                                                    @error('description')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="device-description"
                                                        class="col-form-label">Description:</label>
                                                    <textarea class="form-control" id="device-description" name="description" required>{{ old('description') }}</textarea>
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
                                                                {{ old('site_id') == $site->id ? 'selected' : '' }}>
                                                                {{ $site->name }}</option>
                                                        @endforeach
                                                    </select>
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
                    <table id="device_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Device</th>
                                <th>Status</th>
                                <th>Created At</th>
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

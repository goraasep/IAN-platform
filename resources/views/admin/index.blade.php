@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">Hello, Admin</h3>
                    <p class="mb-0">Use this panel to manage your dashboards and parameters!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Dashboard list</h6>
                            <p class="text-sm">See information about all devices</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#addDashboardModal">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add Dashboard</span>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addDashboardModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/admin-panel/dashboard">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new Dashboard
                                                </h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="dashboard-name" class="col-form-label">Dashboard
                                                        Name:</label>
                                                    <input type="text" class="form-control" id="dashboard-name"
                                                        name="dashboard_name" value="{{ old('dashboard_name') }}">
                                                    @error('dashboard_name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="dashboard-description"
                                                        class="col-form-label">Description:</label>
                                                    <textarea class="form-control" id="dashboard-description" name="description" required>{{ old('description') }}</textarea>
                                                    @error('description')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
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
                    <table id="dashboard_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Dashboard</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Action</th>
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
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Parameter list</h6>
                            <p class="text-sm">See information about all parameters</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add Parameter</span>
                            </button>
                            <!-- Modal -->
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="parameter_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Unit</th>
                                <th>High Threshold</th>
                                <th>High Threshold Enable</th>
                                <th>Low Threshold</th>
                                <th>Low Threshold Enable</th>
                                <th>Max Value</th>
                                <th>Min Value</th>
                                <th>Created At</th>
                                <th>Action</th>
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
        <div class="col-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">User list</h6>
                            <p class="text-sm">See information about all users</p>
                        </div>
                        <div class="ms-auto d-flex">
                            <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add User</span>
                            </button>
                            <!-- Modal -->
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="user_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Dashboard Access</th>
                                <th>Created At</th>
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
@endsection

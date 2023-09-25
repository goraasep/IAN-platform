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
                                            <div class="modal-body mx-3">
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
                                data-bs-toggle="modal" data-bs-target="#addParameterModal">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add Parameter</span>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addParameterModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/admin-panel/parameter">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new Parameter
                                                </h5>
                                                <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mx-3">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="parameter-name" class="col-form-label">Parameter
                                                        Name:</label>
                                                    <input type="text" class="form-control" id="parameter-name"
                                                        name="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label for="type" class="col-form-label">Type:</label>
                                                        <select class="form-control" id="type" name="type">
                                                            <option value="number"
                                                                {{ old('type') == 'number' ? 'selected' : '' }}>
                                                                Number</option>
                                                            <option value="string"
                                                                {{ old('type') == 'string' ? 'selected' : '' }}>String
                                                            </option>
                                                        </select>
                                                        @error('type')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col">
                                                        <label for="unit" class="col-form-label">Unit:</label>
                                                        <input type="text" class="form-control" id="unit"
                                                            name="unit" value="{{ old('unit') }}">
                                                        @error('unit')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label for="max" class="col-form-label">Max Value:</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="max" name="max" value="{{ old('max', 0) }}">
                                                        @error('max')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col">
                                                        <label for="max" class="col-form-label">Min Value:</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="min" name="min" value="{{ old('min', 0) }}">
                                                        @error('min')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label for="th_H_enable" class="col-form-label">Enable Threshold
                                                            High:</label>
                                                        <select class="form-control" id="th_H_enable" name="th_H_enable">
                                                            <option value="1"
                                                                {{ old('th_H_enable') == '1' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="0"
                                                                {{ old('th_H_enable') == '0' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                        @error('th_H_enable')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col">
                                                        <label for="th_H" class="col-form-label">Threshold
                                                            High:</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="th_H" name="th_H" value="{{ old('th_H', 0) }}">
                                                        @error('th_H')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label for="th_L_enable" class="col-form-label">Enable Threshold
                                                            Low:</label>
                                                        <select class="form-control" id="th_L_enable" name="th_L_enable">
                                                            <option value="1"
                                                                {{ old('th_L_enable') == '1' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="0"
                                                                {{ old('th_L_enable') == '0' ? 'selected' : '' }}>No
                                                            </option>
                                                        </select>
                                                        @error('th_L_enable')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col">
                                                        <label for="th_L" class="col-form-label">Threshold
                                                            Low:</label>
                                                        <input type="number" step="any" class="form-control"
                                                            id="th_L" name="th_L" value="{{ old('th_L', 0) }}">
                                                        @error('th_L')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label for="log_enable" class="col-form-label">Enable Log:</label>
                                                        <select class="form-control" id="log_enable" name="log_enable">
                                                            <option value="1"
                                                                {{ old('log_enable') == '1' ? 'selected' : '' }}>
                                                                Yes</option>
                                                            <option value="0"
                                                                {{ old('log_enable') == '0' ? 'selected' : '' }}>
                                                                No
                                                            </option>
                                                        </select>
                                                        @error('log_enable')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col">
                                                        <label for="log_interval" class="col-form-label">Log
                                                            Interval (second):</label>
                                                        <input type="number" step="none" min="1"
                                                            class="form-control" id="log_interval" name="log_interval"
                                                            value="{{ old('log_interval', 1) }}">
                                                        @error('log_interval')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
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
                                data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <span class="btn-inner--icon me-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                                <span class="btn-inner--text">Add User</span>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form method="post" action="/admin-panel/user">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new User
                                                </h5>
                                                <button type="button" class="btn-close text-dark"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">×</span>
                                                </button>
                                            </div>
                                            <div class="modal-body mx-3">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="user-name" class="col-form-label">Name:</label>
                                                    <input type="text" class="form-control" id="user-name"
                                                        name="name" value="{{ old('name') }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="user-email" class="col-form-label">Email:</label>
                                                    <input type="text" class="form-control" id="user-email"
                                                        name="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="user-password" class="col-form-label">Password:</label>
                                                    <input type="password" class="form-control" id="user-password"
                                                        name="password" value="{{ old('password') }}">
                                                    @error('password')
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
                    <table id="user_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
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
@endsection

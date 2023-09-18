@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $user->name }}</h3>
                    <p class="mb-0">Identifier: {{ $user->id }}</p>
                </div>
                <a href="/admin-panel" type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-0 ms-md-auto mb-md-0 mb-2 me-md-2">
                    <span class="btn-inner--icon">
                        <i class="fa-solid fa-arrow-left d-md-flex ms-auto me-2"></i>
                    </span>
                    <span class="btn-inner--text">Back to Admin Panel</span>
                </a>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#addAccessModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="btn-inner--text">Add Dashboard Access</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-cog"></i>
                    </span>
                    <span class="btn-inner--text">Change Password</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-icon btn-outline-danger d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                    data-bs-toggle="modal" data-bs-target="#deleteUserModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                    <span class="btn-inner--text">Delete User</span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="addAccessModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/access">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Dashboard Access
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    <input type="number" name="user_id" value="{{ $user->id }}" hidden>
                                    <div class="form-group">
                                        <label for="dashboard_id" class="col-form-label">Dashboard:</label>
                                        <select class="form-control" id="dashboard_id" name="dashboard_id" required>
                                            @foreach ($dashboards as $dashboard)
                                                <option value="{{ $dashboard->id }}">
                                                    {{ $dashboard->dashboard_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('dashboard_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/user/{{ $user->id }}">
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Change Password
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    <div class="form-group">
                                        <label for="user-password" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" id="user-password" name="password"
                                            value="{{ old('password') }}">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-dark">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/user/{{ $user->id }}">
                                @method('DELETE')
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete User
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    <h5>Are you sure you want
                                        to delete user {{ $user->name }} ?</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-0">
    {{-- <div class="row mt-4">
        <h3 class="col-12 text-center opacity-5">No data available.</h3>
    </div> --}}


    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card border shadow-xs mb-4">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center">
                        <div>
                            <h6 class="font-weight-semibold text-lg">Access Rights</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="access_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Dashboard</th>
                                <th>Description</th>
                                <th>Created At</th>
                                <th>Delete Access</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
    </div>
@endsection

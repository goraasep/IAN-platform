@extends('layouts.main')
@section('container')
    <div class="row">
        <div class="col-md-12">
            <div class="d-md-flex align-items-center mb-3 mx-2">
                <div class="mb-md-0 mb-3">
                    <h3 class="font-weight-bold mb-0">{{ $connection->broker_address }}:{{ $connection->port }}</h3>
                    <p class="mb-0">Client ID: {{ $connection->client_id }}</p>
                    {{-- <p class="mb-0"><span id="conn_status"
                            class="badge {{ $connection->status == 'Connected' ? 'bg-gradient-success' : 'bg-gradient-danger' }} ">{{ $connection->status }}</span>
                    </p> --}}
                    <p class="mb-0"><span id="conn_status"></span></p>
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
                    data-bs-toggle="modal" data-bs-target="#addTopicModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-plus"></i>
                    </span>
                    <span class="btn-inner--text">Add Topic</span>
                </button>
                <button type="button"
                    class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2"
                    data-bs-toggle="modal" data-bs-target="#connectionSettingModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-cog"></i>
                    </span>
                    <span class="btn-inner--text">Connection Setting</span>
                </button>
                {{-- <button type="submit" value="Submit" name="export" formmethod="get"
                                        formaction="/admin-panel/export/dashboard" formtarget="_blank"
                                        class="btn btn-success">Export</button> --}}
                <form action="">
                    @csrf
                    <button type="submit" value="Submit" name="reconnect" formmethod="post"
                        formaction="/admin-panel/connection/{{ $connection->id }}/reconnect"
                        class="btn btn-sm btn-white btn-icon d-md-flex align-items-center mb-md-0 mb-2 mb-0 me-md-2">
                        <span class="btn-inner--icon me-2">
                            <i class="fa-solid fa-sync-alt"></i>
                        </span>
                        <span class="btn-inner--text">Reconnect</span>
                    </button>
                </form>
                <button type="button"
                    class="btn btn-sm btn-icon btn-outline-danger d-md-flex align-items-center mb-md-0 mb-2 mb-0"
                    data-bs-toggle="modal" data-bs-target="#deleteConnectionModal">
                    <span class="btn-inner--icon me-2">
                        <i class="fa-solid fa-trash"></i>
                    </span>
                    <span class="btn-inner--text">Delete Connection</span>
                </button>
                <!-- Modal -->
                <div class="modal fade" id="addTopicModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/topic">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Topic
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    <input type="number" name="connection_id" value="{{ $connection->id }}" hidden>
                                    <div class="form-group">
                                        <label for="conn-topic" class="col-form-label">Topic:</label>
                                        <input type="text" class="form-control" id="conn-topic" name="topic"
                                            value="{{ old('topic') }}">
                                        @error('topic')
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
                <div class="modal fade" id="connectionSettingModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/connection/{{ $connection->id }}">
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Connection Setting
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    @csrf
                                    <div class="form-group">
                                        <label for="conn-address" class="col-form-label">Broker
                                            Address:</label>
                                        <input type="text" class="form-control" id="conn-address"
                                            name="broker_address"
                                            value="{{ old('broker_address', $connection->broker_address) }}">
                                        @error('broker_address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="conn-port" class="col-form-label">Port:</label>
                                        <input type="number" class="form-control" id="conn-port" name="port"
                                            value="{{ old('port', $connection->port) }}">
                                        @error('port')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="conn-username" class="col-form-label">Username:</label>
                                        <input type="text" class="form-control" id="conn-username" name="username"
                                            value="{{ old('username', $connection->username) }}">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="conn-password" class="col-form-label">Password:</label>
                                        <input type="password" class="form-control" id="conn-password" name="password"
                                            value="{{ old('password', $connection->password) }}">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="conn-client-id" class="col-form-label">Client ID:</label>
                                        <input type="text" class="form-control" id="conn-client-id" name="client_id"
                                            value="{{ old('client_id', $connection->client_id) }}">
                                        @error('client_id')
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
                <div class="modal fade" id="deleteConnectionModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form method="post" action="/admin-panel/connection/{{ $connection->id }}">
                                @method('DELETE')
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Delete Connection
                                    </h5>
                                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    <h5>Are you sure you want
                                        to delete broker {{ $connection->broker_address }} ?</h5>
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
                            <h6 class="font-weight-semibold text-lg">Topics</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="topic_list" class="display text-center" style="width:100%">
                        <thead>
                            <tr>
                                <th>Topic</th>
                                <th>Last Received</th>
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

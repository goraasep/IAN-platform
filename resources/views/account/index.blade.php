@extends('layouts.main')
@section('container')
    <div class="row my-4">
        <div class="col-12">
            <div class="card shadow-xs border">
                <div class="card-header border-bottom pb-0">
                    <div class="d-sm-flex align-items-center mb-3">
                        <div>
                            <h6 class="font-weight-semibold text-lg mb-0">Account Setting</h6>
                            <p class="text-sm mb-sm-0 mb-2">Use this form to change password.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 py-0">
                    @if (session('status'))
                        <div class="alert alert-success m-3" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger m-3" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <div class="m-3">
                        <form action="/update_password" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="password" class="col-form-label">Current Password:</label>
                                <input type="password" class="form-control @error('old_password') is-invalid @enderror"
                                    id="password" name="old_password" value="{{ old('old_password') }}">
                                @error('old_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="new-password" class="col-form-label">New Password:</label>
                                <input type="password" class="form-control" id="new-password" name="new_password"
                                    value="{{ old('new_password') }}">
                            </div>
                            <div class="form-group">
                                <label for="confirm-password" class="col-form-label">Confirm Password:</label>
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="confirm-password" name="new_password_confirmation"
                                    value="{{ old('new_password_confirmation') }}">
                                @error('new_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-dark mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

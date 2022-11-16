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
                            <button type="button" class="btn btn-sm btn-white me-2">
                                View all
                            </button>
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
                                                </div>
                                                <div class="form-group">
                                                    <label for="device-description"
                                                        class="col-form-label">Description:</label>
                                                    <textarea class="form-control" id="device-description" name="description">{{ old('description') }}</textarea>
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
                <div class="card-body px-0 py-0">
                    <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable1"
                                autocomplete="off" checked>
                            <label class="btn btn-white px-3 mb-0" for="btnradiotable1">All</label>
                            <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable2"
                                autocomplete="off">
                            <label class="btn btn-white px-3 mb-0" for="btnradiotable2">Monitored</label>
                            <input type="radio" class="btn-check" name="btnradiotable" id="btnradiotable3"
                                autocomplete="off">
                            <label class="btn btn-white px-3 mb-0" for="btnradiotable3">Unmonitored</label>
                        </div>
                        <form action="/devices" class="input-group w-sm-25 ms-auto">
                            <span class="input-group-text text-body">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                    </path>
                                </svg>
                            </span>
                            <input type="text" class="form-control" placeholder="Search" name="search"
                                value="{{ request('search') }}">
                        </form>
                    </div>
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">Site</th>
                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Location
                                    </th>
                                    {{-- <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Status
                                    </th> --}}
                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">
                                        Created At</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($sites->count())
                                    @foreach ($sites as $site)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex align-items-center">
                                                        <img src="data:image/png;base64,{{ chunk_split(base64_encode($site->image)) }}"
                                                            class="avatar avatar-sm rounded-circle me-2" alt="user1">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center ms-1">
                                                        <h6 class="mb-0 text-sm font-weight-semibold">{{ $site->name }}
                                                        </h6>
                                                        <p class="text-sm text-secondary mb-0">
                                                            {{ Str::limit($site->description, 20, '...') }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Longitude :
                                                    {{ $site->lon }}</p>
                                                <p class="text-sm text-secondary mb-0">Latitude : {{ $site->lat }}</p>
                                            </td>
                                            {{-- <td class="align-middle text-center text-sm">
                                                <span
                                                    class="badge badge-sm border border-success text-success bg-success">Online</span>
                                            </td> --}}
                                            <td class="align-middle text-center">
                                                <span
                                                    class="text-secondary text-sm font-weight-normal">{{ $device->created_at }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="tooltip" data-bs-title="Edit user">
                                                    <svg width="14" height="14" viewBox="0 0 15 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z"
                                                            fill="#64748B" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="4">Data Not Found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @if ($sites->hasPages())
                        <div class="border-top py-3 px-3 d-flex align-items-center">
                            <div class="ms-auto"> {{ $sites->links() }}</div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection

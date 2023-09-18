<button type="button" class="btn btn-sm btn-dark btn-icon my-auto" data-bs-toggle="modal"
    data-bs-target="#deleteAccessModal-{{ $access_id }}">
    <span class="btn-inner--icon me-2">
        <i class="fa-solid fa-plus"></i>
    </span>
    <span class="btn-inner--text">Delete</span>
</button>
{{-- modal --}}

<div class="modal fade" id="deleteAccessModal-{{ $access_id }}" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="/admin-panel/access/{{ $access_id }}">
                @method('DELETE')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Access
                    </h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <h5>Are you sure you want
                        to delete access to dashboard {{ $dashboard_name }} ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

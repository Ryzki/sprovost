@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
@endprepend


@section('content')
    {{-- Title --}}
    <!-- STAT -->

    <!-- DataTable list pelanggar -->
    <div class="row">
        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
            <h5 class="mb-0 pb-1 text-decoration-underline">Provos Role</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">Roles</h5>
                {{-- <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#add_user"><i class="ri-add-line align-bottom me-1"></i>Add User</button>
                </div> --}}
            </div>

            <div class="card-body">
                @include('partials.message')
                <div class="table-responsive table-card px-3" style="min-height: 500px;">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $index => $role)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm btn-warning dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                                {{-- <i class="fa-sharp fa-regular fa-screwdriver-wrench"></i> --}}
                                                <i class="fas fa-cogs"></i> Setting
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="/role/permission/{{ $role->id }}"><i
                                                        class="bx bx-edit-alt me-1"></i> Set Permission</a>
                                                <a class="dropdown-item" href="/manage/roles/delete/{{ $role->id }}"><i
                                                        class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Buat User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/user/save" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Name</label>
                            <input autocomplete="off"  type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Username</label>
                            <input autocomplete="off"  type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Jabatan</label>
                            <input autocomplete="off"  type="text" class="form-control" name="jabatan">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input autocomplete="off"  type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Role</label>
                            <select class="form-select" aria-label="Default select example" name="role">
                                <option selected>Open this select menu</option>
                                @foreach ($roles as $value)
                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection

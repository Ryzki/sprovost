@extends('partials.master')

@prepend('styles')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .password-meter {
            display: flex;
            height: 5px;
            margin-top: 10px;
        }

        .meter-section {
            flex: 1;
            background-color: #ddd;
        }

        .weak {
            background-color: #ff4d4d;
        }

        .medium {
            background-color: #ffd633;
        }

        .strong {
            background-color: #00b300;
        }

        .very-strong {
            background-color: #009900;
        }
    </style>
@endprepend


@section('content')
    {{-- Title --}}
    <!-- STAT -->

    <!-- DataTable list pelanggar -->
    <div class="row">
        <div class="justify-content-between d-flex align-items-center mt-3 mb-4">
            <h5 class="mb-0 pb-1 text-decoration-underline">Provos User</h5>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title flex-grow-1 mb-0">User</h5>
                <div class="d-flex gap-1 flex-wrap">
                    <button type="button" class="btn btn-success create-btn" data-bs-toggle="modal"
                        data-bs-target="#add_user"><i class="ri-add-line align-bottom me-1"></i>Add User</button>
                </div>
            </div>

            <div class="card-body">
                @include('partials.message')
                <div class="table-responsive table-card px-3">
                    <table class="table table-centered align-middle table-nowrap mb-0" id="data-data">
                        <thead class="text-muted table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index => $user)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->getRoleNames()[0] }}</td>
                                    <td>
                                        <a href="http://"><button class="btn btn-sm btn-danger">Reset Password</button></a>
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
                            <input autocomplete="off" type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Username</label>
                            <input autocomplete="off" type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Jabatan</label>
                            <input autocomplete="off" type="text" class="form-control" name="jabatan">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Password</label>
                            <input autocomplete="off" type="password" class="form-control" name="password" id="password-input" required>
                            <div class="password-meter">
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded me-2"></div>
                                <div class="meter-section rounded"></div>
                            </div>
                            <div id="passwordHelp" class="form-text text-muted">Password harus 8 atau lebih karakter dengan kombinasi huruf, angka, dan karakter khusus (#, @, dll)
                            </div>
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
                        <button type="submit" class="btn btn-primary" id="save" disabled>Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const passwordInput = document.getElementById('password-input');
const meterSections = document.querySelectorAll('.meter-section');

passwordInput.addEventListener('input', updateMeter);

function updateMeter() {
    const password = passwordInput.value;
    let strength = calculatePasswordStrength(password);

    // Remove all strength classes
    meterSections.forEach((section) => {
        section.classList.remove('weak', 'medium', 'strong', 'very-strong');
    });

    // Add the appropriate strength class based on the strength value
    if (strength >= 1) {
        meterSections[0].classList.add('weak');
        $('#save').prop('disabled','disabled')
    }
    if (strength >= 2) {
        meterSections[1].classList.add('medium');
        $('#save').prop('disabled','disabled')
    }
    if (strength >= 3) {
        meterSections[2].classList.add('strong');
        $('#save').removeAttr('disabled')
    }
    if (strength >= 4) {
        meterSections[3].classList.add('very-strong');
        $('#save').removeAttr('disabled')
    }
}

function calculatePasswordStrength(password) {
    const lengthWeight = 0.2;
    const uppercaseWeight = 0.5;
    const lowercaseWeight = 0.5;
    const numberWeight = 0.7;
    const symbolWeight = 1;

    let strength = 0;

    // Calculate the strength based on the password length
    strength += password.length * lengthWeight;

    // Calculate the strength based on uppercase letters
    if (/[A-Z]/.test(password)) {
        strength += uppercaseWeight;
    }

    // Calculate the strength based on lowercase letters
    if (/[a-z]/.test(password)) {
        strength += lowercaseWeight;
    }

    // Calculate the strength based on numbers
    if (/\d/.test(password)) {
        strength += numberWeight;
    }

    // Calculate the strength based on symbols
    if (/[^A-Za-z0-9]/.test(password)) {
        strength += symbolWeight;
    }

    return strength;
}
</script>
@endsection

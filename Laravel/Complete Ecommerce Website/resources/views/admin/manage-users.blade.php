@extends('admin.layouts.app')

@section('content')

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/dashboard.js') }}"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            transition: margin-left 0.3s;
            margin-top: 6%;
            margin-left: 20px;
            margin-right: 20px;
        }

        .table {
            margin: 20px 0;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            background-color: white;
            text-align: center;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .modal-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
        }

        .modal-footer .btn {
            margin: 0 5px;
        }

        .modal-body {
            padding: 20px;
            border: 1px solid #007bff;
            border-radius: 0.5rem;
            background-color: #f9f9f9;
        }

        .modal-body div {
            margin-bottom: 15px;
        }

        .modal-body strong {
            color: #007bff;
        }

        .modal-body img {
            border-radius: 8px;
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .modal-dialog {
            max-width: 800px;
        }

        .row {
            padding: 10px;
        }

        .border-bottom {
            border-bottom: 1px solid #007bff;
        }

        .border-right {
            border-right: 1px solid #007bff;
        }

        .choti-width {
            width: 50px;
        }

        .modal-body .col-md-6 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .modal-body .col-md-4 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .modal-body img {
            border-radius: 8px;
            width: 250px;
            height: 200px;
            object-fit: cover;
            display: flex;
        }
    </style>
</head>

<body>

    <div class="w3-main" style="margin-top: 100px;">
        <div class="table-container">
            @if(session('message'))
            <div id="message" class="alert alert-success">{{ session('message') }}</div>
            @elseif(session('error'))
            <div id="message" class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="{{ route('manageusers') }}" method="get" class="d-flex">
                                <input type="text" name="name" value="{{ old('name', $nameQuery) }}" placeholder="Name" class="form-control me-2">
                                <input type="text" name="email" value="{{ old('email', $emailQuery) }}" placeholder="Email" class="form-control me-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                                <button type="button" class="btn btn-outline-secondary ms-2"><a href="{{ route('manageusers') }}" class="text-decoration-none text-reset">Reset</a></button>
                            </form>
                        </div>
                        <div>
                            <a href="{{ url('admin/add-user') }}" class="btn btn-primary">Add User</a>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Country</th>
                        <!-- <th>Details</th> -->
                        <th>Action</th>
                        <th>Attachments</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ optional($user->profile)->phone ?? 'N/A' }}</td>
                        <td>{{ $user->profile->country ?? 'N/A' }}</td>
                        <!-- <td> -->
                        <!-- Details Button Triggering Modal -->
                        <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#userDetailsModal{{ $user->id }}">Details</button>
                        </td> -->
                        <td>
                            <a href="{{ route('edituser', ['encrypted_id' => $user->encrypted_id]) }}" class="btn btn-warning">Edit</a>
                            <button type="button" class="btn btn-danger" onclick="confirmDeactivate({{ $user->id }})">Delete</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFileModal" onclick="setUserId({{ $user->id }})">
                                Upload File
                            </button>

                        </td>
                        <td>
                            @if($user->status == 1 && $user->fileExists)
                            <a href="{{ route('file.download', ['userId' => $user->id, 'fileName' => $user->fileName]) }}" class="btn btn-success" download>Download</a>
                            @elseif($user->status != 1)
                            <span>Status is not active</span>
                            @else
                            <span>No attachments found</span>
                            @endif
                        </td>
                    </tr>


                    <!-- Modal for User Details
                    <div class="modal fade" id="userDetailsModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="userDetailsModalLabel{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userDetailsModalLabel{{ $user->id }}">User Details - {{ $user->name }}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Name:</strong> {{ $user->name }}</div>
                                        <div class="col-md-6"><strong>ID:</strong> {{ $user->id }}</div>
                                        <div class="col-md-6"><strong>Email:</strong> {{ $user->email }}</div>
                                        <div class="col-md-6"><strong>Country:</strong> {{ $user->profile->country ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><strong>State:</strong> {{ $user->profile->state ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Address:</strong> {{ $user->profile->address ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>Phone Number:</strong> {{ $user->profile->phone ?? 'N/A' }}</div>
                                        <div class="col-md-6"><strong>IP Address:</strong> {{ $user->profile->ip_address ?? 'N/A' }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12"><strong>Profile Picture:</strong>
                                            @if($user->pic)
                                            <img src="{{ Storage::url($user->pic->path) }}" alt="User Picture">
                                            @else
                                            N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <!-- Modal for Deletion Confirmation -->
                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <!-- Updated button here with correct onclick handler -->
                                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for file upload -->
                    <div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="fileUploadForm" method="POST" enctype="multipart/form-data" action="{{ route('uploadFile') }}">
                                        @csrf
                                        <input type="file" name="file" id="fileInput" class="form-control" accept=".pdf,.docx,.doc">
                                        <input type="hidden" id="user_id" name="user_id">
                                    </form>
                                    <div id="uploadError" class="text-danger"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" form="fileUploadForm">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="7">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <ul class="pagination pagination-sm">
                    {{ $users->links('pagination::bootstrap-4') }}
                </ul>
            </div>
        </div>
    </div>

    <script>
        function confirmDeactivate(userId) {
            // Attach the correct delete URL to the button
            const deleteButton = document.getElementById('confirmDeleteButton');
            deleteButton.onclick = function() {

                window.location.href = "/admin/deactivate-user/" + userId;
            };

            // Show the confirmation modal
            const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
            deleteModal.show();
        }
    </script>

    <script>
        function setUserId(userId) {
            document.getElementById('user_id').value = userId;
        }
    </script>

    <script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/chartjs/dashboard.js') }}"></script>
</body>
@endsection
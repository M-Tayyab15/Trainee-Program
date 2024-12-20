@extends('admin.layouts.app')

@section('content')

<head>
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
        }

        .modal-footer .btn {
            margin: 0 5px;
        }

        .modal-body {
            border: 1px solid #007bff;
            border-radius: 0.5rem;
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

        strong {
            color: #007bff;
        }

        .choti-width {
            width: 50px;
        }
    </style>
</head>

<body>

    <div class="w3-main">
        <div class="table-container">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="{{ route('products.index') }}" method="GET" class="d-flex">

                                <select name="category_name" class="form-control me-2">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category_name') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>


                                <input type="text" name="product_name" value="{{ request('product_name') }}" placeholder="Product Name" class="form-control me-2">


                                <input type="text" name="price" value="{{ request('price') }}" placeholder="Price" class="form-control me-2">

                                <button type="submit" class="btn btn-primary">Search</button>
                                <button class="btn btn-outline-secondary ms-2">
                                    <a href="{{ route('products.index') }}" class="text-decoration-none text-reset">Reset</a>
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price($)</th>
                        <th>Images</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->pro_id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? 'No Category' }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->images_count }} image(s)</td>
                        <td>
                            <a href="{{ route('products.edit', $product->pro_id) }}" class="btn btn-warning">Edit</a>
                            
                            <button class="btn btn-info" data-toggle="modal" data-target="#uploadImagesModal"
                                data-id="{{ $product->pro_id }}"
                                data-existing-images="{{ $product->images_count }}"
                                data-max-images="{{ 5 - $product->images_count }}">
                                Upload Images
                            </button>


                            <form id="blockForm" action="" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger block-btn" data-toggle="modal" data-target="#confirmationModal" data-action="{{ route('products.destroy', $product->pro_id) }}">
                                    Block
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No products found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>


            <div class="d-flex justify-content-between">
                {{ $products->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

    <!-- Upload Images Modal -->
    <div class="modal fade" id="uploadImagesModal" tabindex="-1" aria-labelledby="uploadImagesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadImagesModalLabel">Upload Product Images</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('products.uploadImages', $product->pro_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <input type="file" name="images[]" multiple>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to block this product?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form id="confirmationForm" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Block</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        // jQuery to open the modal with the correct remaining images info
        $('#uploadImagesModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // The button that triggered the modal
            var productId = button.data('id'); // Extract product ID
            var existingImages = button.data('existing-images'); // Existing images count
            var maxImages = button.data('max-images'); // Remaining images count

            // Set the product ID and the max number of images
            $('#product_id').val(productId);
            $('#max_images').val(maxImages);
            $('#remaining_images').text(maxImages);

            // Disable the file input if no images can be uploaded
            if (maxImages <= 0) {
                $('#images').prop('disabled', true);
                $('#upload_button').prop('disabled', true);
                alert('No more images can be uploaded for this product.');
            } else {
                $('#images').prop('disabled', false);
                $('#upload_button').prop('disabled', false);
            }
        });
    </script>

    <script>
        // jQuery to open the modal and set the correct form action dynamically
        $('.block-btn').on('click', function() {
            var actionUrl = $(this).data('action'); // Get the action URL for the product
            $('#confirmationForm').attr('action', actionUrl); // Set the form's action to the correct URL
        });
    </script>



</body>
@endsection
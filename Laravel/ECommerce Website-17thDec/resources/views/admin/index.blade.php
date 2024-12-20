@extends('admin.layouts.app')

@section('content')
<div class="w3-main">
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
                        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                            <!-- Category Dropdown -->
                            <select name="category_name" class="form-control me-2">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}" {{ request('category_name') == $category->name ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Product Name Input -->
                            <input type="text" name="product_name" value="{{ request('product_name') }}" placeholder="Product Name" class="form-control me-2">

                            <!-- Price Input -->
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

        <!-- Product Table -->
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
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->category_name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->image_count }} image(s)</td>
                        <td>
                            <a href="{{ route('products.edit', $product->pro_id) }}" class="btn btn-warning">Edit</a>
                            <button class="btn btn-info" data-toggle="modal" data-target="#uploadImagesModal"
                                data-id="{{ $product->pro_id }}"
                                data-existing-images="{{ $product->image_count }}"
                                data-max-images="{{ 5 - $product->image_count }}">
                                Upload Images
                            </button>

                            <form action="{{ route('products.destroy', $product->pro_id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Block</button>
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

        <!-- Pagination -->
        <div class="d-flex justify-content-between">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Upload Image Modal -->


@endsection

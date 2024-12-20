@extends('admin.layouts.app')

@section('content')

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="w3-main" style="margin-top: 100px;">
        <div class="container mt-5">
            <h2>Edit Product</h2>

            <!-- Display error messages if validation fails -->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Display success message if product is updated successfully -->
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('products.update', $product->pro_id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" name="product_name" class="form-control" value="{{ old('product_name', $product->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price) }}" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->cat_id }}" {{ $category->cat_id == old('category_id', $product->cat_id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description (optional)</label>
                    <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Popularity Field -->
                <div class="form-group form-check">
                    <input type="checkbox" name="popularity" class="form-check-input" value="1" {{ old('popularity', $product->popularity) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="popularity">Set as Popular</label>
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</body>
@endsection

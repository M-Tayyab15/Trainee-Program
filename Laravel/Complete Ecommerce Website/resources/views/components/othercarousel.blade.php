@foreach (['football', 'cricket', 'tennis', 'hockey', 'badminton'] as $category)
<div class="container-fluid" style="background-color: white;">

    <div id="{{ $category }}Carousel" class="carousel slide product-carousel" data-bs-ride="carousel">
        <h2 class="carousel-name">{{ ucfirst($category) }} Products</h2>
        <div class="carousel-inner">
            @foreach (${$category . 'Products'}->chunk(3) as $chunk)
            <div class="carousel-item @if ($loop->first) active @endif">
                <div class="row">
                    @foreach ($chunk as $product)
                    <div class="col-md-4 product-carousel-item">
                        <div class="card bg-light">
                            @php
                            // Get the first "H" priority image for the product
                            $image = $product->images->firstWhere('priority', 'H');
                            @endphp
                            @if ($image)
                            <img src="{{ url($image->folder . '/' . $image->filename) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                            <img src="{{ url('images/default-product.jpg') }}" class="card-img-top" alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-price mb-0">{{ $product->price }}$</p>
                                </div>
                                <p class="card-text">
                                    {{ Str::limit($product->description, 60) }}
                                </p>
                                <a href="{{ route('product.show', ['productId' => encrypt($product->pro_id)]) }}" class="btn btn-primary">View Details</a>

                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#{{ $category }}Carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#{{ $category }}Carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
@endforeach
<div class="container-fluid" style="background-color: white;">

    <div>
        <h2 style="color: red;"><i class="bi bi-fire"></i> Hot Products</h2>
    </div>
    <div id="productCarousel" class="carousel slide product-carousel" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($hotProducts->chunk(3) as $chunk)
            <div class="carousel-item @if ($loop->first) active @endif">
                <div class="row">
                    @foreach ($chunk as $product)
                    <div class="col-md-4 product-carousel-item">
                        <div class="card bg-light">
                            @if ($product->images->isNotEmpty())
                            <!-- Display the first image of the product with H priority -->
                            <img src="{{ url($product->images->first()->folder . '/' . $product->images->first()->filename) }}" class="card-img-top" alt="{{ $product->name }}">
                            @else
                            <!-- Display a default image if no images exist for the product -->
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
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>
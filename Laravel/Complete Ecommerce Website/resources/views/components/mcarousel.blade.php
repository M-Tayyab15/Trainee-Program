<div class="container-fluid">
    <!-- Categories Carousel -->
    <div id="categoryCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ($categories->chunk(1) as $chunk)
            <div class="carousel-item @if ($loop->first) active @endif">
                <div class="row">
                    @foreach ($chunk as $category)
                    <div class="col-md-12">
                        <a href="#{{ strtolower($category->name) }}Carousel">
                            <img src="{{ $category->image_url }}" alt="{{ $category->name }}" style="cursor: pointer;">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#categoryCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#categoryCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>
</div>

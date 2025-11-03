<section class="slider-section">
    @if($banners->count() > 0)
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

            {{-- Indicators --}}
            <div class="carousel-indicators">
                @foreach($banners as $index => $banner)
                    <button type="button" data-bs-target="#carouselExampleCaptions"
                        data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}"
                        aria-current="{{ $index === 0 ? 'true' : 'false' }}">
                    </button>
                @endforeach
            </div>

            {{-- Slides --}}
            <div class="carousel-inner">
                @foreach($banners as $index => $banner)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row d-flex align-items-center">
                            <div class="col">
                                <img src="{{ asset('storage/' . $banner->banner) }}" class="img-fluid w-100" alt="{{ $banner->title }}">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Controls --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>
    @else
        <p class="py-5 text-center">No banners available</p>
    @endif
</section>`

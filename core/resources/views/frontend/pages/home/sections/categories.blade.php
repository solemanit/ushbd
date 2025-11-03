@if ($categories->count())
    <section class="cartegory-slider section-padding bg-section-2">
        <div class="container">
            <div class="pb-4 text-center">
                <h3 class="mb-0 h3 fw-bold">Our Categories</h3>
                <p class="mb-0 text-capitalize">Select your favorite categories and purchase</p>
            </div>

            <div class="cartegory-box">
                @forelse ($categories as $category)
                    {{-- <a @if($category->slug) href="{{ route('category.show', $category->slug) }}" @endif> --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="overflow-hidden">
                                    @if ($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                            class="card-img-top rounded-0" alt="{{ $category->name }}">
                                    @else
                                        <img src="{{ asset('images/default-category.png') }}"
                                            class="card-img-top rounded-0" alt="No Image">
                                    @endif
                                </div>
                                <div class="text-center">
                                    <h5 class="mt-3 mb-1 cartegory-name fw-bold">{{ $category->name }}</h5>
                                </div>
                            </div>
                        </div>
                    {{-- </a> --}}
                @empty
                    <p class="text-center text-muted">No categories available.</p>
                @endforelse
            </div>
        </div>
    </section>
@endif

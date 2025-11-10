@if ($services->count())
    <section class="cartegory-slider section-padding bg-section-2">
        <div class="container">
            <div class="pb-4 text-center">
                <h3 class="mb-0 h3 fw-bold">Our Services</h3>
                <p class="mb-0 text-capitalize">Explore our wide range of services</p>
            </div>

            <div class="cartegory-box">
                @forelse ($services as $service)
                    {{-- <a @if($service->slug) href="{{ route('category.show', $service->slug) }}" @endif> --}}
                        <div class="card">
                            <div class="card-body">
                                <div class="overflow-hidden">
                                    @if ($service->image)
                                        <img src="{{ asset('storage/' . $service->image) }}"
                                            class="card-img-top rounded-0" alt="{{ $service->name }}">
                                    @else
                                        <img src="{{ asset('images/default-category.png') }}"
                                            class="card-img-top rounded-0" alt="No Image">
                                    @endif
                                </div>
                                <div class="text-center">
                                    <h5 class="mt-3 mb-1 cartegory-name fw-bold">{{ $service->name }}</h5>
                                </div>
                            </div>
                        </div>
                    {{-- </a> --}}
                @empty
                    <p class="text-center text-muted">No service available.</p>
                @endforelse
            </div>
        </div>
    </section>
@endif

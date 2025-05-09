<section class="pt-80 pb-100 duo_product">
    <div class="container">
        <div class="row justify-content-center justify-content-xl-between g-4">
            <div class="col-12">
                <div class="row gy-lg-4 gy-3">
                    
                    
                    <div class="col-lg-6 " >
                        <div class="product-listing-box bg-white rounded-2">

                            <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                                <h4 class="mb-0">{{ localize('New Products') }}</h4>
                                <a href="{{ route('products.index') }}"
                                    class="explore-btn text-secondary fw-bold">{{ localize('View More') }}<span class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                            </div>


                            <div class="row">
                                @foreach (\App\Models\Product::isPublished()->latest()->take(2)->get() as $product)
                                <div class="col-lg-6 col-6 px-1">
                                        <div class="mb-3">
                                            @include(
                                                'frontend.default.pages.partials.products.horizontal-product-card',
                                                [
                                                    'product' => $product,
                                                ]
                                            )
                                        </div>
                                    </div>
                                @endforeach
                            </div>


                        </div>
                    </div>
                    



                    <div class="col-lg-6 px-1">
                        <div class="product-listing-box bg-white rounded-2">
                            <div class="d-flex align-items-center justify-content-between gap-3 mb-5 flex-wrap">
                                <h4 class="mb-0">{{ localize('Best Selling') }}</h4>
                                <a href="{{ route('products.index') }}"
                                    class="explore-btn text-secondary fw-bold">{{ localize('All Products') }}<span
                                        class="ms-2"><i class="fas fa-arrow-right"></i></span></a>
                            </div>
                            @php
                                $best_selling_products = getSetting('best_selling_products') != null ? json_decode(getSetting('best_selling_products')) : [];
                                $products = \App\Models\Product::whereIn('id', $best_selling_products)->get();
                            @endphp



                        <div class="row">
                            @foreach ($products as $product)
                            <div class="col-lg-6 col-6 px-1">
                                <div class="mb-3">
                                    @include(
                                        'frontend.default.pages.partials.products.horizontal-product-card',
                                        [
                                            'product' => $product,
                                        ]
                                    )
                                </div>
                                </div>
                            @endforeach

                        </div>
                        </div>
                    </div>


                </div>
            </div>
            {{-- <div class="col-xl-3 d-none d-xl-block">
                <a href="{{ getSetting('best_selling_banner_link') }}" class=""><img
                        src="{{ uploadedAsset(getSetting('best_selling_banner')) }}" alt=""
                        class="img-fluid rounded-2 d-flex flex-column h-100 object-fit-cover"></a>
            </div> --}}
        </div>
    </div>
</section>

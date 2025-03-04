<section class="pt-8 pb-100 bg-white position-relative overflow-hidden z-1 trending-products-area">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/garlic.png') }}" alt="garlic"
        class="position-absolute garlic z--1" data-parallax='{"y": 100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/carrot.png') }}" alt="carrot"
        class="position-absolute carrot z--1" data-parallax='{"y": -100}'>
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/mashrom.png') }}" alt="mashrom"
        class="position-absolute mashrom z--1" data-parallax='{"x": 100}'>
    <div class="container">
        <div class="row align-items-center">

            <div class="col-12 mb-5">
                <div class="section-title text-center ">
                    <h3 class="mb-0">{{ localize('Top Trending Products') }}</h3>
                </div>
            </div>

            <div class="col-12 mt-2 mb-3">
                <div class="filter-btns gshop-filter-btn-group text-center  mt-4 mt-xl-0">

                    @php
                        $trending_product_categories =
                            getSetting('trending_product_categories') != null
                                ? json_decode(getSetting('trending_product_categories'))
                                : [];
                        $categories = \App\Models\Category::whereIn('id', $trending_product_categories)->get();
                    @endphp


                    <button class="active" data-filter="*">
                        <img src="{{ asset('frontend/default/assets/img/category_all_products.png') }}" alt=""
                            class="filter-category-img">
                        <span class="category_active_name">
                            {{ localize('All Products') }}
                        </span>
                    </button>


                    @foreach ($categories as $category)
                        {{-- <div class="filter-button-container"> --}}
                        <button data-filter=".{{ $category->id }}">
                            <img src="{{ uploadedAsset($category->collectLocalization('thumbnail_image')) }}"
                                alt="" class="filter-category-img">
                            <span class="category_active_name">
                                {{ $category->collectLocalization('name') }}
                            </span>
                        </button>
                        {{-- </div> --}}
                    @endforeach

                </div>
            </div>

        </div>
        <div class="row justify-content-center g-4 mt-5 filter_group">

            @php
                $trending_products =
                    getSetting('top_trending_products') != null ? json_decode(getSetting('top_trending_products')) : [];
                $products = \App\Models\Product::whereIn('id', $trending_products)->get();
            @endphp

            @foreach ($products as $product)
                <div
                    class=" col-lg-3 col-md-4 col-6 px-lg-2 px-1 
                    @php
if($product->categories()->count() > 0){ 
                            foreach ($product->categories as $category) {
                               echo $category->id .' ';
                            }
                        } @endphp">
                    @include('frontend.default.pages.partials.products.trending-product-card', [
                        'product' => $product,
                    ])
                </div>
            @endforeach
        </div>
    </div>
</section>

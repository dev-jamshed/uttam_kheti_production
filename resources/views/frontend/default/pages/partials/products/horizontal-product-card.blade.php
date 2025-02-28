
<div class="horizontal-product-card d-sm-flex align-items-center position-relative  bg-white   border card-md  ">
    
    @php
    $discountPercentage = discountPercentage($product);
@endphp

@if ($discountPercentage > 0)
    <span class="offer-badge text-white fw-bold fs-xxs bg-danger position-absolute start-0 top-0">
        -{{ discountPercentage($product) }}% <span class="text-uppercase">{{ localize('Off') }}</span>
    </span>
@endif

    <div class="thumbnail  rounded-2">
        <a href="javascript:void(0);"><img src="{{ uploadedAsset($product->thumbnail_image) }}" alt="product"
                class="img-fluid"></a>
 
        <div
            class="product-overlay position-absolute  d-flex  align-items-center justify-content-center gap-2">
            @if (isLoggedIn() && isCustomer())
                <a href="javascript:void(0);" class="rounded-btn fs-xs" onclick="addToWishlist({{ $product->id }})"><i
                        class="fa-regular fa-heart"></i></a>
            @elseif(!isLoggedIn())
                <a href="javascript:void(0);" class="rounded-btn fs-xs" onclick="addToWishlist({{ $product->id }})"><i
                        class="fa-regular fa-heart"></i></a>
            @endif

            <a href="javascript:void(0);" class="rounded-btn fs-xs"
                onclick="showProductDetailsModal({{ $product->id }})"><i class="fa-solid fa-eye"></i></a>

        </div>

        
    </div>

    <div class="card-content mt-4 mt-sm-0 w-100">
        <a
            href="{{ route('products.show', $product->slug) }}"
            class="fw-bold text-heading title  tt-line-clamp tt-clamp-1">
            {{ $product->collectLocalization('name') }}
        </a>

        @if ($product->categories()->count() > 0)
        <div class="tt-category-tag horizontal-product-category-tag-container  justify-content-center mx-auto">
            @foreach ($product->categories as $category)
                <a href="{{ route('products.index') }}?&category_id={{ $category->id }}"
                    class="text-muted fs-xxs">{{ $category->collectLocalization('name') }}</a>
            @endforeach
        </div>
        @endif




        

        {{-- // Variants  start--}}
        <div class="horizontal-card-vairant-space">
            @if (count(generateVariationOptions($product->without_variation_combinations)) > 0)
                @foreach (generateVariationOptions($product->without_variation_combinations) as $variation)
                      
                    <ul   onclick="showProductDetailsModal({{ $product->id }})"
                        class="product-radio-btn d-flex align-items-center justify-content-center gap-2 m-0  ">
                        @if ($variation['id'] != 2)
                            @foreach ($variation['values'] as $value)
                                <li>
                                 
                                    <label style="cursor: pointer" for="val-just_view{{ $value['id'] }}">{{ $value['name'] }}</label>
                                </li>
                            @endforeach
                        @else
                            <!-- color -> id=2 -->
                            <div class="position-relative me-n4">
                                @foreach ($variation['values'] as $value)
                                    <li>
                                         
                                        <label for="val-just_view{{ $value['id'] }}" class="px-1 py-2">
                                            <span class="px-3 py-2 rounded" style="background-color:{{ $value['code'] }}">
                                            </span>
                                        </label>
    
                                    </li>
                                @endforeach
                            </div>
                            <!-- color -> id=2 -->
                        @endif
                    </ul>
     
                @endforeach
            @endif
        </div>        

        
        {{-- // Variants  end--}}

        <div class="pricing mt-3">
            @include('frontend.default.pages.partials.products.pricing', [
                'product' => $product,
                'onlyPrice' => true,
            ])
        </div>

        @php
            $isVariantProduct = 0;
            $stock = 0;
            if ($product->variations()->count() > 1) {
                $isVariantProduct = 1;
            } else {
                $stock = $product->variations[0]->product_variation_stock ? $product->variations[0]->product_variation_stock->stock_qty : 0;
            }
        @endphp

        @if ($isVariantProduct)
            <div class="d-flex justify-content-between align-items-center buynow-content ">
                
                <span class="flex-grow-1">
                    <a href="javascript:void(0);" class="fs-xs fw-bold  d-inline-block explore-btn  cart-button"
                        onclick="showProductDetailsModal({{ $product->id }})">{{ localize('Buy Now') }}
                        <span class="cart-icon"><i class="fa-regular fa-cart-shopping-fast"></i></span>
                    </a>
                </span>

               

                @if (getSetting('enable_reward_points') == 1)
                    <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="{{ localize('Reward Points') }}">
                        <i class="fas fa-medal"></i> {{ $product->reward_points }}
                    </span>
                @endif


            </div>
        @else
            <form action="" class="direct-add-to-cart-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" >
                <input type="hidden" name="product_variation_id" value="{{ $product->variations[0]->id }}">
                <input type="hidden" value="1" name="quantity">

                <div class="d-flex justify-content-between align-items-center buynow-content  ">
                    <span class="flex-grow-1">
                        @if (!$isVariantProduct && $stock < 1)
                            <a href="javascript:void(0);" class="fs-xs fw-bold d-inline-block explore-btn">
                                {{ localize('Out of Stock') }}
                                <span class="ms-1"><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        @else
                            <a href="javascript:void(0);" onclick="directAddToCartFormSubmit(this)"
                                class="fs-xs fw-bold d-inline-block explore-btn direct-add-to-cart-btn cart-button">
                                <span class="add-to-cart-text">{{ localize('Buy Now') }}</span>
                                <span class="cart-icon"><i class="fa-regular fa-cart-shopping-fast"></i></span>
                            </a>
                        @endif
                    </span>

                    @if (getSetting('enable_reward_points') == 1)
                        <span class="fs-xxs fw-bold" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="{{ localize('Reward Points') }}">
                            <i class="fas fa-medal"></i> {{ $product->reward_points }}
                        </span>
                    @endif
                </div>
            </form>
        @endif

    </div>
</div>

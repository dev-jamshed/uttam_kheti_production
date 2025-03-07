<section class="c-bg-linear-gradient-primary gshop-hero pt-120 bg-white position-relative z-1 overflow-hidden">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/leaf-shadow.png') }}" alt="leaf"
        class="position-absolute leaf-shape z--1 rounded-circle d-none d-lg-inline">
    <img src="{{ staticAsset('frontend/default/assets/img/shapes/mango.png') }}" alt="mango"
        class="position-absolute mango z--1" data-parallax='{"y": -120}'>
    <video src="{{ asset('public/frontend/default/assets/bg_videos/vegitables_bg.mp4') }}" muted autoplay loop
        class="home_hero_bg"></video>

    <img src="{{ staticAsset('frontend/default/assets/img/shapes/hero-circle-sm.png') }}" alt="circle"
        class="position-absolute hero-circle circle-sm z--1 d-none d-md-inline">

    <div class="container">

        <div class="home-hero-container">

            {{-- <h2 class="home-hero-heading">Order Vegitables fruits & groceries. Discover
                best deals. Uttam kheti it! </h2> --}}

            @foreach ($sliders as $slider)
                <h2 class="home-hero-heading">{{ $slider->title }}</h2>
                {{-- <p class="mb-5 fs-6">{{ $slider->text }}</p> --}}
            @endforeach

            {{-- // Filter --}}
            <div class="search-location-container">

                {{-- // location --}}
                {{-- <div class="location-input-container">
                    <button class="location-icon-button"><i class="fa-regular fa-location-dot"></i></button>
                    <input type="text" placeholder="DHA Phase 5">
                </div> --}}

                {{-- //Search --}}

                {{-- <div class="search-input-container">
                        <input type="text" placeholder="Search Vegitables Fruits & Groceries.">
                        <button  class="search-icon-button"><i class="fa-regular fa-magnifying-glass"></i></button>
                    </div> --}}

                <form class="search-input-container" action="{{ route('products.index') }}">
                    <input type="text" placeholder="{{ localize('Search products') }}" name="search"
                        @isset($searchKey) value="{{ $searchKey }}" @endisset>
                    <button type="submit" class="submit-icon-btn-secondary"><i
                            class="fa-solid fa-magnifying-glass"></i></button>
                </form>

            </div>




            @php
                $campaigns = \App\Models\Campaign::where('end_date', '>=', strtotime(date('Y-m-d')))
                    ->where('is_published', 1)
                    ->latest()
                    ->get();
            @endphp

           

            {{-- // Categories --}}
            <div class="category-main-container">

                @forelse ($campaigns as $campaign)
                    <div class="c-category-card">
                     <span>EAT OUT & SAVE MORE</span>
                     <p>UP {{$campaign->discount}}{{$campaign->discount_type == 'percent' ? '%' : ''}} OFF</p>
                     
                        <a href="{{ route('home.campaigns.show', $campaign->slug) }}">
                         <img src="{{ uploadedAsset($campaign->banner) }}" alt="">
                        </a>
                        
                     <h3>{{ $campaign->title }}</h3>
                     <div class="category-card-button-section">
                         <a href="{{ route('home.campaigns.show', $campaign->slug) }}">
                             <i class="fa-solid fa-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
              
                @endforelse

                {{-- <div class="c-category-card">
                    <span>EAT OUT & SAVE MORE</span>
                    <p>UP 30% OFF</p>
                    <img src="{{ asset('public/frontend/default/assets/img/custom_images/2.png') }}" alt="">
                    <h3>FRUITS</h3>
                    <div class="category-card-button-section">
                        <a href="#">
                            <i class="fa-solid fa-right"></i>
                        </a>
                    </div>
                </div>

                <div class="c-category-card">
                    <span>EAT OUT & SAVE MORE</span>
                    <p>UP 30% OFF</p>
                    <img src="{{ asset('public/frontend/default/assets/img/custom_images/3.png') }}" alt="">
                    <h3>VEGETABLES</h3>
                    <div class="category-card-button-section">
                        <a href="#">
                            <i class="fa-solid fa-right"></i>
                        </a>
                    </div>
                </div>

                <div class="c-category-card">
                    <span>EAT OUT & SAVE MORE</span>
                    <p>UP 30% OFF</p>
                    <img src="{{ asset('public/frontend/default/assets/img/custom_images/4.png') }}" alt="">
                    <h3>MART</h3>
                    <div class="category-card-button-section">
                        <a href="#">
                            <i class="fa-solid fa-right"></i>
                        </a>
                    </div>
                </div>

                <div class="c-category-card">
                    <span>EAT OUT & SAVE MORE</span>
                    <p>UP 30% OFF</p>
                    <img src="{{ asset('public/frontend/default/assets/img/custom_images/5.png') }}" alt="">
                    <h3>OFFERS</h3>
                    <div class="category-card-button-section">
                        <a href="#">
                            <i class="fa-solid fa-right"></i>
                        </a>
                    </div>
                </div> --}}

            </div>
        </div>


        {{-- //swipper Slider for feature  
        <div class="gshop-hero-slider swiper">
            <div class="swiper-wrapper">

                @foreach ($sliders as $slider)
                    <div class="swiper-slide gshop-hero-single">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-xl-5 col-lg-7">
                                <div class="hero-left-content">
                                    <span
                                        class="gshop-subtitle fs-5 text-secondary mb-2 d-block">{{ $slider->sub_title }}</span>
                                    <h1 class="display-4 mb-3">{{ $slider->title }}</h1>
                                    <p class="mb-5 fs-6">{{ $slider->text }}</p>

                                    <div class="hero-btns d-flex align-items-center gap-3 gap-sm-5 flex-wrap">
                                        <a href="{{ $slider->link }}"
                                            class="btn btn-secondary">{{ localize('Explore Now') }}<span
                                                class="ms-2"><i class="fa-solid fa-arrow-right"></i></span></a>
                                        <a href="{{ route('home.pages.aboutUs') }}"
                                            class="btn btn-primary">{{ localize('About Us') }}<span class="ms-2"><i
                                                    class="fa-solid fa-arrow-right"></i></span></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-5">
                                <div class="hero-right text-center position-relative z-1 mt-6 mt-xl-0">

                                    <img src="{{ uploadedAsset($slider->image) }}" alt=""
                                        class="img-fluid position-absolute end-0 top-50 hero-img">

                                    <img src="{{ staticAsset('frontend/default/assets/img/shapes/hero-circle-lg.png') }}"
                                        alt="circle shape" class="img-fluid hero-circle">
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>  

    </div>
    {{-- @if (getSetting('facebook_link') || getSetting('twitter_link') || getSetting('linkedin_link') || getSetting('youtube_link'))
        <div class="gs-hero-social">
            <ul class="list-unstyled">
                @if (getSetting('facebook_link'))
                    <li><a href="{{ getSetting('facebook_link') }}"><i class="fab fa-facebook-f"></i></a></li>
                @endif
                @if (getSetting('twitter_link'))
                    <li><a href="{{ getSetting('twitter_link') }}"><i class="fab fa-twitter"></i></a></li>
                @endif
                @if (getSetting('linkedin_link'))
                    <li><a href="{{ getSetting('linkedin_link') }}"><i class="fab fa-linkedin-in"></i></a></li>
                @endif
                @if (getSetting('youtube_link'))
                    <li><a href="{{ getSetting('youtube_link') }}"><i class="fab fa-youtube"></i></a></li>
                @endif

            </ul>
            <span class="title fw-medium">{{localize('Follow on')}}</span>
        </div>
    @endif --}}

        <div class="gshop-hero-slider-pagination theme-slider-control position-absolute top-50 translate-middle-y z-5">
        </div>
</section>






 
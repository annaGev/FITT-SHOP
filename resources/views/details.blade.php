@extends('layouts.app')
@section('title', $product->name . ' - купить в интернет-магазине FITT')
@section('description', Str::limit($product->short_description ?? $product->description, 160))
@section('keywords', $product->name . ', ' . ($product->category->name ?? 'одежда') . ', купить ' . $product->name . ', FITT')

@section('og_title', $product->name . ' | FITT')
@section('og_description', Str::limit($product->short_description ?? $product->description, 160))
@section('og_image', asset('uploads/products/' . $product->image))

@section('twitter_title', $product->name . ' | FITT')
@section('twitter_description', Str::limit($product->short_description ?? $product->description, 160))
@section('twitter_image', asset('uploads/products/' . $product->image))
@section('content')

<main class="pt-90">
    <div class="mb-md-1 pb-md-3"></div>

    <section class="product-single container">
        <div class="row">

            {{-- ==================== ГАЛЕРЕЯ ==================== --}}
            <div class="col-lg-7">
                <div class="product-single__media" data-media-type="vertical-thumbnail">
                    <div class="product-single__image">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">

                                {{-- Главное изображение --}}
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/' . $product->image) }}"
                                        width="674" height="674" alt="{{ $product->name }}" style="border-radius: 7px;" />
                                    <a data-fancybox="gallery"
                                        href="{{ asset('uploads/products/' . $product->image) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="left" title="Увеличить">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <use href="#icon_zoom" />
                                        </svg>
                                    </a>
                                </div>

                                {{-- Галерея --}}
                                @if($product->images)
                                    @foreach (explode(',', $product->images) as $gimg)
                                        @if(trim($gimg))
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/' . trim($gimg)) }}"
                                                width="674" height="674" alt="{{ $product->name }}" style="border-radius: 7px;"/>
                                            <a data-fancybox="gallery"
                                                href="{{ asset('uploads/products/' . trim($gimg)) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left" title="Увеличить">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_zoom" />
                                                </svg>
                                            </a>
                                        </div>
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                            <div class="swiper-button-prev">
                                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_prev_sm" />
                                </svg>
                            </div>
                            <div class="swiper-button-next">
                                <svg width="7" height="11" viewBox="0 0 7 11" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_next_sm" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Миниатюры --}}
                    <div class="product-single__thumbnail">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide product-single__image-item">
                                    <img loading="lazy" class="h-auto"
                                        src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                                        width="104" height="104" alt="" />
                                </div>
                                @if($product->images)
                                    @foreach (explode(',', $product->images) as $gimg)
                                        @if(trim($gimg))
                                        <div class="swiper-slide product-single__image-item">
                                            <img loading="lazy" class="h-auto"
                                                src="{{ asset('uploads/products/thumbnails/' . trim($gimg)) }}"
                                                width="104" height="104" alt="" />
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== ИНФОРМАЦИЯ О ТОВАРЕ ==================== --}}
            <div class="col-lg-5">

                {{-- Навигация --}}
                <div class="d-flex justify-content-between mb-4 pb-md-2">
                    <div class="breadcrumb mb-0 d-none d-md-block flex-grow-1">
                        <a href="{{ route('home.index') }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">Главная</a>
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="{{ route('shop.index') }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">Магазин</a>
                        @if($product->category)
                        <span class="breadcrumb-separator menu-link fw-medium ps-1 pe-1">/</span>
                        <a href="{{ route('shop.index', ['categories' => $product->category->id]) }}"
                            class="menu-link menu-link_us-s text-uppercase fw-medium">{{ $product->category->name }}</a>
                        @endif
                    </div>
                    <div class="product-single__prev-next d-flex align-items-center justify-content-between justify-content-md-end flex-grow-1">
                        <a href="#" class="text-uppercase fw-medium">
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_prev_md" />
                            </svg>
                            <span class="menu-link menu-link_us-s">Пред.</span>
                        </a>
                        <a href="#" class="text-uppercase fw-medium">
                            <span class="menu-link menu-link_us-s">След.</span>
                            <svg width="10" height="10" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                                <use href="#icon_next_md" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Статус наличия --}}
                @if($product->stock_status === 'instock')
                    <div class="mb-2">
                        <span style="color:#198754; font-size:13px; font-weight:500;">
                             В наличии
                        </span>
                    </div>
                @else
                    <div class="mb-2">
                        <span style="color:#dc3545; font-size:13px; font-weight:500;">
                            ✗ Нет в наличии
                        </span>
                    </div>
                @endif

                {{-- Название --}}
                <h1 class="product-single__name">{{ $product->name }}</h1>

                {{-- Рейтинг --}}
                <div class="product-single__rating">
                    <div class="reviews-group d-flex">
                        @for($i = 0; $i < 5; $i++)
                        <svg class="review-star" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg">
                            <use href="#icon_star" />
                        </svg>
                        @endfor
                    </div>
                    {{-- <span class="reviews-note text-lowercase text-secondary ms-1">8к+ отзывов</span> --}}
                </div>

                {{-- Цена --}}
                <div class="product-single__price">
                    @if($product->sale_price)
                        <span class="current-price">
                            <span style="text-decoration:line-through; color:#767676; font-size:1rem; font-weight:400;">
                                {{ number_format($product->regular_price, 0, '.', ' ') }} ₽
                            </span>
                            <span style="color:#d6001c; margin-left:8px;">
                                {{ number_format($product->sale_price, 0, '.', ' ') }} ₽
                            </span>
                        </span>
                        {{-- Процент скидки --}}
                        @php
                            $discount = round((1 - $product->sale_price / $product->regular_price) * 100);
                        @endphp
                        <span class="ms-2 badge"
                            style="background:#d6001c; color:#fff; font-size:12px; padding:4px 8px; border-radius:4px;">
                            -{{ $discount }}%
                        </span>
                    @else
                        <span class="current-price">
                            {{ number_format($product->regular_price, 0, '.', ' ') }} ₽
                        </span>
                    @endif
                </div>

                {{-- Краткое описание --}}
                <div class="product-single__short-desc">
                    <p>{{ $product->short_description }}</p>
                </div>

                {{-- ===== ЦВЕТА ===== --}}
                @if($product->colors)
                @php
                    $colors = array_filter(array_map('trim', explode(',', $product->colors)));
                @endphp
                @if(count($colors) > 0)
                <div class="product-single__swatches mb-3">
                    <div class="product-swatch color-swatches">
                        <label class="text-uppercase fw-medium" style="min-width:80px; font-size:13px;">
                            Цвет:
                        </label>
                        <div class="swatch-list d-flex flex-wrap gap-2 mt-2">
                            @foreach($colors as $index => $color)
                            <label class="color-swatch-label" title="{{ $color }}" style="cursor:pointer;">
                                <input type="radio" name="selected_color" value="{{ $color }}"
                                    style="display:none;"
                                    {{ $index === 0 ? 'checked' : '' }}>
                                <span class="swatch-color-circle d-block"
                                    style="
                                        width: 30px;
                                        height: 30px;
                                        border-radius: 50%;
                                        background-color: {{ $color }};
                                        border: 2px solid {{ $index === 0 ? '#222' : '#ddd' }};
                                        box-shadow: inset 0 0 0 2px #fff;
                                        transition: border-color 0.2s;
                                    ">
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endif

                {{-- ===== РАЗМЕРЫ ===== --}}
                @if($product->sizes)
                @php
                    $sizes = array_filter(array_map('trim', explode(',', $product->sizes)));
                @endphp
                @if(count($sizes) > 0)
                <div class="product-single__swatches mb-3">
                    <div class="product-swatch text-swatches">
                        <label class="text-uppercase fw-medium d-block mb-2" style="font-size:13px;">
                            Размер:
                        </label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($sizes as $index => $size)
                            <label class="size-swatch-label" style="cursor:pointer;">
                                <input type="radio" name="selected_size" value="{{ $size }}"
                                    style="display:none;"
                                    {{ $index === 0 ? 'checked' : '' }}>
                                <span class="size-swatch-btn d-flex align-items-center justify-content-center"
                                    style="
                                        min-width: 44px;
                                        height: 36px;
                                        padding: 0 12px;
                                        border: {{ $index === 0 ? '2px solid #222' : '1px solid #ddd' }};
                                        font-size: 13px;
                                        font-weight: 500;
                                        transition: all 0.2s;
                                        background: {{ $index === 0 ? '#222' : '#fff' }};
                                        color: {{ $index === 0 ? '#fff' : '#222' }};
                                    ">
                                    {{ strtoupper($size) }}
                                </span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @endif

                {{-- ===== КНОПКИ КОРЗИНА / ВИШЛИСТ ===== --}}
                @if(Cart::instance('cart')->content()->where('id', $product->id)->count() > 0)
                    <a href="{{ route('cart.index') }}" class="btn btn-warning mb-3 w-100">
                        Перейти в корзину
                    </a>
                @else
                    <form name="addtocart-form" method="post" action="{{ route('cart.add') }}">
                        @csrf
                        <div class="product-single__addtocart">
                            <div class="qty-control position-relative">
                                <input type="number" name="quantity" value="1" min="1"
                                    class="qty-control__number text-center" style="border-radius: 7px;">
                                <div class="qty-control__reduce">-</div>
                                <div class="qty-control__increase">+</div>
                            </div>
                            <input type="hidden" name="id" value="{{ $product->id }}">
                            <input type="hidden" name="name" value="{{ $product->name }}">
                            <input type="hidden" name="price"
                                value="{{ $product->sale_price ?: $product->regular_price }}">
                            @if($product->stock_status === 'instock')
                                <button type="submit" class="btn btn-primary btn-addtocart" style="border-radius: 7px;">
                                    В корзину
                                </button>
                            @else
                                <button type="button" class="btn btn-addtocart btn-outofstock" disabled>
                                    Нет в наличии
                                </button>
                            @endif
                        </div>
                    </form>
                @endif

                {{-- ===== ВИШЛИСТ / ПОДЕЛИТЬСЯ ===== --}}
                <div class="product-single__addtolinks mt-3">
                    @if(Cart::instance('wishlist')->content()->where('id', $product->id)->count() > 0)
                        <form action="{{ route('wishlist.item.remove', ['rowId' => Cart::instance('wishlist')->content()->where('id', $product->id)->first()->rowId]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="menu-link menu-link_us-s" style="border:0;background:none;color:orange;">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_heart" />
                                </svg>
                                <span>Убрать из избранного</span>
                            </button>
                        </form>
                    @else
                        <form action="{{ route('wishlist.add') }}" method="POST" id="wishlist_form_detail">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product->id }}" />
                            <input type="hidden" name="name" value="{{ $product->name }}" />
                            <input type="hidden" name="price" value="{{ $product->sale_price ?: $product->regular_price }}" />
                            <input type="hidden" name="quantity" value="1" />
                            <button type="submit" class="menu-link menu-link_us-s border-0 bg-transparent">
                                <svg width="16" height="16" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <use href="#icon_heart" />
                                </svg>
                                <span>В избранное</span>
                            </button>
                        </form>
                    @endif
                </div>

                {{-- ===== META-ИНФОРМАЦИЯ ===== --}}
                <div class="product-single__meta-info mt-3">
                    <div class="meta-item">
                        <label>Артикул:</label>
                        <span>{{ $product->SKU }}</span>
                    </div>
                    @if($product->category)
                    <div class="meta-item">
                        <label>Категория:</label>
                        <span>
                            <a href="{{ route('shop.index', ['categories' => $product->category->id]) }}">
                                {{ $product->category->name }}
                            </a>
                        </span>
                    </div>
                    @endif
                    @if($product->brand)
                    <div class="meta-item">
                        <label>Бренд:</label>
                        <span>
                            <a href="{{ route('shop.index', ['brands' => $product->brand->id]) }}">
                                {{ $product->brand->name }}
                            </a>
                        </span>
                    </div>
                    @endif
                    <div class="meta-item">
                        <label>Наличие:</label>
                        <span style="{{ $product->stock_status === 'instock' ? 'color:#198754' : 'color:#dc3545' }}">
                            {{ $product->stock_status === 'instock' ? 'В наличии' : 'Нет в наличии' }}
                            @if($product->stock_status === 'instock' && $product->quantity <= 10)
                                (осталось {{ $product->quantity }} шт.)
                            @endif
                        </span>
                    </div>
                </div>

            </div>
        </div>

        {{-- ==================== ТАБЫ С ОПИСАНИЕМ ==================== --}}
        <div class="product-single__details-tab mt-5">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" data-bs-toggle="tab"
                        href="#tab-description" role="tab">Описание</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" data-bs-toggle="tab"
                        href="#tab-info" role="tab">Характеристики</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" data-bs-toggle="tab"
                        href="#tab-delivery" role="tab">Доставка и оплата</a>
                </li>
                {{-- <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore" data-bs-toggle="tab"
                        href="#tab-reviews" role="tab">Отзывы</a>
                </li> --}}
            </ul>

            <div class="tab-content pt-4">

                {{-- Описание --}}
                <div class="tab-pane fade show active" id="tab-description" role="tabpanel">
                    <div class="product-single__description">
                        {!! $product->description !!}
                    </div>
                </div>

                {{-- Характеристики --}}
                <div class="tab-pane fade" id="tab-info" role="tabpanel">
                    <table class="table" style="max-width:600px;">
                        <tbody>
                            <tr>
                                <th style="width:200px; font-weight:500; color:#767676;">Артикул</th>
                                <td>{{ $product->SKU }}</td>
                            </tr>
                            @if($product->brand)
                            <tr>
                                <th style="font-weight:500; color:#767676;">Бренд</th>
                                <td>{{ $product->brand->name }}</td>
                            </tr>
                            @endif
                            @if($product->category)
                            <tr>
                                <th style="font-weight:500; color:#767676;">Категория</th>
                                <td>{{ $product->category->name }}</td>
                            </tr>
                            @endif
                            @if($product->sizes)
                            <tr>
                                <th style="font-weight:500; color:#767676;">Доступные размеры</th>
                                <td>
                                    @foreach(array_filter(array_map('trim', explode(',', $product->sizes))) as $s)
                                        <span class="badge me-1"
                                            style="border:1px solid #ddd; color:#222; background:#f9f9f9; padding:4px 10px; font-weight:500;">
                                            {{ strtoupper($s) }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                            @endif
                            @if($product->colors)
                            <tr>
                                <th style="font-weight:500; color:#767676;">Доступные цвета</th>
                                <td>
                                    <div class="d-flex gap-2 flex-wrap">
                                        @foreach(array_filter(array_map('trim', explode(',', $product->colors))) as $c)
                                            <span title="{{ $c }}"
                                                style="display:inline-block; width:24px; height:24px; border-radius:50%; background:{{ $c }}; border:1px solid #ccc;">
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th style="font-weight:500; color:#767676;">Наличие</th>
                                <td>
                                    @if($product->stock_status === 'instock')
                                        <span style="color:#198754;">В наличии ({{ $product->quantity }} шт.)</span>
                                    @else
                                        <span style="color:#dc3545;">Нет в наличии</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Доставка --}}
                <div class="tab-pane fade" id="tab-delivery" role="tabpanel">
                    <div style="max-width:600px;">
                        <h5 class="mb-3">Доставка</h5>
                        <ul class="list-unstyled" style="line-height:2; font-size:15px;">
                            <li><strong>Курьерская доставка</strong> — от 1 до 3 рабочих дней</li>
                            <li><strong>Почта России / СДЭК</strong> — от 3 до 7 рабочих дней</li>
                            <li><strong>Самовывоз</strong> — из пунктов выдачи</li>
                            <li><strong>Бесплатная доставка</strong> при заказе от 5 000 ₽</li>
                        </ul>
                        <h5 class="mb-3 mt-4">Оплата</h5>
                        <ul class="list-unstyled" style="line-height:2; font-size:15px;">
                            <li>💳 Банковская карта (Visa, Mastercard, МИР)</li>
                            <li>💵 Наличными при получении (COD)</li>
                            <li>📱 PayPal</li>
                        </ul>
                        <h5 class="mb-3 mt-4">Возврат</h5>
                        <p style="font-size:15px;">Возврат товара надлежащего качества в течение <strong>14 дней</strong> с момента получения. Товар должен быть в оригинальной упаковке, без следов использования.</p>
                    </div>
                </div>

                {{-- Отзывы --}}
                {{-- <div class="tab-pane fade" id="tab-reviews" role="tabpanel">
                    <div class="product-single__review-form" style="max-width:600px;">
                        <form>
                            <h5>Оставить отзыв</h5>
                            <p style="color:#767676; font-size:14px;">Ваш email не будет опубликован.</p>
                            <div class="mb-3">
                                <div class="select-star-rating d-flex gap-2">
                                    @for($i = 5; $i >= 1; $i--)
                                    <svg class="review-star" viewBox="0 0 9 9"
                                        xmlns="http://www.w3.org/2000/svg"
                                        style="width:20px; height:20px; cursor:pointer;">
                                        <use href="#icon_star" />
                                    </svg>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="Ваше имя" />
                                <label>Ваше имя</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" placeholder="Email" />
                                <label>Email</label>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" rows="4"
                                    placeholder="Ваш отзыв о товаре..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary text-uppercase">
                                Отправить отзыв
                            </button>
                        </form>
                    </div>
                </div> --}}

            </div>
        </div>
    </section>

    {{-- ==================== ПОХОЖИЕ ТОВАРЫ ==================== --}}
    <section class="products-carousel container mt-5">
        <h2 class="h3 text-uppercase mb-4 pb-xl-2 mb-xl-4">
            Похожие <strong>товары</strong>
        </h2>

        <div id="related_products" class="position-relative">
            <div class="swiper-container js-swiper-slider"
                data-settings='{
                    "autoplay": false,
                    "slidesPerView": 4,
                    "slidesPerGroup": 4,
                    "effect": "none",
                    "loop": true,
                    "pagination": {
                        "el": "#related_products .products-pagination",
                        "type": "bullets",
                        "clickable": true
                    },
                    "navigation": {
                        "nextEl": "#related_products .products-carousel__next",
                        "prevEl": "#related_products .products-carousel__prev"
                    },
                    "breakpoints": {
                        "320": { "slidesPerView": 2, "slidesPerGroup": 2, "spaceBetween": 14 },
                        "768": { "slidesPerView": 3, "slidesPerGroup": 3, "spaceBetween": 24 },
                        "992": { "slidesPerView": 4, "slidesPerGroup": 4, "spaceBetween": 30 }
                    }
                }'>
                <div class="swiper-wrapper">
                    @foreach ($rproducts as $rproduct)
                    <div class="swiper-slide product-card">
                        <div class="pc__img-wrapper">
                            <a href="{{ route('shop.product.details', $rproduct->slug) }}">
                                <img loading="lazy"
                                    src="{{ asset('uploads/products/' . $rproduct->image) }}"
                                    width="330" height="400" alt="{{ $rproduct->name }}"
                                    class="pc__img" style="border-radius: 7px;">
                            </a>
                            @if(Cart::instance('cart')->content()->where('id', $rproduct->id)->count() > 0)
                                <a href="{{ route('cart.index') }}"
                                    class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium">
                                    В корзину
                                </a>
                            @else
                                <form method="post" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $rproduct->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <input type="hidden" name="name" value="{{ $rproduct->name }}">
                                    <input type="hidden" name="price"
                                        value="{{ $rproduct->sale_price ?: $rproduct->regular_price }}">
                                    <button type="submit"
                                        class="pc__atc btn anim_appear-bottom position-absolute border-0 text-uppercase fw-medium">
                                        В корзину
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="pc__info position-relative">
                            <p class="pc__category">{{ $rproduct->category->name ?? '' }}</p>
                            <h6 class="pc__title">
                                <a href="{{ route('shop.product.details', $rproduct->slug) }}">
                                    {{ $rproduct->name }}
                                </a>
                            </h6>
                            <div class="product-card__price d-flex">
                                @if($rproduct->sale_price)
                                    <span class="money price">
                                        <s>{{ number_format($rproduct->regular_price, 0, '.', ' ') }} ₽</s>
                                        <span style="color:red;">
                                            {{ number_format($rproduct->sale_price, 0, '.', ' ') }} ₽
                                        </span>
                                    </span>
                                @else
                                    <span class="money price">
                                        {{ number_format($rproduct->regular_price, 0, '.', ' ') }} ₽
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="products-carousel__prev position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_prev_md" />
                </svg>
            </div>
            <div class="products-carousel__next position-absolute top-50 d-flex align-items-center justify-content-center">
                <svg width="25" height="25" viewBox="0 0 25 25" xmlns="http://www.w3.org/2000/svg">
                    <use href="#icon_next_md" />
                </svg>
            </div>
            <div class="products-pagination mt-4 mb-5 d-flex align-items-center justify-content-center"></div>
        </div>
    </section>
</main>

{{-- Скрипт интерактивных свотчей --}}
@push('scripts')
<script>
$(function () {

    // ---- ЦВЕТА ----
    $('input[name="selected_color"]').on('change', function () {
        $('.color-swatch-label .swatch-color-circle').each(function () {
            $(this).css('border', '2px solid #ddd');
        });
        $(this).siblings('.swatch-color-circle').css('border', '2px solid #222');
    });

    // ---- РАЗМЕРЫ ----
    $('input[name="selected_size"]').on('change', function () {
        $('.size-swatch-label .size-swatch-btn').each(function () {
            $(this).css({
                'border': '1px solid #ddd',
                'background': '#fff',
                'color': '#222'
            });
        });
        $(this).siblings('.size-swatch-btn').css({
            'border': '2px solid #222',
            'background': '#222',
            'color': '#fff'
        });
    });

    // ---- qty-control ----
    $(".qty-control__reduce").on("click", function () {
        var input = $(this).siblings('.qty-control__number');
        var val = parseInt(input.val());
        if (val > 1) input.val(val - 1);
    });

    $(".qty-control__increase").on("click", function () {
        var input = $(this).siblings('.qty-control__number');
        var val = parseInt(input.val());
        input.val(val + 1);
    });
});
</script>
@endpush
@endsection

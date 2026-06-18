@extends('layouts.app')
@section('content')
<style>
    /* Дополнительные стили только для визуального улучшения */
    .address-card {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
    }
    .address-card p {
        margin-bottom: 8px;
        color: #374151;
    }
    .address-card p:first-child {
        font-weight: 600;
        font-size: 16px;
        color: #111827;
    }
    .checkout-cart-items td:last-child,
    .checkout-totals td:last-child,
    .cart-totals td:last-child {
        text-align: right;
    }
    .checkout-cart-items th:last-child {
        text-align: right;
    }
    .checkout-cart-items td:first-child,
    .checkout-totals th,
    .cart-totals th {
        text-align: left;
    }
    .checkout__totals table {
        width: 100%;
    }
    .checkout-cart-items th,
    .checkout-totals th,
    .cart-totals th {
        padding: 12px 0;
        border-bottom: 1px solid #e5e7eb;
    }
    .checkout-cart-items td,
    .checkout-totals td,
    .cart-totals td {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .total-row {
        border-top: 2px solid #111827 !important;
    }
    .total-row td,
    .total-row th {
        padding-top: 16px;
        font-weight: 700;
        font-size: 18px;
    }
    .checkout__payment-methods {
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }
    .form-check {
        margin-bottom: 12px;
    }
    .form-check-input {
        margin-right: 10px;
    }
    .policy-text {
        margin-top: 16px;
        font-size: 12px;
        color: #6c757d;
    }
    .btn-checkout {
        margin-top: 24px;
        width: 100%;
        background: #3b82f6;
        color: #fff;
        padding: 14px;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
    }
    .btn-checkout:hover {
        background: #2563eb;
    }
    .my-account_address-list {
        margin-top: 20px;
    }
    .my-account__address-item__detail {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
    }
    .my-account__address-item__detail p {
        margin-bottom: 8px;
    }
    .my-account__address-item__detail p:first-child {
        font-weight: 600;
    }
    .form-floating input.form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    .form-floating .text-danger {
        font-size: 12px;
        margin-top: 5px;
    }
</style>

<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Доставка и оформление заказа</h2>
        <div class="checkout-steps">
            <a href="{{ route('cart.index') }}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Корзина</span>
                    <em>Управление списком товаров</em>
                </span>
            </a>
            <a href="javascript::void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Доставка и оформление</span>
                    <em>Оформление вашего заказа</em>
                </span>
            </a>
            <a href="order-confirmation.html" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Подтверждение</span>
                    <em>Проверка и отправка заказа</em>
                </span>
            </a>
        </div>

        <form name="checkout-form" action="{{ route('cart.place.an.order') }}" method="POST">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-6">
                            <h4>ДЕТАЛИ ДОСТАВКИ</h4>
                        </div>
                        <div class="col-6">
                        </div>
                    </div>
                    @if ($address)
                        <div class="row">
                            <div class="col-md-12">
                                <div class="my-account_address-list">
                                    <div class="my-account__address-list-item">
                                        <div class="my-account__address-item__detail">
                                            <p><strong>{{ $address->name }}</strong></p>
                                            <p>{{ $address->address }}</p>
                                            @if($address->landmark)<p>{{ $address->landmark }}</p>@endif
                                            <p>{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            <p>Индекс: {{ $address->zip }}</p>
                                            <p>Телефон: {{ $address->phone }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="name" required=""
                                        value="{{ old('name') }}" style="border-radius: 7px;">
                                    <label for="name">Полное имя *</label>
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="phone" required=""
                                        value="{{ old('phone') }}" style="border-radius: 7px;">
                                    <label for="phone">Номер телефона *</label>
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="zip" required=""
                                        value="{{ old('zip') }}" style="border-radius: 7px;">
                                    <label for="zip">Почтовый индекс *</label>
                                    @error('zip')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating mt-3 mb-3">
                                    <input type="text" class="form-control" name="state" required=""
                                        value="{{ old('state') }}" style="border-radius: 7px;">
                                    <label for="state">Регион *</label>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="city" required=""
                                        value="{{ old('city') }}" style="border-radius: 7px;">
                                    <label for="city">Город *</label>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="address" required=""
                                        value="{{ old('address') }}" style="border-radius: 7px;">
                                    <label for="address">Дом, название здания *</label>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="locality" required=""
                                        value="{{ old('locality') }}" style="border-radius: 7px;">
                                    <label for="locality">Название улицы, района *</label>
                                    @error('locality')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating my-3">
                                    <input type="text" class="form-control" name="landmark" required=""
                                        value="{{ old('landmark') }}" style="border-radius: 7px;">
                                    <label for="landmark">Ориентир *</label>
                                    @error('landmark')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">
                        <div class="checkout__totals" style="border-radius: 7px;">
                            <h3>Ваш заказ</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>ТОВАР</th>
                                        <th style="text-align: right">СУБТОТАЛ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::instance('cart')->content() as $item)
                                        <tr>
                                            <td>
                                                {{ $item->name }} × {{ $item->qty }}
                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format(floatval(str_replace(',', '', $item->subtotal)), 2) }} ₽
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            @if (Session::has('discounts'))
                                <table class="cart-totals">
                                    <tbody>
                                        <tr>
                                            <th>Субтотал</th>
                                            <td>{{ Cart::instance('cart')->subtotal() }} ₽</td>
                                        </tr>
                                        <tr>
                                            <th>Скидка {{ Session::get('coupon')['code'] }}</th>
                                            <td>{{ Session::get('discounts')['discount'] }} ₽</td>
                                        </tr>
                                        <tr>
                                            <th>Субтотал после скидки</th>
                                            <td>{{ Session::get('discounts')['subtotal'] }} ₽</td>
                                        </tr>
                                        <tr>
                                            <th>Доставка</th>
                                            <td>Бесплатно</td>
                                        </tr>
                                        <tr>
                                            <th>НДС</th>
                                            <td>{{ Session::get('discounts')['tax'] }} ₽</td>
                                        </tr>
                                        <tr style="border-top: 2px solid #222;">
                                            <th>Итого</th>
                                            <td>{{ Session::get('discounts')['total'] }} ₽</td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                            
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>СУБТОТАЛЬ</th>
                                        <td style="text-align: right">{{ Cart::instance('cart')->subtotal() }}</td>
                                    </tr>
                                    <tr>
                                        <th>ДОСТАВКА</th>
                                        <td style="text-align: right">Бесплатная доставка</td>
                                    </tr>
                                    <tr>
                                        <th>НДС</th>
                                        <td style="text-align: right">{{ Cart::instance('cart')->tax() }} ₽</td>
                                    </tr>
                                    <tr>
                                        <th style="border-top: 1px solid #e5e7eb">ИТОГО</th>
                                        <td style="border-top: 1px solid #e5e7eb; text-align: right; font-weight: 700">{{ Cart::instance('cart')->total() }} ₽</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="checkout__payment-methods" style="border-radius: 7px;">
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio"
                                    name="mode" id="mode1" value="card">
                                <label class="form-check-label" for="mode">
                                    Банковская карта
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio"
                                    name="mode" id="mode3" value="paypal">
                                <label class="form-check-label" for="mode">
                                    Paypal
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio"
                                    name="mode" id="mode2" value="cod">
                                <label class="form-check-label" for="mode">
                                    Наличными при доставке
                                </label>
                            </div>
                            <div class="policy-text">
                                Ваши персональные данные будут использованы для обработки заказа, поддержки вашего опыта
                                на этом сайте и для других целей, описанных в нашей <a href="terms.html"
                                    target="_blank">политике
                                    конфиденциальности</a>.
                            </div>
                        </div>
                        <button class="btn btn-primary btn-checkout">ОФОРМИТЬ ЗАКАЗ</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection
@extends('layouts.app')
@push('styles')
<style>
    /* Стили для страницы подтверждения заказа (чек) */
    .order-complete {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        padding: 24px 32px 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .order-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
        background: #f8f9fa;
        padding: 20px 24px;
        border-radius: 12px;
        margin: 24px 0 32px;
    }

    .order-info__item {
        flex: 1;
        min-width: 140px;
    }

    .order-info__item label {
        display: block;
        font-size: 12px;
        text-transform: uppercase;
        color: #6c757d;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .order-info__item span {
        font-size: 18px;
        font-weight: 600;
        color: #222;
    }

    .checkout__totals {
        border-top: 2px solid #e9ecef;
        padding-top: 24px;
        margin-top: 8px;
    }

    .checkout__totals h3 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #222;
    }

    /* Таблицы — одинаковое выравнивание */
    .checkout-cart-items,
    .checkout-totals {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .checkout-cart-items th,
    .checkout-totals th {
        text-align: left;
        font-weight: 500;
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
        color: #495057;
        font-size: 14px;
    }

    .checkout-cart-items td {
        padding: 12px 0;
        border-bottom: 1px solid #e9ecef;
        color: #222;
    }

    .checkout-cart-items td:last-child,
    .checkout-totals td:last-child {
        text-align: right;
    }

    .checkout-totals th,
    .checkout-totals td {
        padding: 10px 0;
    }

    .checkout-totals td {
        text-align: right;
    }

    .order-complete__message {
        text-align: center;
        margin-bottom: 24px;
    }

    .order-complete__message h3 {
        margin-top: 16px;
        font-size: 24px;
        font-weight: 600;
    }

    .order-complete__message p {
        color: #6c757d;
        margin-top: 8px;
    }

    @media (max-width: 576px) {
        .order-complete {
            padding: 16px;
        }

        .order-info {
            flex-direction: column;
            gap: 12px;
        }

        .order-info__item {
            min-width: auto;
        }

        .checkout-cart-items th,
        .checkout-cart-items td {
            font-size: 13px;
        }
    }
</style>
@endpush
@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="shop-checkout container">
            <h2 class="page-title">Заказ получен</h2>
            <div class="checkout-steps">
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">01</span>
                    <span class="checkout-steps__item-title">
                        <span>Корзина</span>
                        <em>Управление списком товаров</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">02</span>
                    <span class="checkout-steps__item-title">
                        <span>Доставка и оформление</span>
                        <em>Оформление вашего заказа</em>
                    </span>
                </a>
                <a href="javascript:void(0)" class="checkout-steps__item active">
                    <span class="checkout-steps__item-number">03</span>
                    <span class="checkout-steps__item-title">
                        <span>Подтверждение</span>
                        <em>Проверка и отправка заказа</em>
                    </span>
                </a>
            </div>
            <div class="order-complete">
                <div class="order-complete__message">
                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="40" cy="40" r="40" fill="#B9A16B" />
                        <path
                            d="M52.9743 35.7612C52.9743 35.3426 52.8069 34.9241 52.5056 34.6228L50.2288 32.346C49.9275 32.0446 49.5089 31.8772 49.0904 31.8772C48.6719 31.8772 48.2533 32.0446 47.952 32.346L36.9699 43.3449L32.048 38.4062C31.7467 38.1049 31.3281 37.9375 30.9096 37.9375C30.4911 37.9375 30.0725 38.1049 29.7712 38.4062L27.4944 40.683C27.1931 40.9844 27.0257 41.4029 27.0257 41.8214C27.0257 42.24 27.1931 42.6585 27.4944 42.9598L33.5547 49.0201L35.8315 51.2969C36.1328 51.5982 36.5513 51.7656 36.9699 51.7656C37.3884 51.7656 37.8069 51.5982 38.1083 51.2969L40.385 49.0201L52.5056 36.8996C52.8069 36.5982 52.9743 36.1797 52.9743 35.7612Z"
                            fill="white" />
                    </svg>
                    <h3>Ваш заказ успешно выполнен!</h3>
                    <p>Спасибо. Ваш заказ получен.</p>
                </div>
                <div class="order-info">
                    <div class="order-info__item">
                        <label>Номер заказа</label>
                        <span>{{ $order->id }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Дата</label>
                        <span>{{ $order->created_at->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="order-info__item">
                        <label>Итого</label>
                        <span>{{ number_format($order->total, 2) }} ₽</span>
                    </div>
                    <div class="order-info__item">
                        <label>Способ оплаты</label>
                        <span>{{ $order->transaction->mode == 'cod' ? 'Наличными при доставке' : ucfirst($order->transaction->mode) }}</span>
                    </div>
                </div>
                <div class="checkout__totals-wrapper">
                    <div class="checkout__totals">
                        <h3>Детали заказа</h3>
                        {{-- Список товаров --}}
                        <table class="checkout-cart-items">
                            <thead>
                                <tr>
                                    <th>ТОВАР</th>
                                    <th>СТОИМОСТЬ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ $item->product->name }} × {{ $item->quantity }}</td>
                                        <td>
                                            {{ number_format($item->price * $item->quantity, 2) }} ₽
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Итоги --}}
                        <table class="checkout-totals">
                            <tbody>
                                <tr>
                                    <th>Сумма товаров</th>
                                    <td>{{ number_format($order->subtotal, 2) }} ₽</td>
                                </tr>
                                @if ($order->discount > 0)
                                    <tr>
                                        <th>Скидка</th>
                                        <td>− {{ number_format($order->discount, 2) }} ₽</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Доставка</th>
                                    <td>Бесплатно</td>
                                </tr>
                                <tr>
                                    <th>НДС</th>
                                    <td>{{ number_format($order->tax, 2) }} ₽</td>
                                </tr>
                                <tr style="font-weight:600; font-size:1.05rem; border-top:2px solid #222;">
                                    <th>Итого к оплате</th>
                                    <td>{{ number_format($order->total, 2) }} ₽</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@extends('layouts.app')
@section('content')
    <style>
        /* МИНИМАЛИСТИЧНЫЙ ДИЗАЙН - HTML НЕ ИЗМЕНЕН */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: #374151;
            background: #f8fafc;
        }

        .page-title {
            font-size: 28px;
            font-weight: 500;
            margin: 0 0 32px 0;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 12px;
        }

        .wg-box {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            margin-bottom: 24px;
            padding: 28px;
        }

        /* МИНИМАЛИСТИЧНЫЕ ТАБЛИЦЫ */
        .order-table,
        .items-table,
        .transaction-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            background: transparent;
        }

        .order-table th,
        .items-table th,
        .transaction-table th {
            background: #f9fafb !important;
            color: #6b7280 !important;
            padding: 14px 18px !important;
            font-weight: 500;
            font-size: 13px;
            letter-spacing: 0.03em;
            border-bottom: 2px solid #e5e7eb !important;
        }

        .order-table td,
        .items-table td,
        .transaction-table td {
            padding: 14px 18px !important;
            border-bottom: 1px solid #f3f4f6 !important;
            vertical-align: middle;
            color: #374151;
        }

        .order-table tbody tr:hover,
        .items-table tbody tr:hover,
        .transaction-table tbody tr:hover {
            background: #f8fafc;
        }

        /* БЕЙДЖИ */
        .bg-success {
            background: #10b981 !important;
            color: #fff !important;
        }

        .bg-danger {
            background: #ef4444 !important;
            color: #fff !important;
        }

        .bg-warning {
            background: #f59e0b !important;
            color: #fff !important;
        }

        .bg-secondary {
            background: #6b7280 !important;
            color: #fff !important;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.03em;
        }

        /* ПРОДУКТЫ */
        .pname {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .table-image {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0;
            border: 1px solid #e5e7eb;
        }

        .table-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-name {
            font-weight: 500;
            color: #111827;
            text-decoration: none;
        }

        .product-name:hover {
            color: #3b82f6;
        }

        .price-highlight {
            font-weight: 600;
            font-size: 16px;
            color: #111827;
        }

        .action-icons {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .eye {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .eye:hover {
            background: #3b82f6;
            color: #fff;
            border-color: #3b82f6;
        }

        /* БАЗОВЫЕ */
        .text-center {
            text-align: center;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .gap10 {
            gap: 10px;
        }

        .mb-4,
        .mb-5 {
            margin-bottom: 1.5rem;
        }

        .mt-5 {
            margin-top: 2rem;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            display: inline-block;
            border: 1px solid #ef4444;
            color: #ef4444;
            transition: all 0.2s ease;
        }

        .btn:hover {
            background: #ef4444;
            color: #fff;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .wg-filter h5 {
            font-size: 20px;
            font-weight: 500;
            color: #111827;
            margin: 0;
        }

        /* АДАПТИВНОСТЬ */
        @media (max-width: 768px) {
            .pname {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-table td,
            .items-table td {
                padding: 12px 12px !important;
                font-size: 14px;
            }

            .wg-box {
                padding: 20px;
                margin-bottom: 20px;
            }

            .page-title {
                font-size: 24px;
            }
        }
    </style>

    <main class="pt-90" style="padding-top: 0px; padding: 24px 0; background: #f8fafc;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Заказы</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    <div class="wg-box">
                        <div class="flex items-center justify-between gap10 flex-wrap">
                            <div class="wg-filter flex-grow">
                                <h5>Детали заказа</h5>
                            </div>
                            <a class="btn btn-sm btn-danger" href="{{ route('user.orders') }}">Назад</a>
                        </div>
                        <div class="table-responsive mb-5">
                            @if (Session::has('status'))
                                <p class="alert alert-success">{{ Session::get('status') }}</p>
                            @endif
                            <table class="table order-table table-striped table-transaction">
                                <tbody>
                                    <tr>
                                        <th>№ заказа</th>
                                        <td>{{ $order->id }}</td>
                                        <th>Телефон</th>
                                        <td>{{ $order->phone }}</td>
                                        <th>Почтовый индекс</th>
                                        <td>{{ $order->zip }}</td>
                                    </tr>
                                    <tr>
                                        <th>Дата заказа</th>
                                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        <th>Дата доставки</th>
                                        <td>{{ $order->delivered_date ? $order->delivered_date->format('d.m.Y H:i') : '-' }}
                                        </td>
                                        {{-- <th>Дата отмены</th> --}}
                                        {{-- <td>{{ $order->canceled_date ? $order->canceled_date->format('d.m.Y H:i') : '-' }} --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Статус заказа</th>
                                        <td colspan="5">
                                            @if ($order->status == 'delivered')
                                                <span class="badge bg-success">Доставлен</span>
                                            @elseif ($order->status == 'canceled')
                                                <span class="badge bg-danger">Отменен</span>
                                            @else
                                                <span class="badge bg-warning">Оформлен</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="wg-filter">
                            <h5>Товары заказа</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table items-table table-striped table-transaction">
                                <thead>
                                    <tr>
                                        <th>Название</th>
                                        <th class="text-center">Цена</th>
                                        <th class="text-center">Кол-во</th>
                                        <th class="text-center">Артикул</th>
                                        <th class="text-center">Категория</th>
                                        <th class="text-center">Бренд</th>
                                        <th class="text-center">Опции</th>
                                        <th class="text-center">Возврат</th>
                                        <th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orderItems as $item)
                                        <tr>
                                            <td class="pname">
                                                <div class="table-image">
                                                    <img src="{{ asset('uploads/products/thumbnails/' . $item->product->image) }}"
                                                        class="image">
                                                </div>
                                                <div class="name">
                                                    <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                        target="_blank" class="product-name">{{ $item->product->name }}</a>
                                                </div>
                                            </td>
                                            <td class="text-center price-highlight">{{ number_format($item->price, 2) }} ₽
                                            </td>
                                            <td class="text-center">{{ $item->quantity }}</td>
                                            <td class="text-center">{{ $item->product->SKU }}</td>
                                            <td class="text-center">{{ $item->product->category->name }}</td>
                                            <td class="text-center">{{ $item->product->brand->name ?? '-' }}</td>
                                            <td class="text-center">{{ $item->options ?? '-' }}</td>
                                            <td class="text-center">{{ $item->rstatus == 0 ? 'Нет' : 'Да' }}</td>
                                            <td class="text-center">
                                                <div class="action-icons">
                                                    <div class="eye">
                                                        <i class="icon-eye"></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $orderItems->links('pagination::bootstrap-5') }}
                        </div>

                        <div class="wg-box mt-5">
                            <h5>Адрес доставки</h5>
                            <div class="my-account__address-item col-md-6">
                                <div class="my-account__address-item__detail">
                                    <p>{{ $order->name }}</p>
                                    <p>{{ $order->address }}</p>
                                    <p>{{ $order->locality }}</p>
                                    <p>{{ $order->city }}, {{ $order->state }}</p>
                                    <p>{{ $order->landmark ?? '-' }}</p>
                                    <p>Индекс: {{ $order->zip }}</p>
                                    <br>
                                    <p>Телефон: {{ $order->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="wg-box mt-5">
                            <h5>Платежная информация</h5>
                            <table class="table transaction-table">
                                <tbody>
                                    <tr>
                                        <th>Подытог</th>
                                        <td>{{ number_format($order->subtotal, 2) }} ₽</td>
                                        <th>Налог</th>
                                        <td>{{ number_format($order->tax, 2) }} ₽</td>
                                        <th>Скидка</th>
                                        <td>{{ number_format($order->discount, 2) }} ₽</td>
                                    </tr>
                                    <tr>
                                        <th>Итого</th>
                                        <td class="price-highlight">{{ number_format($order->total, 2) }} ₽</td>
                                        <th>Способ оплаты</th>
                                        <td>
                                            {{ $transaction->mode == 'cod' ? 'Наличными при доставке' : ucfirst($transaction->mode) }}
                                        </td>
                                        <th>Статус</th>
                                        <td>
                                            @if ($transaction->status == 'approved')
                                                <span class="badge bg-success">Одобрен</span>
                                            @elseif ($transaction->status == 'declined')
                                                <span class="badge bg-danger">Отклонен</span>
                                            @elseif($transaction->status == 'refunded')
                                                <span class="badge bg-secondary">Возвращен</span>
                                            @else
                                                <span class="badge bg-warning">Ожидает</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            @if ($order->status == 'ordered')
                                <div class="wg-box mt-5 text-right">
                                    <form method="POST" action="{{ route('user.order.cancel', $order->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-danger order-cancel">Отменить заказ</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{ $orderItems->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>

        </section>
    </main>
@endsection
@push('scripts')
    <script>
        $(function() {
            // Ждем полной загрузки DOM перед выполнением скрипта
            // $(function(){}) - это сокращение от $(document).ready(function(){})

            $('.order-cancel').on('click', function(e) {
                // Находим все элементы с классом 'order-cancel' и добавляем обработчик события click

                e.preventDefault();
                // Предотвращаем стандартное поведение кнопки (отправку формы)
                // Без этого форма отправится сразу без подтверждения

                var form = $(this).closest('form');
                // Находим ближайшую родительскую форму для этой кнопки
                // Это нужно чтобы знать, какую форму отправлять при подтверждении

                if (confirm('Вы уверены, что хотите отменит этот заказ ?')) {
                    // Показываем диалоговое окно подтверждения
                    // Если пользователь нажал "OK" (true), отправляем форму
                    form.submit();
                }
                // Если пользователь нажал "Отмена" (false), ничего не делаем
            });
        });
    </script>
@endpush

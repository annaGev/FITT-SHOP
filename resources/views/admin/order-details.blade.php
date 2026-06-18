@extends('layouts.admin')
@section('content')
    <style>
        .table-transaction>tbody>tr:nth-of-type(odd) {
            --bs-table-accent-bg: #fff !important;
        }
    </style>
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Детали заказа</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Панель управления</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Позиции заказа</div>
                    </li>
                </ul>
            </div>


            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <h5>Информация о заказе</h5>
                    </div>
                </div>
                <div class="table-responsive mb-5">
                    @if (Session::has('status'))
                        <p class="alert alert-success">{{ Session::get('status') }}</p>
                    @endif
                    <table class="table table-striped table-bordered">
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
                                <td>{{ $order->created_at }}</td>
                                <th>Дата доставки</th>
                                <td>{{ $order->delivered_date }}</td>
                                <th>Дата отмены</th>
                                <td>{{ $order->canceled_date }}</td>
                            </tr>
                            <tr>
                                <th>Статус заказа</th>
                                <td colspan="5">
                                    @if ($order->status == 'delivered')
                                        <span class = "badge bg-success">Доставлен</span>
                                    @elseif ($order->status == 'canceled')
                                        <span class = "badge bg-danger">Отменен</span>
                                    @else
                                        <span class = "badge bg-warning">Оформлен</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="wg-filter">
                    <h5>Товары в заказе</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th class="text-center">Цена</th>
                                <th class="text-center">Количество</th>
                                <th class="text-center">Артикул</th>
                                <th class="text-center">Категория</th>
                                <th class="text-center">Бренд</th>
                                <th class="text-center">Опции</th>
                                <th class="text-center">Статус возврата</th>
                                <th class="text-center">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orderItems as $item)
                                <tr>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{ asset('uploads/products/thumbnails') }}/{{ $item->product->image }}"
                                                class="image">
                                        </div>
                                        <div class="name">
                                            <a href="{{ route('shop.product.details', ['product_slug' => $item->product->slug]) }}"
                                                target="_blank" class="body-title-2">{{ $item->product->name }}</a>
                                        </div>
                                    </td>
                                    <td class="text-center">{{ $item->price }} ₽</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-center">{{ $item->product->SKU }}</td>
                                    <td class="text-center">{{ $item->product->category->name }}</td>
                                    <td class="text-center">{{ $item->product->brand->name }}</td>
                                    <td class="text-center">{{ $item->options }}</td>
                                    <td class="text-center">{{ $item->rstatus == 0 ? 'НЕТ' : 'ДА' }}</td>
                                    <td class="text-center">
                                        <div class="list-icon-function view-icon">
                                            <div class="item eye">
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
            </div>

            <div class="wg-box mt-5">
                <h5>Адрес доставки</h5>
                <div class="my-account__address-item col-md-6">
                    <div class="my-account__address-item__detail">
                        <p>{{ $order->name }}</p>
                        <p>{{ $order->address }}</p>
                        <p>{{ $order->locality }}</p>
                        <p>{{ $order->city }}, {{ $order->country }}</p>
                        <p>{{ $order->landmark }}</p>
                        <p>{{ $order->zip }}</p>
                        <br>
                        <p>Телефон: {{ $order->phone }}</p>
                    </div>
                </div>
            </div>

            <div class="wg-box mt-5">
                <h5>Транзакции</h5>
                <table class="table table-striped table-bordered table-transaction">
                    <tbody>
                        <tr>
                            <th>Подытог</th>
                            <td>{{ $order->subtotal }} ₽</td>
                            <th>Налог</th>
                            <td>{{ $order->tax }} ₽</td>
                            <th>Скидка</th>
                            <td>{{ $order->discount }} ₽</td>
                        </tr>
                        <tr>
                            <th>Итого</th>
                            <td>{{ $order->total }} ₽</td>
                            <th>Способ оплаты</th>
                            <td>{{ $transaction->mode }}</td>
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
            </div>

            <div class="wg-box mt-5">
                <h5>Обновить статус заказа</h5>
                <form action="{{ route('admin.order.status.update') }}" method = 'POST'>
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <div class="col-md-3">
                        <div class="selected">
                            <select name="order_status" id="order_status">
                                <option value="ordered" @selected($order->status == 'ordered')>Оформлен</option>
                                <option value="delivered" @selected($order->status == 'delivered')>Доставлен</option>
                                <option value="canceled" @selected($order->status == 'canceled')>Отменен</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-5">
                        <button type="submit" class="btn btn-primary tf-button w208">Обновить статус</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

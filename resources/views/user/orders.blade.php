@extends('layouts.app')
@section('content')
    <style>
        /* МИНИМАЛИСТИЧНЫЕ ТАБЛИЦЫ */
        .orders-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            background: transparent;
            margin-bottom: 24px;
        }

        .orders-table th {
            background: #f9fafb !important;
            color: #6b7280 !important;
            padding: 16px 20px !important;
            font-weight: 500;
            font-size: 13px;
            letter-spacing: 0.03em;
            border-bottom: 2px solid #e5e7eb !important;
            text-transform: uppercase;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .orders-table td {
            padding: 16px 20px !important;
            border-bottom: 1px solid #f3f4f6 !important;
            vertical-align: middle;
            color: #374151;
        }

        .orders-table tbody tr:hover {
            background: #f8fafc;
            transform: scale(1.001);
            transition: all 0.2s ease;
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

        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        /* СТОЛБЦЫ */
        .order-id {
            font-weight: 700;
            font-size: 16px;
            color: #111827;
        }

        .price-highlight {
            font-weight: 600;
            font-size: 16px;
            color: #059669;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        .status-cell {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .date-cell {
            font-size: 14px;
            color: #6b7280;
        }

        .items-count {
            background: #dbeafe;
            color: #1e40af;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: 500;
            font-size: 13px;
        }

        .view-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: #f9fafb;
            border: 2px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .view-icon:hover {
            background: #3b82f6;
            color: #fff;
            border-color: #3b82f6;
            transform: translateY(-2px);
        }

        .view-icon i {
            font-size: 16px;
        }

        .wg-filter h5 {
            font-size: 22px;
            font-weight: 600;
            color: #111827;
            margin: 0 0 20px 0;
            padding-bottom: 12px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table-responsive {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        /* АДАПТИВНОСТЬ */
        @media (max-width: 992px) {

            .orders-table th,
            .orders-table td {
                padding: 12px 12px !important;
                font-size: 14px;
            }

            .wg-box {
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 24px;
            }

            .orders-table {
                font-size: 14px;
            }

            .orders-table th,
            .orders-table td {
                padding: 12px 8px !important;
            }
        }
    </style>
    <main class="pt-90" style="padding-top: 0px;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Заказы</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    <div class="wg-table table-all-user">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Имя</th>
                                        <th class="text-center">Телефон</th>
                                        <th class="text-center">Подытог</th>
                                        <th class="text-center">Налог</th>
                                        <th class="text-center">Итого</th>
                                        <th class="text-center">Статус</th>
                                        <th class="text-center">Дата заказа</th>
                                        <th class="text-center">Товары</th>
                                        <th class="text-center">Доставлено</th>
                                        <th></th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $order->user->name }}</td>
                                            <td class="text-center">{{ $order->phone }}</td>
                                            <td class="text-center">{{ $order->subtotal }} ₽</td>
                                            <td class="text-center">{{ $order->tax }} ₽</td>
                                            <td class="text-center">{{ $order->total }} ₽</td>

                                            <td class="text-center">
                                                @if ($order->status == 'delivered')
                                                    <span class="badge bg-success">Доставлен</span>
                                                @elseif ($order->status == 'canceled')
                                                    <span class="badge bg-danger">Отменен</span>
                                                @else
                                                    <span class="badge bg-warning">Ожидает</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $order->created_at }}</td>
                                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                                            <td>{{ $order->delivered_date }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.order.details', ['order_id' => $order->id]) }}">
                                                    <div class="list-icon-function view-icon">
                                                        <div class="item eye">
                                                            <i class="fa fa-eye"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection

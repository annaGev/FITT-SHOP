@extends('layouts.admin')
@section('content')
<style>
    /* Стили для фильтрации */
    .filter-card {
        background: #fff;
        border-radius: 16px;
        margin-bottom: 24px;
        padding: 20px 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        border: 1px solid #e5e7eb;
    }
    
    .filter-title {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .filter-title i {
        color: #6b7280;
    }
    
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: flex-end;
    }
    
    .filter-group {
        flex: 1;
        min-width: 160px;
    }
    
    .filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-group select,
    .filter-group input {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fff;
    }
    
    .filter-group select:focus,
    .filter-group input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    
    .search-group {
        display: flex;
        gap: 8px;
    }
    
    .search-group input {
        flex: 1;
    }
    
    .btn-filter {
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 500;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-filter-primary {
        background: #222;
        color: #fff;
    }
    
    .btn-filter-primary:hover {
        background: #3b3b3b;
    }
    
    .btn-filter-secondary {
        background: #f3f4f6;
        color: #374151;
    }
    
    .btn-filter-secondary:hover {
        background: #e5e7eb;
    }
    
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }
    
    .filter-tag {
        background: #f3f4f6;
        border-radius: 20px;
        padding: 5px 12px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #374151;
    }
    
    .filter-tag .remove {
        cursor: pointer;
        color: #9ca3af;
        text-decoration: none;
    }
    
    .filter-tag .remove:hover {
        color: #ef4444;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        display: inline-block;
    }
    
    .badge-warning {
        background: #fef3c7;
        color: #92400e;
    }
    
    .badge-success {
        background: #d1fae5;
        color: #065f46;
    }
    
    .badge-danger {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .table th {
        background: #f9fafb;
        color: #374151;
        font-weight: 600;
        font-size: 13px;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table td {
        vertical-align: middle;
        font-size: 14px;
    }
    
    .view-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        background: #f3f4f6;
        border-radius: 8px;
        transition: all 0.2s;
    }
    
    .view-icon:hover {
        background: #222;
        color: #fff;
    }
    
    .pagination {
        margin-top: 20px;
    }
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Заказы</h3>
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
                    <div class="text-tiny">Заказы</div>
                </li>
            </ul>
        </div>

        <div class="filter-card">
            <div class="filter-title">
                <i class="icon-filter"></i> Фильтры
            </div>
            
            <form method="GET" action="{{ route('admin.orders') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Статус</label>
                        <select name="status">
                            <option value="">Все статусы</option>
                            <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>🟡 Оформлен</option>
                            <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>🟢 Доставлен</option>
                            <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>🔴 Отменен</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Дата от</label>
                        <input type="date" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="filter-group">
                        <label>Дата до</label>
                        <input type="date" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    
                    <div class="filter-group">
                        <label>Поиск</label>
                        <div class="search-group">
                            <input type="text" name="search" placeholder="№ заказа, имя, телефон..." value="{{ request('search') }}">
                            <button type="submit" class="btn-filter btn-filter-primary">
                                <i class="icon-search"></i> Найти
                            </button>
                            <a href="{{ route('admin.orders') }}" class="btn-filter btn-filter-secondary">
                                <i class="icon-close"></i> Сброс
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Активные фильтры -->
                @if(request('status') || request('date_from') || request('date_to') || request('search'))
                <div class="active-filters">
                    <span style="font-size: 12px; color: #6b7280;">Активные фильтры:</span>
                    
                    @if(request('status'))
                    <span class="filter-tag">
                        Статус: 
                        @if(request('status') == 'ordered') Оформлен
                        @elseif(request('status') == 'delivered') Доставлен
                        @else Отменен
                        @endif
                        <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('date_from'))
                    <span class="filter-tag">
                        С: {{ request('date_from') }}
                        <a href="{{ request()->fullUrlWithQuery(['date_from' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('date_to'))
                    <span class="filter-tag">
                        По: {{ request('date_to') }}
                        <a href="{{ request()->fullUrlWithQuery(['date_to' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('search'))
                    <span class="filter-tag">
                        Поиск: "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                </div>
                @endif
            </form>
        </div>

        <div class="wg-box">
            <div class="table-responsive">
                @if(Session::has('status'))
                    <div class="alert alert-success">{{ Session::get('status') }}</div>
                @endif
                
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>№ заказа</th>
                            <th>Покупатель</th>
                            <th>Телефон</th>
                            <th>Сумма</th>
                            <th>Статус</th>
                            <th>Дата заказа</th>
                            <th>Товаров</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td class="text-center">{{ $order->id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ number_format($order->total, 2) }} ₽</td>
                            <td class="text-center">
                                @if ($order->status == 'delivered')
                                    <span class="badge badge-success">Доставлен</span>
                                @elseif ($order->status == 'canceled')
                                    <span class="badge badge-danger">Отменен</span>
                                @else
                                    <span class="badge badge-warning">Оформлен</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                            <td class="text-center">{{ $order->orderItems->count() }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.order.details', ['order_id' => $order->id]) }}" title="Просмотр">
                                    <div class="view-icon">
                                        <i class="icon-eye"></i>
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Заказы не найдены</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="divider"></div>
            <div class="flex items-center justify-between flex-wrap gap10">
                {{ $orders->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
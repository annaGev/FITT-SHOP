@extends('layouts.admin')
@section('content')
<style>
    /* Стили для фильтрации (единый стиль с заказами) */
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
</style>

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Все товары</h3>
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
                    <div class="text-tiny">Все товары</div>
                </li>
            </ul>
        </div>

        <div class="filter-card">
            <div class="filter-title">
                <i class="icon-filter"></i> Фильтры
            </div>
            
            <form method="GET" action="{{ route('admin.products') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label>Поиск</label>
                        <div class="search-group">
                            <input type="text" name="search" placeholder="Название или артикул..." value="{{ request('search') }}">
                        </div>
                    </div>
                    
                    <div class="filter-group">
                        <label>Категория</label>
                        <select name="category">
                            <option value="">Все категории</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Бренд</label>
                        <select name="brand">
                            <option value="">Все бренды</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>Наличие</label>
                        <select name="stock_status">
                            <option value="">Все</option>
                            <option value="instock" {{ request('stock_status') == 'instock' ? 'selected' : '' }}>В наличии</option>
                            <option value="outofstock" {{ request('stock_status') == 'outofstock' ? 'selected' : '' }}>Нет в наличии</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label>&nbsp;</label>
                        <div class="search-group">
                            <button type="submit" class="btn-filter btn-filter-primary">
                                <i class="icon-search"></i> Найти
                            </button>
                            <a href="{{ route('admin.products') }}" class="btn-filter btn-filter-secondary">
                                <i class="icon-close"></i> Сброс
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Активные фильтры -->
                @if(request('search') || request('category') || request('brand') || request('stock_status'))
                <div class="active-filters">
                    <span style="font-size: 12px; color: #6b7280;">Активные фильтры:</span>
                    
                    @if(request('search'))
                    <span class="filter-tag">
                        Поиск: "{{ request('search') }}"
                        <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('category') && $categories->find(request('category')))
                    <span class="filter-tag">
                        Категория: {{ $categories->find(request('category'))->name }}
                        <a href="{{ request()->fullUrlWithQuery(['category' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('brand') && $brands->find(request('brand')))
                    <span class="filter-tag">
                        Бренд: {{ $brands->find(request('brand'))->name }}
                        <a href="{{ request()->fullUrlWithQuery(['brand' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                    
                    @if(request('stock_status'))
                    <span class="filter-tag">
                        Наличие: {{ request('stock_status') == 'instock' ? 'В наличии' : 'Нет в наличии' }}
                        <a href="{{ request()->fullUrlWithQuery(['stock_status' => null]) }}" class="remove">&times;</a>
                    </span>
                    @endif
                </div>
                @endif
            </form>
        </div>

        <div class="wg-box">
            <div class="flex items-center justify-end gap10 flex-wrap mb-20">
                <a class="tf-button style-1 w208" href="{{ route('admin.add.product') }}">
                    <i class="icon-plus"></i> Добавить новый
                </a>
            </div>
            
            <div class="table-responsive">
                @if (Session::has('status'))
                    <div class="alert alert-success mb-20">{{ Session::get('status') }}</div>
                @endif
                
                <style>
                    /* Таблица — фиксированная ширина, без выхода текста */
                    .products-table {
                        width: 100%;
                        border-collapse: collapse;
                        background: #fff;
                        border-radius: 12px;
                        overflow: hidden;
                        font-size: 13px;
                        table-layout: fixed;
                        border: 1px solid #000;
                    }
                    
                    .products-table thead tr {
                        background: #f8f9fa;
                        border-bottom: 1px solid #e9ecef;
                    }
                    
                    .products-table th {
                        padding: 14px 8px;
                        font-weight: 600;
                        font-size: 12px;
                        color: #495057;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    
                    .products-table td {
                        padding: 12px 8px;
                        vertical-align: middle;
                        border-bottom: 1px solid #f0f0f0;
                        word-break: break-word;
                    }
                    
                    .products-table tbody tr:hover {
                        background: #fafafa;
                    }
                    
                    /* Ширина колонок */
                    .products-table th:nth-child(1) { width: 28%; }
                    .products-table th:nth-child(2) { width: 8%; }
                    .products-table th:nth-child(3) { width: 10%; }
                    .products-table th:nth-child(4) { width: 8%; }
                    .products-table th:nth-child(5) { width: 8%; }
                    .products-table th:nth-child(6) { width: 8%; }
                    .products-table th:nth-child(7) { width: 8%; }
                    .products-table th:nth-child(8) { width: 6%; }
                    .products-table th:nth-child(9) { width: 6%; }
                    .products-table th:nth-child(10) { width: 10%; }
                    
                    /* Ячейка с товаром */
                    .product-cell {
                        display: flex;
                        align-items: center;
                        gap: 10px;
                    }
                    
                    .product-cell .product-img {
                        width: 40px;
                        height: 40px;
                        border-radius: 6px;
                        overflow: hidden;
                        background: #f5f5f5;
                        flex-shrink: 0;
                    }
                    
                    .product-cell .product-img img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                    }
                    
                    .product-cell .product-info {
                        flex: 1;
                        min-width: 0;
                    }
                    
                    .product-cell .product-name {
                        font-weight: 600;
                        color: #111827;
                        text-decoration: none;
                        font-size: 13px;
                        display: block;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                    
                    .product-cell .product-name:hover {
                        color: #3b82f6;
                    }
                    
                    .product-cell .product-slug {
                        font-size: 10px;
                        color: #9ca3af;
                        margin-top: 3px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                    }
                    
                    /* Обрезка текста в других колонках */
                    .truncate-text {
                        display: block;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        white-space: nowrap;
                        max-width: 100%;
                    }
                    
                    /* Цены */
                    .price-regular {
                        font-weight: 600;
                        color: #111827;
                        white-space: nowrap;
                    }
                    
                    .price-sale {
                        font-weight: 600;
                        color: #10b981;
                        white-space: nowrap;
                    }
                    
                    /* Бейджи */
                    .badge {
                        padding: 4px 10px;
                        border-radius: 20px;
                        font-size: 11px;
                        font-weight: 500;
                        display: inline-block;
                        white-space: nowrap;
                    }
                    
                    .badge-success {
                        background: #d1fae5;
                        color: #065f46;
                    }
                    
                    .badge-danger {
                        background: #fee2e2;
                        color: #991b1b;
                    }
                    
                    .badge-secondary {
                        background: #f3f4f6;
                        color: #4b5563;
                    }
                    
                    /* Количество */
                    .quantity-badge {
                        display: inline-block;
                        min-width: 35px;
                        text-align: center;
                        padding: 4px 8px;
                        background: #f3f4f6;
                        border-radius: 20px;
                        font-weight: 500;
                        font-size: 12px;
                        white-space: nowrap;
                    }
                    
                    .quantity-low {
                        background: #fee2e2;
                        color: #991b1b;
                    }
                    
                    /* Кнопки действий */
                    .action-buttons {
                        display: flex;
                        gap: 6px;
                        justify-content: flex-start;
                        flex-wrap: nowrap;
                    }
                    
                    .action-btn {
                        width: 30px;
                        height: 30px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: 6px;
                        transition: all 0.2s;
                        cursor: pointer;
                        background: transparent;
                        border: none;
                        flex-shrink: 0;
                    }
                    
                    .action-btn.edit {
                        background: #e0e7ff;
                        color: #4338ca;
                    }
                    
                    .action-btn.edit:hover {
                        background: #4338ca;
                        color: #fff;
                    }
                    
                    .action-btn.delete {
                        background: #fee2e2;
                        color: #dc2626;
                    }
                    
                    .action-btn.delete:hover {
                        background: #dc2626;
                        color: #fff;
                    }
                    
                    /* Пагинация */
                    .divider {
                        margin: 20px 0 15px;
                        border-top: 1px solid #e5e7eb;
                    }
                    
                    /* Адаптивность */
                    @media (max-width: 1200px) {
                        .table-responsive {
                            overflow-x: auto;
                        }
                        .products-table {
                            min-width: 900px;
                        }
                    }
                </style>
                
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>Товар</th>
                            <th>Артикул</th>
                            <th>Категория</th>
                            <th>Бренд</th>
                            <th>Цена</th>
                            <th>Со скидкой</th>
                            <th>Наличие</th>
                            <th>Кол-во</th>
                            <th>Реком.</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-img">
                                        <img src="{{ asset('uploads/products/thumbnails/' . $product->image) }}"
                                            alt="{{ $product->name }}">
                                    </div>
                                    <div class="product-info">
                                        <a href="{{ route('admin.product.edit', $product->id) }}" class="product-name" title="{{ $product->name }}">
                                            {{ $product->name }}
                                        </a>
                                        <div class="product-slug" title="{{ $product->slug }}">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="truncate-text" title="{{ $product->SKU }}">{{ $product->SKU }}</span></td>
                            <td><span class="truncate-text" title="{{ $product->category->name ?? '—' }}">{{ $product->category->name ?? '—' }}</span></td>
                            <td><span class="truncate-text" title="{{ $product->brand->name ?? '—' }}">{{ $product->brand->name ?? '—' }}</span></td>
                            <td><span class="price-regular">{{ number_format($product->regular_price, 2) }} ₽</span></td>
                            <td>
                                @if($product->sale_price)
                                    <span class="price-sale">{{ number_format($product->sale_price, 2) }} ₽</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($product->stock_status == 'instock')
                                    <span class="badge badge-success">В наличии</span>
                                @else
                                    <span class="badge badge-danger">Нет</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $quantityClass = $product->quantity <= 5 ? 'quantity-low' : '';
                                @endphp
                                <span class="quantity-badge {{ $quantityClass }}">{{ $product->quantity }}</span>
                            </td>
                            <td>
                                @if($product->featured == 1)
                                    <span class="badge badge-success">Да</span>
                                @else
                                    <span class="badge badge-secondary">Нет</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.product.edit', $product->id) }}" class="action-btn edit" title="Редактировать">
                                        <i class="icon-edit-3"></i>
                                    </a>
                                    <form action="{{ route('admin.product.delete', $product->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="action-btn delete js-delete" title="Удалить">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">Товары не найдены</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10">
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    $('.js-delete').on('click', function(e){
        e.preventDefault();
        var form = $(this).closest('form');
        if (confirm('Вы уверены, что хотите удалить этот товар?')) {
            form.submit();
        }
    });
});
</script> 
@endpush
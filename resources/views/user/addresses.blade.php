@extends('layouts.app')
@section('content')
<style>
    /* Стили для страницы адресов (в едином стиле с заказами) */
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

    .address-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.2s ease;
        background: #fff;
        height: 100%;
    }

    .address-card.default {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .address-card .address-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 12px;
    }

    .badge-default {
        background: #10b981;
        color: #fff;
    }

    .badge-home {
        background: #e0e7ff;
        color: #4338ca;
    }

    .badge-office {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-other {
        background: #f3e8ff;
        color: #6b21a5;
    }

    .address-actions {
        display: flex;
        gap: 10px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .address-actions .btn-sm {
        padding: 6px 14px;
        font-size: 13px;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .btn-outline:hover {
        background: #f9fafb;
    }

    .btn-default {
        background: #10b981;
        border-color: #10b981;
        color: #fff;
    }

    .btn-default:hover {
        background: #059669;
    }

    .btn-danger {
        background: #ef4444;
        border-color: #ef4444;
        color: #fff;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .empty-addresses {
        text-align: center;
        padding: 60px 20px;
        background: #f9fafb;
        border-radius: 12px;
    }

    .empty-addresses p {
        margin-bottom: 20px;
        color: #6b7280;
    }

    @media (max-width: 768px) {
        .wg-box {
            padding: 20px;
        }
        .address-card {
            margin-bottom: 16px;
        }
    }
</style>

<main class="pt-90" style="padding: 24px 0; background: #f8fafc;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Мои адреса</h2>
        <div class="row">
            <div class="col-lg-2">
                @include('user.account-nav')
            </div>

            <div class="col-lg-10">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-end mb-4">
                    <a href="{{ route('user.address.add') }}" class="btn btn-primary" style="border-radius: 7px;">
                        <i class="icon-plus"></i> Добавить новый адрес
                    </a>
                </div>

                <div class="wg-box">
                    @if($addresses->count() > 0)
                        <div class="row">
                            @foreach($addresses as $address)
                                <div class="col-md-6 mb-4">
                                    <div class="address-card {{ $address->isdefault ? 'default' : '' }}">
                                        @if($address->isdefault)
                                            <div class="address-badge badge-default">По умолчанию</div>
                                        @endif
                                        
                                        <div class="address-badge badge-{{ $address->type }}">
                                            {{ $address->type == 'home' ? 'Домашний' : ($address->type == 'office' ? 'Рабочий' : 'Другой') }}
                                        </div>
                                        
                                        <div class="mt-2">
                                            <p class="fw-bold mb-1">{{ $address->name }}</p>
                                            <p class="mb-1">{{ $address->address }}</p>
                                            @if($address->locality)
                                                <p class="mb-1">{{ $address->locality }}</p>
                                            @endif
                                            <p class="mb-1">{{ $address->city }}, {{ $address->state }}, {{ $address->country }}</p>
                                            @if($address->landmark)
                                                <p class="mb-1">Ориентир: {{ $address->landmark }}</p>
                                            @endif
                                            <p class="mb-1">Индекс: {{ $address->zip }}</p>
                                            <p class="mb-1">Телефон: {{ $address->phone }}</p>
                                        </div>
                                        
                                        <div class="address-actions">
                                            <a href="{{ route('user.address.edit', $address->id) }}" class="btn btn-sm btn-outline">
                                                <i class="icon-edit-3"></i> Редактировать
                                            </a>
                                            
                                            @if(!$address->isdefault)
                                                <form action="{{ route('user.address.default', $address->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-default" onclick="return confirm('Сделать этот адрес основным?')">
                                                        <i class="icon-star"></i> Сделать основным
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <form action="{{ route('user.address.delete', $address->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить этот адрес?')">
                                                    <i class="icon-trash-2"></i> Удалить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-addresses">
                            <p>У вас пока нет сохранённых адресов</p>
                            <a href="{{ route('user.address.add') }}" class="btn btn-primary" style="border-radius: 7px;">Добавить первый адрес</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
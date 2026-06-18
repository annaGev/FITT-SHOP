@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
<div class="main-content-wrap">

    <div class="flex items-center flex-wrap justify-between gap20 mb-27">
        <h3>Категории</h3>
        <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
            <li><a href="{{ route('admin.index') }}"><div class="text-tiny">Панель управления</div></a></li>
            <li><i class="icon-chevron-right"></i></li>
            <li><div class="text-tiny">Категории</div></li>
        </ul>
    </div>

    <div class="wg-box">

        <div class="table-top-bar">
            <form class="form-search" method="GET">
                <fieldset class="name">
                    <input type="text" placeholder="Поиск по названию..." name="name" value="{{ request('name') }}">
                </fieldset>
                <div class="button-submit">
                    <button type="submit"><i class="icon-search"></i></button>
                </div>
            </form>
            <a class="tf-button style-1 w208" href="{{ route('admin.add.category') }}">
                <i class="icon-plus"></i>Добавить категорию
            </a>
        </div>

        @if(Session::has('status'))
            <div class="table-alert success">{{ Session::get('status') }}</div>
        @endif

        <div class="wg-table-custom">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Категория</th>
                            <th>ЧПУ (Slug)</th>
                            <th class="text-center">Товаров</th>
                            <th class="text-center">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td>
                                <div class="pname">
                                    <div class="image">
                                        <img src="{{ asset('uploads/categories/' . $category->image) }}" alt="{{ $category->name }}">
                                    </div>
                                    <div class="name">
                                        <a href="{{ route('admin.category.edit', $category->id) }}" class="body-title-2">
                                            {{ $category->name }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td><span class="mono">{{ $category->slug }}</span></td>
                            <td class="text-center">
                                <span class="qty-badge">{{ $category->products()->count() }}</span>
                            </td>
                            <td class="text-center">
                                <div class="list-icon-function" style="justify-content: center;">
                                    <a href="{{ route('admin.category.edit', $category->id) }}" class="item edit">
                                        <i class="icon-edit-3"></i>
                                    </a>
                                    <form action="{{ route('admin.category.delete', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="item delete js-confirm-delete">
                                            <i class="icon-trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr class="empty-row">
                            <td colspan="4">Категории не найдены</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="divider"></div>
        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
            {{ $categories->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    $(document).on('click', '.js-confirm-delete', function(){
        if(confirm('Вы уверены, что хотите удалить эту категорию?')){
            $(this).closest('form').submit();
        }
    });
});
</script>
@endpush
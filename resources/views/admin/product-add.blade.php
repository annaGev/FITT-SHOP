@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Добавить товар</h3>
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
                        <a href="{{ route('admin.products') }}">
                            <div class="text-tiny">Товары</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Добавить товар</div>
                    </li>
                </ul>
            </div>

            <!-- form-add-product -->
            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data"
                action="{{ route('admin.product.store') }}">
                @csrf

                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Название товара <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Введите название товара" name="name"
                            value="{{ old('name') }}" required>
                        <div class="text-tiny">Не превышайте 100 символов при вводе названия товара.</div>
                    </fieldset>
                    @error('name')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">ЧПУ (Slug) <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Введите ЧПУ товара" name="slug"
                            value="{{ old('slug') }}" required>
                        <div class="text-tiny">URL-дружественная версия названия товара.</div>
                    </fieldset>
                    @error('slug')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Категория <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="category_id" required>
                                    <option value="">Выберите категорию</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('category_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <fieldset class="brand">
                            <div class="body-title mb-10">Бренд <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="brand_id" required>
                                    <option value="">Выберите бренд</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}"
                                            {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error('brand_id')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Краткое описание <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10 ht-150" name="short_description" placeholder="Краткое описание" required>{{ old('short_description') }}</textarea>
                        <div class="text-tiny">Краткая сводка (рекомендуется до 200 символов).</div>
                    </fieldset>
                    @error('short_description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset class="description">
                        <div class="body-title mb-10">Описание <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Полное описание" required>{{ old('description') }}</textarea>
                        <div class="text-tiny">Полное описание товара.</div>
                    </fieldset>
                    @error('description')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror
                </div>

                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Загрузить главное изображение <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview">
                                <img src="{{ asset('images/upload/upload-1.png') }}" class="effect8" alt="Превью">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Перетащите изображение сюда или <span class="tf-color">нажмите
                                            для выбора</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <fieldset>
                        <div class="body-title mb-10">Загрузить изображения галереи</div>
                        <div class="upload-image mb-16">
                            <!-- Контейнер для превью галереи -->
                            <div id="gallery-preview" class="d-flex flex-wrap gap-2 mb-3"></div>

                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Перетащите изображения сюда или <span class="tf-color">нажмите
                                            для выбора</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('images')
                        <span class="alert alert-danger text-center">{{ $message }}</span>
                    @enderror

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Регулярная цена <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="number" step="0.01" placeholder="Введите регулярную цену"
                                name="regular_price" value="{{ old('regular_price') }}" required>
                        </fieldset>
                        @error('regular_price')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Цена со скидкой</div>
                            <input class="mb-10" type="number" step="0.01" placeholder="Введите цену со скидкой"
                                name="sale_price" value="{{ old('sale_price') }}">
                        </fieldset>
                        @error('sale_price')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Артикул (SKU) <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Введите артикул" name="SKU"
                                value="{{ old('SKU') }}" required>
                        </fieldset>
                        @error('SKU')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Количество <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="number" min="0" placeholder="Введите количество"
                                name="quantity" value="{{ old('quantity') }}" required>
                        </fieldset>
                        @error('quantity')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Наличие</div>
                            <div class="select mb-10">
                                <select name="stock_status">
                                    <option value="instock"
                                        {{ old('stock_status', 'instock') == 'instock' ? 'selected' : '' }}>В наличии
                                    </option>
                                    <option value="outofstock"
                                        {{ old('stock_status') == 'outofstock' ? 'selected' : '' }}>Нет в наличии</option>
                                </select>
                            </div>
                        </fieldset>
                        @error('stock_status')
                            <span class="alert alert-danger text-center">{{ $message }}</span>
                        @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Рекомендуемый</div>
                            <div class="select mb-10">
                                <select name="featured">
                                    <option value="0" {{ old('featured', 0) == 0 ? 'selected' : '' }}>Нет</option>
                                    <option value="1" {{ old('featured') == 1 ? 'selected' : '' }}>Да</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    {{-- ─── Цвета ─────────────────────────────────────────────────────────────── --}}
                    <fieldset>
                        <div class="body-title mb-10">Доступные цвета</div>
                        <div class="d-flex flex-wrap gap-3">
                            @php
                                $adminColors = [
                                    '#0a2472' => 'Темно-синий',
                                    '#d7bb4f' => 'Золотой',
                                    '#282828' => 'Черный',
                                    '#b1d6e8' => 'Голубой',
                                    '#9c7539' => 'Коричневый',
                                    '#d29b48' => 'Янтарный',
                                    '#e6ae95' => 'Персиковый',
                                    '#d76b67' => 'Красный',
                                    '#bababa' => 'Серый',
                                    '#bfdcc4' => 'Светло-зеленый',
                                ];
                            @endphp
                            @foreach ($adminColors as $hex => $name)
                                <label class="d-flex align-items-center gap-2 mb-1" style="cursor:pointer">
                                    <input type="checkbox" name="colors[]" value="{{ $hex }}"
                                        {{ is_array(old('colors')) && in_array($hex, old('colors')) ? 'checked' : '' }}>
                                    <span
                                        style="display:inline-block;width:22px;height:22px;background:{{ $hex }};border-radius:50%;border:1px solid #ccc;flex-shrink:0"></span>
                                    <span class="text-tiny">{{ $name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    {{-- ─── Размеры ─────────────────────────────────────────────────────────────── --}}
                    <fieldset class="mt-3">
                        <div class="body-title mb-10">Доступные размеры</div>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach (['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $sz)
                                <label class="d-flex align-items-center gap-2 mb-1" style="cursor:pointer">
                                    <input type="checkbox" name="sizes[]" value="{{ $sz }}"
                                        {{ is_array(old('sizes')) && in_array($sz, old('sizes')) ? 'checked' : '' }}>
                                    <span class="body-title-2">{{ $sz }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>
                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Добавить товар</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            // Preview main image
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file)).show();
                } else {
                    $("#imgpreview img").attr('src', "{{ asset('images/upload/upload-1.png') }}");
                }
            });

            // Preview gallery images
            $("#gFile").on("change", function(e) {
                const gphotos = this.files;
                $("#gallery-preview").empty();
                $.each(gphotos, function(key, val) {
                    if (!val.type.match('image.*')) return;
                    $("#gallery-preview").append(
                        `<div class="item gitems" style="width:100px;height:100px;overflow:hidden;border:1px solid #ddd;border-radius:4px;">
                    <img src="${URL.createObjectURL(val)}" style="width:100%;height:100%;object-fit:cover;" alt="Изображение галереи">
                </div>`
                    );
                });
            });

            // Auto-generate slug
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        function StringToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    </script>
@endpush

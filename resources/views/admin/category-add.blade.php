@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Информация о категории</h3>
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
                        <a href="{{ route('admin.categories') }}">
                            <div class="text-tiny">Категории</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Новая категория</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Название категории <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите название категории" name="name" tabindex="0"
                           value="{{ old('name') }}" aria-required="true" required="">
                    </fieldset>
                    @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                    <fieldset class="name">
                        <div class="body-title">ЧПУ категории <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите ЧПУ категории" name="slug" tabindex="0"
                            value="{{ old('slug') }}" aria-required="true" required="">
                    </fieldset>
                    @error('slug') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                    <fieldset>
                        <div class="body-title">Загрузить изображение <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview">
                                <img src="{{ asset('images/upload/upload-1.png') }}" class="effect8" alt="Превью">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Перетащите изображение сюда или <span class="tf-color">нажмите для выбора</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {

            // Превью изображения категории
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src', URL.createObjectURL(file)).show();
                } else {
                    $("#imgpreview img").attr('src', "{{ asset('images/upload/upload-1.png') }}");
                }
            });

            // Автогенерация slug из названия категории
            $("input[name='name']").on("change", function() {
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });
        });

        // Функция преобразования текста в slug
        function StringToSlug(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w\s]/g, '')
                .replace(/\s+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    </script>
@endpush

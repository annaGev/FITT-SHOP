@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <!-- main-content-wrap -->
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Слайд</h3>
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
                        <a href="{{ route('admin.slides') }}">
                            <div class="text-tiny">Слайды</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Новый слайд</div>
                    </li>
                </ul>
            </div>
            <!-- new-category -->
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.slide.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Слоган <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите слоган" name="tagline" tabindex="0"
                            value="{{ old('tagline') }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Заголовок <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите заголовок" name="title" tabindex="0"
                            value="{{ old('title') }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Подзаголовок <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите подзаголовок" name="subtitle" tabindex="0"
                            value="{{ old('subtitle') }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Ссылка <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Введите ссылку" name="link" tabindex="0"
                            value="{{ old('link') }}" aria-required="true" required="">
                    </fieldset>
                    <fieldset>
                        <div class="body-title">Загрузить изображение <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none;">
                                <img src="{{ asset('images/upload/upload-1.png') }}" alt="Превью" class="effect8">
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
                    <fieldset class="category">
                        <div class="body-title">Статус</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option value="">Выберите</option>
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Активный</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Неактивный</option>
                            </select>
                        </div>
                    </fieldset>
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Сохранить</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>
@endsection
@push('scripts')
    <script>
        $(function() {
            $("#myFile").on("change", function(e) {
                const [file] = this.files;
                const $preview = $("#imgpreview");
                const $img = $preview.find('img');

                if (file && file.type.startsWith('image/')) {
                    const url = URL.createObjectURL(file);
                    $img.attr('src', url).show();
                    $preview.show();
                    $img.one('load', () => URL.revokeObjectURL(url));
                } else {
                    $preview.hide();
                }
            });
        });
    </script>
@endpush

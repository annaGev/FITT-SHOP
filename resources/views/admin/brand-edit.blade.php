@extends('layouts.admin')
@section('content')
 <div class="main-content-inner">
   <div class="main-content-wrap">
       <div class="flex items-center flex-wrap justify-between gap20 mb-27">
           <h3>Редактирование бренда</h3>
           <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
               <li>
                   <a href="{{ route('admin.index')}}">
                       <div class="text-tiny">Панель управления</div>
                   </a>
               </li>
               <li>
                   <i class="icon-chevron-right"></i>
               </li>
               <li>
                   <a href="{{ route('admin.brands')}}">
                       <div class="text-tiny">Бренды</div>
                   </a>
               </li>
               <li>
                   <i class="icon-chevron-right"></i>
               </li>
               <li>
                   <div class="text-tiny">Редактировать бренд</div>
               </li>
           </ul>
       </div>
       <!-- new-category -->
       <div class="wg-box">
           <form class="form-new-product form-style-1" action="{{ route('admin.brand.update') }}" method="POST"
               enctype="multipart/form-data">
               @csrf
               @method('PUT')
               <input type="hidden" name="id" value="{{ $brand->id }}">
               <fieldset class="name">
                   <div class="body-title">Название бренда <span class="tf-color-1">*</span></div>
                   <input class="flex-grow" type="text" placeholder="Введите название бренда" name="name"
                       tabindex="0" value="{{ $brand->name }}" aria-required="true" required="">
               </fieldset>
               @error('name') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
               <fieldset class="name">
                   <div class="body-title">ЧПУ бренда <span class="tf-color-1">*</span></div>
                   <input class="flex-grow" type="text" placeholder="Введите ЧПУ бренда" name="slug"
                       tabindex="0" value="{{ $brand->slug }}" aria-required="true" required="">
               </fieldset>
               @error('slug') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
               <fieldset>
                   <div class="body-title">Загрузить изображение <span class="tf-color-1">*</span></div>
                   <div class="upload-image flex-grow">
                       @if($brand->image)
                       <div class="item" id="imgpreview">
                           <img src="{{ asset('uploads/brands/' . $brand->image) }}" class="effect8" alt="{{ $brand->name }}">
                       </div>
                       @endif
                       <div id="upload-file" class="item up-load">
                           <label class="uploadfile" for="myFile">
                               <span class="icon">
                                   <i class="icon-upload-cloud"></i>
                               </span>
                               <span class="body-text">Перетащите новое изображение сюда или <span class="tf-color">нажмите для выбора</span></span>
                               <input type="file" id="myFile" name="image" accept="image/*">
                           </label>
                       </div>
                   </div>
               </fieldset>
              @error('image') <span class="alert alert-danger text-center">{{$message}}</span>@enderror
               <div class="bot">
                   <div></div>
                   <button class="tf-button w208" type="submit">Сохранить изменения</button>
               </div>
           </form>
       </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$(function(){
    
    // Превью изображения бренда
    $("#myFile").on("change", function(e){
        const [file] = this.files;
        
        if (file) {
            // Создаем или обновляем превью
            if ($("#imgpreview").length === 0) {
                $(".upload-image").prepend('<div class="item" id="imgpreview"><img src="" class="effect8" alt=""></div>');
            }
            $("#imgpreview img").attr('src', URL.createObjectURL(file)).show();
        }
    });

    // Автогенерация slug из названия бренда
    $("input[name='name']").on("change", function(){
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

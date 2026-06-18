@extends('layouts.app')
@section('content')
@extends('layouts.app')

@section('title', 'Контакты - FITT | Свяжитесь с нами')
@section('description', 'Контактная информация интернет-магазина FITT. Адрес, телефон, email, форма обратной связи. Мы всегда рады ответить на ваши вопросы и помочь с выбором.')
@section('keywords', 'контакты FITT, обратная связь, адрес магазина, телефон интернет магазина, email поддержки, форма связи, задать вопрос')
@section('robots', 'index, follow')

@section('og_title', 'Контакты - FITT')
@section('og_description', 'Свяжитесь с нами: телефон, email, адрес и форма обратной связи интернет-магазина FITT.')
@section('og_image', asset('assets/images/contact/og-contact.jpg'))

@section('twitter_title', 'Контакты - FITT')
@section('twitter_description', 'Свяжитесь с нами: телефон, email, адрес и форма обратной связи интернет-магазина FITT.')
@section('twitter_image', asset('assets/images/contact/twitter-contact.jpg'))

@section('schema_name', 'FITT - Контакты')
@section('schema_description', 'Контактная информация интернет-магазина модной одежды FITT.')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="contact-us container">
            <div class="mw-930">
                <h2 class="page-title">СВЯЗАТЬСЯ С НАМИ</h2>
            </div>
        </section>

        <hr class="mt-2 text-secondary " />
        <div class="mb-4 pb-4"></div>

        <section class="contact-us container">
            <div class="mw-930">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role = "alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                <div class="contact-us__form">
                    <form name="contact-us-form" class="needs-validation" novalidate=""
                        action="{{ route('home.contact.store') }}" method="POST">
                        @csrf
                        <h3 class="mb-5">Обратная связь</h3>
                        <div class="form-floating my-4">
                            <input type="text" class="form-control" name="name" placeholder="Имя *" required="" value="{{ old('name') }}" style="border-radius: 7px;">
                            <label for="contact_us_name">Имя *</label>
                            @error('name')
                                <span style="color:red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating my-4">
                            <input type="text" class="form-control" name="phone" placeholder="Телефон *" required="" value="{{ old('phone') }}" style="border-radius: 7px;">
                            <label for="contact_us_name">Телефон *</label>
                            @error('phone')
                                <span style="color:red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-floating my-4">
                            <input type="email" class="form-control" name="email" placeholder="Адрес электронной почты *"
                                value="{{ old('email') }}" required="" style="border-radius: 7px;">
                            <label for="contact_us_name">Адрес электронной почты *</label>
                            @error('email')
                                <span style="color:red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-4">
                            <textarea class="form-control form-control_gray" name="comment" placeholder="Ваше сообщение" cols="30" rows="8"
                                required="" style="border-radius: 7px;">{{ old('comment') }}</textarea>
                           @error('comment')
                                <span style="color:red;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="my-4">
                            <button type="submit" class="btn btn-primary" style="border-radius: 7px;">Отправить</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
@endsection

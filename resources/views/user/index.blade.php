@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
      <h2 class="page-title">Мой аккаунт</h2>
      <div class="row">
        <div class="col-lg-3">
         @include('user.account-nav')
        </div>
        <div class="col-lg-9">
          <div class="page-content my-account__dashboard">
            <p>Здравствуйте <strong>{{ Auth::user()->name ?? 'Пользователь' }}</strong></p>
            <p>Из панели управления аккаунтом вы можете просматривать свои <a class="unerline-link" href="{{ route('user.orders') }}">недавние заказы</a>, управлять <a class="unerline-link" href="#">адресами доставки</a> и <a class="unerline-link" href="#">редактировать пароль и данные аккаунта.</a></p>
          </div>
        </div>
      </div>
    </section>
</main>

@endsection

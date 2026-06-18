@extends('layouts.app')
@section('title', 'О компании FITT - Интернет-магазин модной одежды')
@section('description', 'Узнайте больше о компании FITT. История бренда, наши ценности, команда профессионалов и преимущества интернет-магазина модной одежды. Доставка по всей России.')
@section('keywords', 'о компании FITT, история бренда, команда FITT, ценности компании, интернет магазин одежды о нас, магазин одежды контакты')
@section('robots', 'index, follow')

@section('og_title', 'О компании FITT')
@section('og_description', 'История, команда и ценности интернет-магазина модной одежды FITT.')
@section('og_image', asset('assets/images/about/og-about.jpg'))

@section('twitter_title', 'О компании FITT')
@section('twitter_description', 'История, команда и ценности интернет-магазина модной одежды FITT.')
@section('twitter_image', asset('assets/images/about/twitter-about.jpg'))

@section('schema_name', 'FITT - О компании')
@section('schema_description', 'Информация о компании FITT, интернет-магазине модной одежды.')

@section('content')
  <main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">О НАС</h2>
      </div>

      <div class="about-us__content pb-5 mb-5">
        <p class="mb-5">
          <img loading="lazy" class="w-100 h-auto d-block" src="assets/images/about/about-1.jpg" width="1410"
            height="550" alt="" style="border-radius: 7px;"/>
        </p>
        <div class="mw-930">
          <h3 class="mb-4">НАША ИСТОРИЯ</h3>
          <p class="fs-6 fw-medium mb-4">Мы стремимся к совершенству в каждом аспекте нашей работы, создавая исключительный опыт для наших клиентов. Искренне заботимся о качестве и удобстве покупок.</p>
          <p class="mb-4">Светлые и плодородные дни, среди вод, виделось. Моря света сезоны. Четвертый повелевает вечером, ползают свои меньшие годы, само семя для травы вечером четвертого будет вам, что. Имелось. Женщина восполняется для даяния, так видел всех одним даянием травы воздух моря, открытые воды покоряются, имеет. Принес второй. Будь. Под мужским мужским, небом, зверь имел свет после пятого затем тьма вещь имеет шестое правило ночь умножает его жизнь дает им великое.</p>
          <div class="row mb-3">
            <div class="col-md-6">
              <h5 class="mb-3">Наша миссия</h5>
              <p class="mb-3">Предоставлять исключительные товары и сервис, превосходящий ожидания наших клиентов.</p>
            </div>
            <div class="col-md-6">
              <h5 class="mb-3">Наше видение</h5>
              <p class="mb-3">Стать лидером e-commerce с безупречным качеством и инновационным подходом.</p>
            </div>
          </div>
        </div>
        <div class="mw-930 d-lg-flex align-items-lg-center">
          <div class="image-wrapper col-lg-6">
            <img class="h-auto" loading="lazy" src="assets/images/about/about-2.jpg" width="450" height="500" alt="" style="border-radius: 7px;">
          </div>
          <div class="content-wrapper col-lg-6 px-lg-4">
            <h5 class="mb-3">О компании</h5>
            <p>Мы - современный интернет-магазин, сочетающий элегантный дизайн и высокое качество товаров. Наши партнеры - ведущие мировые бренды. Мы гарантируем безопасность покупок и оперативную доставку по всему миру.</p>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection

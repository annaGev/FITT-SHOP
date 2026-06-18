@extends('layouts.app')

@section('title', 'Регистрация - FITT')
@section('description',
    'Создайте учетную запись в интернет-магазине FITT, чтобы отслеживать заказы, управлять избранным
    и получать персональные предложения.')
@section('robots', 'noindex, follow')

@section('content')
    <main class="pt-90">
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab"
                        href="#tab-item-register" role="tab" aria-controls="tab-item-register"
                        aria-selected="true">Регистрация</a>
                </li>
            </ul>

            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel"
                    aria-labelledby="register-tab">
                    <div class="register-form">
                        <form method="POST" action="{{ route('register') }}" name="register-form" class="needs-validation"
                            novalidate id="register-form">
                            @csrf

                            <!-- ИМЯ -->
                            <div class="form-floating mb-3">
                                <input class="form-control form-control_gray @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus style="border-radius: 7px;">
                                <label for="name">Имя *</label>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- EMAIL -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email"
                                    class="form-control form-control_gray @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" style="border-radius: 7px;">
                                <label for="email">Email *</label>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- МОБИЛЬНЫЙ ТЕЛЕФОН (отображаемый) -->
                            <div class="form-floating mb-3">
                                <input id="mobile_display" type="tel"
                                    class="form-control form-control_gray @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile') }}" required autocomplete="tel"
                                    maxlength="18" style="border-radius: 7px;">
                                <label for="mobile_display">Телефон *</label>
                                @error('mobile')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <!-- Скрытое поле для чистого номера (11 цифр) -->
                            <input type="hidden" name="mobile" id="mobile">

                            <!-- ПАРОЛЬ -->
                            <div class="form-floating mb-3">
                                <input id="password" type="password"
                                    class="form-control form-control_gray @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" minlength="8" style="border-radius: 7px;">
                                <label for="password">Пароль *</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- ПОДТВЕРЖДЕНИЕ ПАРОЛЯ -->
                            <div class="form-floating mb-3">
                                <input id="password-confirm" type="password" class="form-control form-control_gray"
                                    name="password_confirmation" required autocomplete="new-password" style="border-radius: 7px;">
                                <label for="password-confirm">Подтвердите пароль *</label>
                            </div>

                            <!-- СОГЛАСИЕ -->
                            <div class="d-flex align-items-center mb-3 pb-2">
                                <p class="m-0">Ваши персональные данные будут использоваться для поддержки вашего опыта
                                    на данном сайте, управления доступом к вашей учетной записи и для других целей,
                                    описанных в нашей <a href="#">политике конфиденциальности</a>.</p>
                            </div>

                            <!-- КНОПКА -->
                            <button class="btn btn-primary w-100 text-uppercase" type="submit" style="border-radius: 7px;">
                                Зарегистрироваться
                            </button>

                            <!-- ССЫЛКА НА ВХОД -->
                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">Уже есть учетная запись?</span>
                                <a href="{{ route('login') }}" class="btn-text">Войти</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileDisplay = document.getElementById('mobile_display');
            const mobileHidden = document.getElementById('mobile');
            const form = document.getElementById('register-form');

            if (!mobileDisplay || !mobileHidden) return;

            // Функция для форматирования номера телефона (для отображения)
            function formatPhoneNumber(value) {
                // Удаляем все нецифровые символы
                let digits = value.replace(/\D/g, '');

                // Если номер начинается с 8, заменяем на 7
                if (digits.startsWith('8')) {
                    digits = '7' + digits.substring(1);
                }

                // Ограничиваем длину до 11 цифр (включая 7)
                if (digits.length > 11) {
                    digits = digits.substring(0, 11);
                }

                // Форматируем номер
                let formatted = '';

                if (digits.length > 0) {
                    if (digits.length <= 1) {
                        formatted = '+' + digits;
                    } else if (digits.length <= 4) {
                        formatted = '+' + digits.substring(0, 1) + ' (' + digits.substring(1);
                    } else if (digits.length <= 7) {
                        formatted = '+' + digits.substring(0, 1) + ' (' + digits.substring(1, 4) + ') ' + digits
                            .substring(4);
                    } else if (digits.length <= 9) {
                        formatted = '+' + digits.substring(0, 1) + ' (' + digits.substring(1, 4) + ') ' +
                            digits.substring(4, 7) + '-' + digits.substring(7);
                    } else {
                        formatted = '+' + digits.substring(0, 1) + ' (' + digits.substring(1, 4) + ') ' +
                            digits.substring(4, 7) + '-' + digits.substring(7, 9) + '-' + digits.substring(9, 11);
                    }
                }

                return formatted;
            }

            // Функция для получения чистого номера (только 11 цифр)
            function getCleanNumber(value) {
                let digits = value.replace(/\D/g, '');
                
                // Если номер начинается с 8, заменяем на 7
                if (digits.startsWith('8')) {
                    digits = '7' + digits.substring(1);
                }
                
                // Если 10 цифр (без кода), добавляем 7
                if (digits.length === 10) {
                    digits = '7' + digits;
                }
                
                // Ограничиваем до 11 цифр
                if (digits.length > 11) {
                    digits = digits.substring(0, 11);
                }
                
                return digits;
            }

            // Обновление скрытого поля при вводе
            function updateHiddenField() {
                let cleanNumber = getCleanNumber(mobileDisplay.value);
                mobileHidden.value = cleanNumber;
                
                // Визуальная обратная связь (опционально)
                if (cleanNumber.length === 11) {
                    mobileDisplay.style.borderColor = '#28a745';
                } else {
                    mobileDisplay.style.borderColor = '';
                }
            }

            // Обработчик ввода
            mobileDisplay.addEventListener('input', function(e) {
                let cursorPosition = e.target.selectionStart;
                let oldLength = e.target.value.length;

                e.target.value = formatPhoneNumber(e.target.value);
                updateHiddenField();

                // Корректировка позиции курсора
                let newLength = e.target.value.length;
                let newPosition = cursorPosition + (newLength - oldLength);

                if (cursorPosition === oldLength) {
                    newPosition = newLength;
                }

                e.target.setSelectionRange(newPosition, newPosition);
            });

            // Обработчик фокуса - если поле пустое, устанавливаем +7
            mobileDisplay.addEventListener('focus', function(e) {
                if (!e.target.value) {
                    e.target.value = '+7';
                    updateHiddenField();
                }
            });

            // Обработчик blur - если осталось только +7, очищаем поле
            mobileDisplay.addEventListener('blur', function(e) {
                if (e.target.value === '+7') {
                    e.target.value = '';
                    mobileHidden.value = '';
                }
            });

            // Обработчик клавиш для удаления
            mobileDisplay.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    let value = e.target.value;
                    let digits = value.replace(/\D/g, '');

                    if (digits.length <= 2) {
                        setTimeout(() => {
                            if (digits.length <= 2) {
                                e.target.value = '+7';
                                updateHiddenField();
                            }
                        }, 0);
                    }
                }
            });

            // Валидация перед отправкой формы
            form.addEventListener('submit', function(e) {
                let cleanNumber = mobileHidden.value;
                
                if (cleanNumber.length !== 11) {
                    e.preventDefault();
                    alert('Пожалуйста, введите корректный номер телефона (11 цифр)');
                    mobileDisplay.focus();
                    return false;
                }
            });

            // Инициализация, если есть старое значение
            if (mobileDisplay.value) {
                mobileDisplay.value = formatPhoneNumber(mobileDisplay.value);
                updateHiddenField();
            }
        });
    </script>
@endpush
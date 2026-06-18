@extends('layouts.app')
@section('content')
    <style>
        .btn-primary {
            background: #3b82f6;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #374151;
        }

        .form-group .required {
            color: #ef4444;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            margin: 0;
        }

        .btn-submit {
            background: #3b82f6;
            color: #fff;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #2563eb;
        }

        .btn-back {
            background: #f3f4f6;
            color: #374151;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-right: 12px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #e5e7eb;
        }

        @media (max-width: 768px) {
            .wg-box {
                padding: 20px;
            }
        }
    </style>

    <main class="pt-90" style="padding: 24px 0; background: #f8fafc;">
        <div class="mb-4 pb-4"></div>
        <section class="my-account container">
            <h2 class="page-title">Редактирование адреса</h2>
            <div class="row">
                <div class="col-lg-2">
                    @include('user.account-nav')
                </div>

                <div class="col-lg-10">
                    <div class="wg-box">
                        <form action="{{ route('user.address.update', $address->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Получатель <span class="required">*</span></label>
                                        <input type="text" name="name" value="{{ old('name', $address->name) }}"
                                            required>
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Телефон <span class="required">*</span></label>
                                        <input type="text" name="phone" value="{{ old('phone', $address->phone) }}"
                                            required>
                                        @error('phone')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Индекс <span class="required">*</span></label>
                                        <input type="text" name="zip" value="{{ old('zip', $address->zip) }}"
                                            required>
                                        @error('zip')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Регион / Область <span class="required">*</span></label>
                                        <input type="text" name="state" value="{{ old('state', $address->state) }}"
                                            required>
                                        @error('state')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Город <span class="required">*</span></label>
                                        <input type="text" name="city" value="{{ old('city', $address->city) }}"
                                            required>
                                        @error('city')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Улица, дом <span class="required">*</span></label>
                                        <input type="text" name="address"
                                            value="{{ old('address', $address->address) }}" required>
                                        @error('address')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Район / Микрорайон <span class="required">*</span></label>
                                        <input type="text" name="locality"
                                            value="{{ old('locality', $address->locality) }}" required>
                                        @error('locality')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Ориентир</label>
                                        <input type="text" name="landmark"
                                            value="{{ old('landmark', $address->landmark) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Страна</label>
                                        <input type="text" name="country"
                                            value="{{ old('country', $address->country) }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Тип адреса <span class="required">*</span></label>
                                        <select name="type" required>
                                            <option value="home"
                                                {{ old('type', $address->type) == 'home' ? 'selected' : '' }}>Домашний
                                            </option>
                                            <option value="office"
                                                {{ old('type', $address->type) == 'office' ? 'selected' : '' }}>Рабочий
                                            </option>
                                            <option value="other"
                                                {{ old('type', $address->type) == 'other' ? 'selected' : '' }}>Другой
                                            </option>
                                        </select>
                                        @error('type')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group checkbox-group">
                                        <input type="checkbox" name="isdefault" value="1"
                                            {{ old('isdefault', $address->isdefault) ? 'checked' : '' }}>
                                        <label>Сделать адресом по умолчанию</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <a href="{{ route('user.addresses') }}" class="btn-back">Назад</a>
                                <button type="submit" class="btn-submit">Сохранить изменения</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

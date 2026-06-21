[README_ru.md](https://github.com/user-attachments/files/29175125/README_ru.md)
# FITT — Интернет-магазин модной одежды

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white)

**FITT** — полнофункциональная e-commerce платформа на Laravel, включающая публичный интернет-магазин (storefront) и административную панель (admin panel). Проект разработан в рамках выпускной квалификационной работы (ВКР) по программе СПО.

---

## 📋 Содержание

- [Возможности](#-возможности)
- [Технологии](#-технологии)
- [Структура базы данных](#-структура-базы-данных)
- [Установка](#-установка)
- [Структура маршрутов](#-структура-маршрутов)
- [Структура проекта](#-структура-проекта)
- [Известные ограничения](#-известные-ограничения)
- [Лицензия](#-лицензия)

---

## 🚀 Возможности

### Публичная часть (Storefront)
- 🏠 Главная страница со слайдером, каруселью категорий, акционными товарами
- 🛍️ Каталог с фильтрами (бренд, категория, цена) и сортировкой
- 🔍 AJAX-поиск товаров
- 🛒 Корзина с изменением количества и применением купонов
- ❤️ Список избранного (wishlist)
- 💳 Оформление заказа (checkout) и страница подтверждения
- 👤 Личный кабинет пользователя с историей заказов и возможностью отмены
- 📞 Форма обратной связи

### Админ-панель
- 📊 Дашборд со статистикой и графиками ApexCharts (помесячная динамика)
- 📦 CRUD-управление товарами, категориями и брендами
- 🖼️ Загрузка изображений с автоматической генерацией миниатюр (Intervention Image)
- 🎟️ Система купонов (фиксированные/процентные скидки)
- 📋 Управление заказами и изменение статуса
- 🖼️ Управление слайдером главной страницы
- ✉️ Просмотр сообщений из формы обратной связи

---

## 🛠 Технологии

| Слой | Технология |
|---|---|
| Backend | Laravel (PHP) |
| Frontend | Blade, Bootstrap, jQuery, Swiper.js |
| База данных | MySQL |
| Корзина | `surfsidemedia/shoppingcart` |
| Обработка изображений | Intervention Image |
| Графики | ApexCharts |
| Уведомления | SweetAlert |

---

## 🗄 Структура базы данных

Основные модели:

```
User ─┬─ Order ─┬─ OrderItem ─── Product ─┬─ Category
      │         └─ Transaction           └─ Brand
      └─ Address

Coupon, Slide, Contact, MonthName — вспомогательные модели
```

- **Order** → принадлежит `User`, имеет много `OrderItem` и одну `Transaction`
- **Product** → принадлежит `Category` и `Brand`
- **Address** → связан с `User` (с флагом `isdefault`)

---

## ⚙️ Установка

```bash
# 1. Клонирование репозитория
git clone https://github.com/your-username/fitt.git
cd fitt

# 2. Установка зависимостей
composer install
npm install

# 3. Настройка файла окружения
cp .env.example .env
php artisan key:generate
```

Отредактируй настройки базы данных в `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=fitt
DB_USERNAME=root
DB_PASSWORD=
```

Продолжение установки:

```bash
# 4. Миграции и сидеры (если есть)
php artisan migrate
php artisan migrate:seed

# 5. Storage link (для изображений)
php artisan storage:link

# 6. Сборка фронтенд-ассетов
npm run build

# 7. Запуск сервера разработки
php artisan serve
```

Сайт будет доступен по адресу `http://127.0.0.1:8000`.

> ⚠️ Для входа в админ-панель поле `utype` у пользователя должно быть равно `ADM` (а не `USR`).

---

## 🗺 Структура маршрутов

| Route | Описание |
|---|---|
| `GET /` | Главная страница |
| `GET /shop` | Каталог с фильтрами |
| `GET /shop/{slug}` | Страница товара |
| `GET /cart`, `POST /cart/add` | Управление корзиной |
| `GET /checkout`, `POST /place-an-order` | Оформление заказа |
| `GET /account-orders` | Заказы пользователя |
| `PUT /account-order/{id}/cancel-order` | Отмена заказа |
| `/admin/*` | Админ-панель (middleware `auth` + `AuthAdmin`) |

---

## 📁 Структура проекта

```
app/
├── Http/Controllers/
│   ├── AdminController.php      # Логика админ-панели
│   ├── CartController.php       # Корзина, купоны, checkout
│   ├── HomeController.php       # Главная страница, контакты, поиск
│   ├── ShopController.php       # Каталог, фильтры
│   ├── UserController.php       # Личный кабинет
│   └── WishListController.php   # Избранное
├── Models/                      # Eloquent-модели
resources/views/
├── layouts/                     # app.blade.php, admin.blade.php
├── admin/                       # Шаблоны админ-панели
└── user/                        # Шаблоны личного кабинета
database/migrations/             # Все миграции
```

---

## ⚠️ Известные ограничения

В процессе доработки находятся следующие пункты (открытые issue):

- [ ] `Cart::subtotal()` возвращает строку с разделителем `,` — требует санитизации перед числовыми расчётами
- [ ] В `order_cancel` отсутствует проверка принадлежности заказа пользователю (security gap)
- [ ] Отсутствует rate limiting на формах контактов и поиска
- [ ] Несоответствие символов НДС/$ для русскоязычного интерфейса

PR и issue приветствуются.

---

## 📄 Лицензия

Проект разработан в учебных целях в рамках выпускной квалификационной работы (ВКР) по программе СПО.

---

<p align="center">Made with ❤️ using Laravel</p>

<?php

use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WishListController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_details'])->name('shop.product.details');
Route::get('/sitemap.xml', [HomeController::class, 'sitemap'])->name('sitemap');
// корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add_to_cart'])->name('cart.add');
Route::put('/cart/increase-quantity/{rowId}', [CartController::class, 'increase_cart_quantity'])->name('cart.qty.increase');
Route::put('/cart/decreas-equantity/{rowId}', [CartController::class, 'decrease_cart_quantity'])->name('cart.qty.decrease');
Route::delete('/cart/remove/{rowId}', [CartController::class, 'remove_item'])->name('cart.item.remove');
Route::delete('/cart/clear', [CartController::class, 'empty_cart'])->name('cart.empty');
// apply coupon
Route::post('/cart/apply-coupon', [CartController::class, 'apply_coupon_code'])->name('cart.coupon.apply');
Route::delete('/cart/coupon-remove', [CartController::class, 'remove_coupon_code'])->name('cart.coupon.remove');
// Wishlist
Route::post('/wishlist/add', [WishListController::class, 'add_to_wishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/item/remove/{rowId}', [WishListController::class, 'remove_item'])->name('wishlist.item.remove');
Route::delete('/wishlist/clear', [WishListController::class, 'empty_wishlist'])->name('wishlist.items.clear');
Route::post('/wishlist/move-to-card/{rowId}', [WishListController::class, 'move_to_card'])->name('wishlist.move.to.cart');

// user
Route::middleware(['auth'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});
Route::get('/account-orders', [UserController::class, 'orders'])->name('user.orders');
Route::get('/account-order/{order_id}/details', [UserController::class, 'order_details'])->name('user.order.details');
Route::put('/account-order/{order_id}/cancel-order', [UserController::class, 'order_cancel'])->name('user.order.cancel');
// адреса
Route::get('/account-addresses', [UserController::class, 'addresses'])->name('user.addresses');
Route::get('/account-addresses/add', [UserController::class, 'address_add'])->name('user.address.add');
Route::post('/account-addresses/store', [UserController::class, 'address_store'])->name('user.address.store');
Route::get('/account-addresses/{id}/edit', [UserController::class, 'address_edit'])->name('user.address.edit');
Route::put('/account-addresses/{id}/update', [UserController::class, 'address_update'])->name('user.address.update');
Route::delete('/account-addresses/{id}/delete', [UserController::class, 'address_delete'])->name('user.address.delete');
Route::post('/account-addresses/{id}/set-default', [UserController::class, 'address_set_default'])->name('user.address.default');
// checkout
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('place-an-order', [CartController::class, 'place_an_order'])->name('cart.place.an.order');
Route::get('/order-confirmation', [CartController::class, 'order_confirmation'])->name('cart.order.confirmation');
// Контакты
Route::get('/contact-us', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');
// О нас
Route::get('/about-us', [HomeController::class, 'about'])->name('home.about.us');
// Поиск
Route::get('/search', [HomeController::class, 'search'])->name('home.search');
// админ панель
Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    // бренды
    Route::get('/admin/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::get('/admin/brands/add', [AdminController::class, 'add_brand'])->name('admin.add.brand');
    Route::post('/admin/brand/store', [AdminController::class, 'brand_store'])->name('admin.brand.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit');
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/delete/{id}', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');
    // категории
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'category_add'])->name('admin.add.category');
    Route::post('/admin/category/store', [AdminController::class, 'category_store'])->name('admin.category.store');
    Route::get('admin/category/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'category_update'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'category_delete'])->name('admin.category.delete');
    // продукты
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'product_add'])->name('admin.add.product');
    Route::post('/admin/product/store', [AdminController::class, 'product_store'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'product_edit'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'product_update'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'product_delete'])->name('admin.product.delete');
    // Купоны
    Route::get('/admin/coupons', [AdminController::class, 'coupons'])->name('admin.coupons');
    Route::get('/admin/coupon/add', [AdminController::class, 'coupon_add'])->name('admin.coupon.add');
    Route::post('/admin/coupon/store', [AdminController::class, 'coupon_store'])->name('admin.coupon.store');
    Route::get('/admin/coupon/edit/{id}', [AdminController::class, 'edit_coupon'])->name('admin.coupon.edit');
    Route::put('/admin/coupon/update/{id}', [AdminController::class, 'update_coupon'])->name('admin.coupon.update');
    Route::delete('/admin/coupon/delete/{id}', [AdminController::class, 'coupon_delete'])->name('admin.coupon.delete');
    // заказы
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/order/{order_id}/details', [AdminController::class, 'order_details'])->name('admin.order.details');
    Route::put('/admin/order/update-status', [AdminController::class, 'update_order_status'])->name('admin.order.status.update');
    // слайдер
    Route::get('/admin/slides', [AdminController::class, 'slides'])->name('admin.slides');
    Route::get('/admin/slides/add', [AdminController::class, 'slide_add'])->name('admin.slide.add');
    Route::post('/admin/slides/store', [AdminController::class, 'slide_store'])->name('admin.slide.store');
    Route::get('/admin/slide/{id}/edit', [AdminController::class, 'slide_edit'])->name('admin.slide.edit');
    Route::put('/admin/slide/update', [AdminController::class, 'slide_update'])->name('admin.slide.update');
    Route::delete('/admin/slide/{id}/delete', [AdminController::class, 'slide_delete'])->name('admin.slide.delete');
    // Контакты
    Route::get('/admin/contact', [AdminController::class, 'contacts'])->name('admin.contacts');
    Route::delete('/admin/contact/{id}/delete', [AdminController::class, 'delete_contact'])->name('admin.contact.delete');
    // Поиск
    Route::get('/admin/search', [AdminController::class, 'search'])->name('admin.search');
});

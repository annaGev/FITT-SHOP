<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('cart', ['items' => $items]);
    }

    // public function add_to_cart(Request $request)
    // {
    //     Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
    //     return redirect()->back();
    // }
    public function add_to_cart(Request $request)
    {
        $product = \App\Models\Product::find($request->id);

        if (!$product) {
            return redirect()->back()->with('error', 'Товар не найден.');
        }

        if ($product->stock_status === 'outofstock' || $product->quantity <= 0) {
            return redirect()->back()->with('error', 'Товар "' . $product->name . '" нет в наличии.');
        }

        $requestedQty = (int) $request->quantity;

        // Ищем существующую позицию в корзине
        $cartItem = Cart::instance('cart')->content()
            ->where('id', $product->id)
            ->first();

        $alreadyInCart = $cartItem ? $cartItem->qty : 0;

        if (($alreadyInCart + $requestedQty) > $product->quantity) {
            $available = $product->quantity - $alreadyInCart;
            if ($available <= 0) {
                return redirect()->back()->with('error', 'Вы уже добавили максимальное количество товара.');
            }
            return redirect()->back()->with('error', 'Доступно только ' . $available . ' шт.');
        }

        // Если товар уже в корзине — обновляем количество
        if ($cartItem) {
            Cart::instance('cart')->update($cartItem->rowId, $alreadyInCart + $requestedQty);
        } else {
            Cart::instance('cart')->add(
                $request->id,
                $request->name,
                $requestedQty,
                $request->price,
                [] // пустые options явно
            )->associate('App\Models\Product');
        }

        return redirect()->back()->with('success', 'Товар добавлен в корзину.');
    }

    // public function increase_cart_quantity($rowId)
    // {
    //     $product = Cart::instance('cart')->get($rowId);
    //     $qty = $product->qty + 1;
    //     Cart::instance('cart')->update($rowId, $qty);
    //     return redirect()->back();
    // }
    public function increase_cart_quantity($rowId)
    {
        $cartItem = Cart::instance('cart')->get($rowId);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Товар не найден в корзине.');
        }

        $product = \App\Models\Product::find($cartItem->id);

        if ($product && $cartItem->qty >= $product->quantity) {
            return redirect()->back()->with('error', 'Больше нельзя добавить — доступно только ' . $product->quantity . ' шт.');
        }

        $qty = $cartItem->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);

        return redirect()->back();
    }


    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();
        return redirect()->back();
    }

    /**
     * Применение купона
     */
    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (empty($coupon_code)) {
            return redirect()->back()->with('error', 'Введите код купона');
        }

        // Получаем чистую сумму корзины (убираем форматирование)
        $cartSubtotal = $this->getCartSubtotal();

        $coupon = Coupon::where('code', $coupon_code)
            ->where('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $cartSubtotal)
            ->first();

        if (!$coupon) {
            return redirect()->back()->with('error', 'Неверный или просроченный купон');
        }

        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => floatval($coupon->value),
            'cart_value' => floatval($coupon->cart_value)
        ]);

        $this->calculateDiscount();
        return redirect()->back()->with('success', 'Купон успешно применен');
    }
    /**
     * Получение чистой суммы корзины (без форматирования)
     */
    private function getCartSubtotal()
    {
        $subtotal = Cart::instance('cart')->subtotal();
        // Убираем запятые и пробелы, преобразуем в число
        return floatval(str_replace(',', '', $subtotal));
    }
    /**
     * Расчет скидки
     */
    public function calculateDiscount()
    {
        if (!Session::has('coupon')) {
            return;
        }

        $coupon = Session::get('coupon');
        $subtotal = $this->getCartSubtotal();

        // Расчет скидки
        if ($coupon['type'] == 'fixed') {
            $discount = min($coupon['value'], $subtotal); // Скидка не может быть больше суммы
        } else {
            $discount = ($subtotal * $coupon['value']) / 100;
        }

        $subtotalAfterDiscount = $subtotal - $discount;
        $taxRate = config('cart.tax', 21); // Налоговая ставка (по умолчанию 21%)
        $taxAfterDiscount = ($subtotalAfterDiscount * $taxRate) / 100;
        $totalAfterDiscount = $subtotalAfterDiscount + $taxAfterDiscount;

        Session::put('discounts', [
            'discount' => number_format($discount, 2, '.', ''),
            'subtotal' => number_format($subtotalAfterDiscount, 2, '.', ''),
            'tax' => number_format($taxAfterDiscount, 2, '.', ''),
            'total' => number_format($totalAfterDiscount, 2, '.', ''),
        ]);
    }

    /**
     * Удаление купона из корзины
     */
    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');
        return redirect()->back()->with('success', 'Купон успешно удален');
    }

    /**
     * Страница оформления заказа
     */
    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();
        return view('checkout', compact('address'));
    }

    /**
     * Установка сумм для оформления заказа
     */
    public function setAmountforCheckout()
    {
        if (Cart::instance('cart')->content()->count() <= 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon') && Session::has('discounts')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            $subtotal = $this->getCartSubtotal();
            $taxRate = config('cart.tax', 21);
            $tax = ($subtotal * $taxRate) / 100;
            $total = $subtotal + $tax;

            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => number_format($subtotal, 2, '.', ''),
                'tax' => number_format($tax, 2, '.', ''),
                'total' => number_format($total, 2, '.', ''),
            ]);
        }
    }

    /**
     * Оформление заказа
     */
    public function place_an_order(Request $request)
    {
        $user_id = Auth::user()->id;
        $address = Address::where('user_id', $user_id)->where('isdefault', true)->first();

        if (!$address) {
            $request->validate([
                'name' => 'required|max:100',
                'phone' => 'required',
                'zip' => 'required|numeric|digits:6',
                'state' => 'required',
                'city' => 'required',
                'address' => 'required',
                'locality' => 'required',
                'landmark' => 'required'
            ]);

            $address = new Address();
            $address->name = $request->name;
            $address->phone = $request->phone;
            $address->zip = $request->zip;
            $address->state = $request->state;
            $address->locality = $request->locality;
            $address->city = $request->city;
            $address->landmark = $request->landmark;
            $address->country = 'Arm';
            $address->user_id = $user_id;
            $address->isdefault = true;
            $address->address = $request->address;
            $address->save();
        }

        $this->setAmountforCheckout();

        $checkout = Session::get('checkout');

        // Безопасное получение значений
        $subtotal = isset($checkout['subtotal']) ? floatval($checkout['subtotal']) : 0;
        $discount = isset($checkout['discount']) ? floatval($checkout['discount']) : 0;
        $tax = isset($checkout['tax']) ? floatval($checkout['tax']) : 0;
        $total = isset($checkout['total']) ? floatval($checkout['total']) : 0;

        // Создание заказа
        $order = new Order();
        $order->user_id = $user_id;
        $order->subtotal = $subtotal;
        $order->discount = $discount;
        $order->tax = $tax;
        $order->total = $total;
        $order->name = $address->name;
        $order->phone = $address->phone;
        $order->locality = $address->locality;
        $order->address = $address->address;
        $order->city = $address->city;
        $order->state = $address->state;
        $order->country = $address->country;
        $order->landmark = $address->landmark;
        $order->zip = $address->zip;
        $order->save();

        // Создание позиций заказа
        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->product_id = $item->id;
            $orderItem->order_id = $order->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();

            // Уменьшаем количество товара на складе
            Product::where('id', $item->id)->decrement('quantity', $item->qty);

            // Если количество достигло 0 — ставим outofstock
            $product = Product::find($item->id);
            if ($product && $product->quantity <= 0) {
                $product->quantity = 0;
                $product->stock_status = 'outofstock';
                $product->save();
            }
        }

        // Создание транзакции
        $transaction = new Transaction();
        $transaction->user_id = $user_id;
        $transaction->order_id = $order->id;
        $transaction->mode = $request->mode;
        $transaction->status = 'pending';
        $transaction->save();

        // Очистка
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
        Session::put('order_id', $order->id);

        return redirect()->route('cart.order.confirmation');
    }

    /**
     * Страница подтверждения заказа
     */
    public function order_confirmation()
    {
        if (Session::has('order_id')) {
            $order = Order::with('transaction')->find(Session::get('order_id'));
            return view('order-confirmation', compact('order'));
        }
        return redirect()->route('cart.index');
    }
}

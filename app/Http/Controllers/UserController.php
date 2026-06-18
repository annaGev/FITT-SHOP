<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    // ─── Заказы ──────────────────────────────────────────────────────────────
    public function orders()
    {
        $orders = Order::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->paginate(10);
        return view('user.orders', compact('orders'));
    }

    public function order_details($order_id)
    {
        $order = Order::where('user_id', Auth::user()->id)
            ->where('id', $order_id)
            ->first();

        if ($order) {
            $orderItems  = OrderItem::where('order_id', $order->id)->orderBy('id')->paginate(12);
            $transaction = Transaction::where('order_id', $order->id)->first();
            return view('user.order-details', compact('order', 'orderItems', 'transaction'));
        }

        return redirect()->route('login');
    }

    public function order_cancel(Request $request)
    {
        $order = Order::find($request->order_id);
        $order->status        = 'canceled';
        $order->canceled_date = Carbon::now();
        $order->save();
        return back()->with('status', 'Заказ отменён');
    }

    // ─── Адреса ──────────────────────────────────────────────────────────────
    public function addresses()
    {
        $addresses = Address::where('user_id', Auth::user()->id)
            ->orderBy('isdefault', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('user.addresses', compact('addresses'));
    }

    public function address_add()
    {
        return view('user.address-add');
    }

    public function address_store(Request $request)
    {
        $request->validate([
            'name'     => 'required|max:100',
            'phone'    => 'required',
            'zip'      => 'required',
            'state'    => 'required',
            'city'     => 'required',
            'address'  => 'required',
            'locality' => 'required',
            'type'     => 'required|in:home,office,other',
        ]);

        // Если новый адрес помечается как основной — снимаем флаг с остальных
        if ($request->isdefault) {
            Address::where('user_id', Auth::user()->id)->update(['isdefault' => false]);
        }

        $address           = new Address();
        $address->user_id  = Auth::user()->id;
        $address->name     = $request->name;
        $address->phone    = $request->phone;
        $address->zip      = $request->zip;
        $address->state    = $request->state;
        $address->city     = $request->city;
        $address->address  = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark;
        $address->country  = $request->country ?? 'RU';
        $address->type     = $request->type;
        $address->isdefault = $request->isdefault ? true : false;
        $address->save();

        return redirect()->route('user.addresses')
            ->with('status', 'Адрес успешно добавлен');
    }

    public function address_edit($id)
    {
        $address = Address::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        return view('user.address-edit', compact('address'));
    }

    public function address_update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|max:100',
            'phone'    => 'required',
            'zip'      => 'required',
            'state'    => 'required',
            'city'     => 'required',
            'address'  => 'required',
            'locality' => 'required',
            'type'     => 'required|in:home,office,other',
        ]);

        $address = Address::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        if ($request->isdefault) {
            Address::where('user_id', Auth::user()->id)
                ->where('id', '!=', $id)
                ->update(['isdefault' => false]);
        }

        $address->name      = $request->name;
        $address->phone     = $request->phone;
        $address->zip       = $request->zip;
        $address->state     = $request->state;
        $address->city      = $request->city;
        $address->address   = $request->address;
        $address->locality  = $request->locality;
        $address->landmark  = $request->landmark;
        $address->country   = $request->country ?? 'RU';
        $address->type      = $request->type;
        $address->isdefault = $request->isdefault ? true : false;
        $address->save();

        return redirect()->route('user.addresses')
            ->with('status', 'Адрес успешно обновлён');
    }

    public function address_delete($id)
    {
        $address = Address::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->firstOrFail();

        $address->delete();

        return redirect()->route('user.addresses')
            ->with('status', 'Адрес удалён');
    }

    public function address_set_default($id)
    {
        Address::where('user_id', Auth::user()->id)->update(['isdefault' => false]);

        Address::where('user_id', Auth::user()->id)
            ->where('id', $id)
            ->update(['isdefault' => true]);

        return redirect()->route('user.addresses')
            ->with('status', 'Адрес по умолчанию изменён');
    }
}
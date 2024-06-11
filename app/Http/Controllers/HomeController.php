<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $items = \App\Item::paginate(5);
        return view(('index'), [
            'items' => $items,
        ], );
    }

    public function chat()
    {
        return view('chat');
    }

    public function chart()
    {
        $orders = Order::pluck('orders')->toArray();

        $mergedOrders = [];
        foreach ($orders as $order) {
            $items = explode(', ', $order);
            foreach ($items as $item) {
                list($product, $quantity) = explode('(', rtrim($item, ')'));
                if (!isset ($mergedOrders[$product])) {
                    $mergedOrders[$product] = (int) $quantity;
                } else {
                    $mergedOrders[$product] += (int) $quantity;
                }
            }
        }

        $productNames = array_keys($mergedOrders);
        $productQuantities = array_values($mergedOrders);

        return view('chart', ['orders' => json_encode($productNames), 'counts' => json_encode($productQuantities)]);
    }


    public function alpine()
    {
        $items = \App\Item::paginate(5);
        return view(('alpine'), [
            'items' => $items,
        ], );
    }

    public function textimg()
    {
        return view('textimg');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|digits_between:10,13',
            'email' => 'required',
            'orders' => 'required',
        ], [
            'name.required' => 'Bạn chưa điền tên.',
            'phone.required' => 'Bạn chưa nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 10 đến 13 chữ số.',
            'email.required' => 'Chưa nhập email.',
            'orders.required' => 'Chưa đặt hàng.',
        ]);

        $order = new Order;
        $order->name = $data['name'];
        $order->phone = $data['phone'];
        $order->email = $data['email'];
        $order->note = $request->note;
        $order->orders = $data['orders'];
        $order->total = $request->total;
        $order->save();

        $alert = [
            "type" => "success",
            "title" => __("Thành công"),
            "body" => __("Cảm ơn bạn đã đặt hàng, chúng tôi sẽ sớm phản hồi cho bạn!")
        ];

        return redirect()->back()->with('alert', $alert);
    }
}

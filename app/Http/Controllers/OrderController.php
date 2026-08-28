<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Simpan Pesanan Baru
    public function store(Request $request)
    {
        $request->validate([
            'buyer_name' => 'required',
            'buyer_class' => 'required',
            'payment_method' => 'required|in:COD,QRIS,Transfer',
            'total_price' => 'required|numeric'
        ]);

        Order::create($request->all());

        return redirect()->back()->with('success', 'Pesanan Anda berhasil dibuat dan dikirim ke Admin!');
    }
}
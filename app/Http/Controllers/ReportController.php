<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $report = DB::table('order_details')
            ->join('produks', 'produks.id', '=', 'order_details.id_produk')
            ->select(DB::raw(
                ' nama_barang,
                count(*) as jumlah_dibeli,
                harga,
                SUM(total) as pendapatan,
                SUM(jumlah) as total_qty '
            ))
            ->whereRaw("date(order_details.created_at) >= ' $request->dari'")
            ->whereRaw("date(order_details.created_at) <= ' $request->sampai'")
            ->groupBy('id_produk', 'nama_barang', 'harga')
            ->get();

        return response()->json([
            'data' => $report
        ]);
    }
}

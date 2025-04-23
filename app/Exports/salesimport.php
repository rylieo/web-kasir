<?php

namespace App\Exports;

use App\Models\saless;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class salesimport implements FromCollection, WithHeadings, WithMapping
{
    protected $filter;

    public function __construct($filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = saless::with('customer', 'user', 'detail_sales')->orderBy('id', 'desc');

        if (Auth::user()->role == 'employee') {
            $query->where('user_id', Auth::id());
        }

        // Apply filter
        switch ($this->filter) {
            case 'hari':
                $query->whereDate('sale_date', Carbon::today());
                break;
            case 'minggu':
                $query->whereBetween('sale_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'bulan':
                $query->whereMonth('sale_date', Carbon::now()->month)
                    ->whereYear('sale_date', Carbon::now()->year);
                break;
            case 'tahun':
                $query->whereYear('sale_date', Carbon::now()->year);
                break;
            case 'semua':
            default:
                // No filter
                break;
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'Nama Pembeli',
            'No HP Pembeli',
            'Poin Pembeli',
            'Produk',
            'Total Harga',
            'Total Bayar',
            'Total Diskon Poin',
            'Total Kembalian',
            'Tanggal Pembelian',
        ];
    }

    public function map($item): array
    {
        return [
            optional($item->customer)->name ?? 'Bukan Member',
            optional($item->customer)->no_hp ?? '-',
            optional($item->customer)->point ?? 0,
            $item->detail_sales->map(function ($detail) {
                return optional($detail->product)->name
                    ? optional($detail->product)->name . ' (' . $detail->amount . ' : Rp. ' . number_format($detail->subtotal, 0, ',', '.') . ')'
                    : 'Produk tidak tersedia';
            })->implode(', '),
            $item->detail_sales->sum('subtotal'),
            $item->total_pay,
            $item->total_price - (optional($item->customer)->point ?? 0),
            $item->total_return,
            $item->created_at,
        ];
    }
}

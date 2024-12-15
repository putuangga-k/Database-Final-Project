<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Pengiriman;
use App\Models\Inventaris;
use App\Models\Produk;
use App\Models\Vendor;
use App\Models\Stokis;
use App\Models\Mitra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total produk, vendor, stokis, dan mitra
        $produkCount = Produk::count();
        $vendorCount = Vendor::count();
        $stokisCount = Stokis::count();
        $mitraCount = Mitra::count();

        // Data pembelian per bulan
        $pembelianPerBulan = Pembelian::selectRaw('MONTH(tanggal_pembelian) as bulan, SUM(quantitas_produk) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pembelianLabels = [];
        $pembelianData = [];

        foreach ($pembelianPerBulan as $data) {
            $bulanNama = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $pembelianLabels[] = $bulanNama;
            $pembelianData[] = $data->total;
        }

        // Data pengiriman per bulan
        $pengirimanPerBulan = Pengiriman::selectRaw('MONTH(tanggal_pengiriman) as bulan, SUM(quantitas_produk) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $pengirimanLabels = [];
        $pengirimanData = [];

        foreach ($pengirimanPerBulan as $data) {
            $bulanNama = Carbon::create()->month($data->bulan)->translatedFormat('F');
            $pengirimanLabels[] = $bulanNama;
            $pengirimanData[] = $data->total;
        }

        // Data inventaris per produk
        $inventarisData = Inventaris::with('produk')->get();
        $inventarisLabels = $inventarisData->pluck('produk.nama_produk')->toArray();
        $inventarisValues = $inventarisData->pluck('kuantitas')->toArray();

        // Kirim data ke view
        return view('dashboard', compact(
            'produkCount',
            'vendorCount',
            'stokisCount',
            'mitraCount',
            'pembelianLabels',
            'pembelianData',
            'pengirimanLabels',
            'pengirimanData',
            'inventarisLabels',
            'inventarisValues'
        ));
    }
}
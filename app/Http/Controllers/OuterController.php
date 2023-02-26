<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LowonganKerja;
use App\Models\MitraPerusahaan;
use Illuminate\Contracts\View\View;

final class OuterController extends Controller {
    public function __invoke(): View {
        $perusahaan = MitraPerusahaan::limit(10)->get();
        $lowongan = LowonganKerja::limit(10)
            ->where('active', true)
            ->where('is_approve', true)
            ->where('is_finished', false)
            ->whereHas('tahapan_seleksi')
            ->latest()
            ->get();

        return view('index', compact('lowongan', 'perusahaan'));
    }
}

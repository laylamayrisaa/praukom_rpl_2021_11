<?php

namespace App\Http\Controllers\Perusahaan;

use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use App\Models\LowonganKerja;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class MainController extends Controller {
  public function __invoke(): View {
    $jumlah_alumni = collect(DB::select("SELECT * FROM jumlah_alumni"))
      ->firstOrFail()
      ->jumlah_alumni;

    $jumlah_lowongan = LowonganKerja::whereIdPerusahaan(UserHelper::getCompanyData(Auth::user())->id_perusahaan)
      ->count();

    return view('perusahaan.index', compact('jumlah_alumni', 'jumlah_lowongan'));
  }
}

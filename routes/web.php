<?php

use App\Http\Controllers\{
  // All Auth Controller
  Auth\RegistrationController,
  Auth\AuthenticatedController,
  Auth\LogoutController,
  // All Pengguna Controller
  Admin\Pengguna\AlumniController,
  Admin\Pengguna\MasyarakatController,
  Admin\Pengguna\MitraPerusahaanController,
  // All Master Data Controller
  Admin\MasterData\JurusanController,
  Admin\MasterData\AngkatanController,
  Admin\MasterData\DokumenController,
  // All Perusahaan Controller
  Perusahaan\PelamarController,
  // All Pelamar Controller
  Pelamar\PengalamanKerjaController,
  Pelamar\PendidikanController,
  Pelamar\LowonganKerjaController as PlmrLowonganKerjaController,
  // All Admin and Perusahaan Controller
  AdminDanPerusahaan\LowonganKerjaController as AMPLowonganKerjaController,
  AdminDanPerusahaan\TahapanSeleksiController,
  VerifikasiPendaftaranLowonganController,
};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/sipeka');
Route::prefix('/sipeka')->group(function () {
  Route::get('/', \App\Http\Controllers\OuterController::class)->name('home');

  // Route Lowongan Kerja yand dilihat oleh pelamar
  Route::get('/lowongan-kerja/{lowongan_kerja}', [PlmrLowonganKerjaController::class, 'show'])->name('lowongan_kerja');
  Route::post('/lowongan-kerja/{lowongan_kerja}', [PlmrLowonganKerjaController::class, 'applyJob'])->name('lowongan.apply');

  Route::middleware(['guest'])->group(function () {
    Route::controller(RegistrationController::class)->group(function () {
      Route::get('/register/kandidat', 'kandidat')->name('register.kandidat');
      Route::post('/register/kandidat', 'kandidatStore')->name('register.kandidat.store');
      Route::get('/register/alumni', 'alumni')->name('register.alumni');
      Route::post('/register/alumni', 'alumniStore')->name('register.alumni.store');
    });

    Route::controller(AuthenticatedController::class)->group(function () {
      Route::get('/login', 'index')->name('login');
      Route::post('/login', 'authenticate')->name('login.store');
    });
  });

  Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/logout', LogoutController::class)->name('logout');

    // Dashboard
    Route::prefix('/dashboard')->group(function () {
      // Route Admin BKK
      Route::prefix('/admin')->middleware('role:admin')->group(function () {
        Route::get('/', \App\Http\Controllers\Admin\MainController::class)->name('admin.index');

        Route::prefix('/pengguna')->group(function () {
          Route::prefix('/alumni')->controller(AlumniController::class)->group(function () {
            Route::get('/', 'index')->name('admin.alumni.index');
            Route::get('/tambah', 'create')->name('admin.alumni.create');
            Route::post('/', 'store')->name('admin.alumni.store');
            Route::get('/{nis}/detail', 'show')->name('admin.alumni.detail');
            Route::get('/{nis}/sunting', 'edit')->name('admin.alumni.edit');
            Route::put('/{nis}', 'update')->name('admin.alumni.update');
            Route::delete('/{nis}', 'destroy')->name('admin.alumni.delete');
          });

          Route::prefix('/pelamar')->controller(MasyarakatController::class)->group(function () {
            Route::get('/', 'index')->name('admin.pelamar.index');
            Route::get('/tambah', 'create')->name('admin.pelamar.create');
            Route::post('/', 'store')->name('admin.pelamar.store');
            Route::get('/{username}/detail', 'show')->name('admin.pelamar.detail');
            Route::get('/{username}/sunting', 'edit')->name('admin.pelamar.edit');
            Route::put('/{username}', 'update')->name('admin.pelamar.update');
            Route::delete('/{username}', 'destroy')->name('admin.pelamar.delete');
          });

          Route::prefix('/perusahaan')->controller(MitraPerusahaanController::class)->group(function () {
            Route::get('/', 'index')->name('admin.perusahaan.index');
            Route::get('/tambah', 'create')->name('admin.perusahaan.create');
            Route::post('/', 'store')->name('admin.perusahaan.store');
            Route::get('/{username}/detail', 'show')->name('admin.perusahaan.detail');
            Route::get('/{username}/sunting', 'edit')->name('admin.perusahaan.edit');
            Route::put('/{username}', 'update')->name('admin.perusahaan.update');
            Route::delete('/{username}', 'destroy')->name('admin.perusahaan.delete');
          });
        });

        Route::prefix('/masterdata')->group(function () {
          Route::prefix('/jurusan')->controller(JurusanController::class)->group(function () {
            Route::get('/', 'index')->name('admin.jurusan.index');
            Route::post('/', 'store')->name('admin.jurusan.store');
            Route::get('/{kode_jurusan}/detail', 'show')->name('admin.jurusan.detail');
            Route::put('/{kode_jurusan}', 'update')->name('admin.jurusan.update');
            Route::delete('/{kode_jurusan}', 'destroy')->name('admin.jurusan.delete');
          });

          Route::prefix('/angkatan')->controller(AngkatanController::class)->group(function () {
            Route::get('/', 'index')->name('admin.angkatan.index');
            Route::post('/', 'store')->name('admin.angkatan.store');
            Route::get('/{angkatan}/detail', 'show')->name('admin.angkatan.detail');
            Route::put('/{angkatan}', 'update')->name('admin.angkatan.update');
            Route::delete('/{angkatan}', 'destroy')->name('admin.angkatan.delete');
          });

          Route::prefix('/dokumen')->controller(DokumenController::class)->group(function () {
            Route::get('/', 'index')->name('admin.dokumen.index');
            Route::post('/', 'store')->name('admin.dokumen.store');
            Route::get('/{dokumen}/detail', 'show')->name('admin.dokumen.detail');
            Route::put('/{dokumen}', 'update')->name('admin.dokumen.update');
            Route::delete('/{dokumen}', 'destroy')->name('admin.dokumen.delete');
          });
        });
      });

      // Route Mitra Perusahaan
      Route::prefix('/perusahaan')->middleware('role:perusahaan')->group(function () {
        Route::get('/', \App\Http\Controllers\Perusahaan\MainController::class)->name('perusahaan.index');
        Route::controller(PelamarController::class)->group(function () {
          Route::get('/pelamar', 'index')->name('perusahaan.pelamar.index');
          Route::get('/pelamar/{id}/detail', 'show')->name('perusahaan.pelamar.detail');
        });
      });

      // Route Lowongan oleh Admin dan Mitra Perusahaan
      Route::controller(AMPLowonganKerjaController::class)->prefix('/lowongan')->middleware([
        'role:admin,perusahaan',
        'if_any_company'
      ])->group(function () {
        Route::get('/', 'index')->name('lowongankerja.index');
        Route::get('/tambah', 'create')->name('lowongankerja.create');
        Route::post('/', 'store')->name('lowongankerja.store');
        Route::get('/{lowongan_kerja}/detail', 'show')->name('lowongankerja.detail');
        Route::get('/{lowongan_kerja}/edit', 'edit')->name('lowongankerja.edit');
        Route::put('/{lowongan_kerja}', 'update')->name('lowongankerja.update');
        Route::delete('/{lowongan_kerja}', 'destroy')->name('lowongankerja.delete');
      });

      // Verifikasi lamaran kerja pelamar oleh admin
      Route::post('/pendaftaran-lowongan/verifikasi/{pendaftaran_lowongan}', [VerifikasiPendaftaranLowonganController::class, 'verification'])
        ->name('pendaftaran_lowongan.verifikasi');

      // Route Seleksi oleh Admin dan Mitra Perusahaan
      Route::prefix('/seleksi')->middleware('role:admin,perusahaan')->group(function () {
        Route::controller(TahapanSeleksiController::class)->prefix('/tahapan')->group(function () {
          Route::get('/', 'index')->name('tahapan.seleksi.index');
          Route::get('/{pendaftaran_lowongan}/tambah', 'create')->name('tahapan.seleksi.create');
          Route::post('/{pendaftaran_lowongan}', 'store')->name('tahapan.seleksi.store');
          Route::get('/{pendaftaran_lowongan}/detail', 'jobApplicationDetails')->name('tahapan.seleksi.jobApplicationDetails');
          Route::get('/{pendaftaran_lowongan}/edit/{tahapan_seleksi}', 'edit')->name('tahapan.seleksi.edit');
          Route::put('/{pendaftaran_lowongan}/update/{tahapan_seleksi}', 'update')->name('tahapan.seleksi.update');
          Route::delete('/{pendaftaran_lowongan}/delete/{tahapan_seleksi}', 'destroy')->name('tahapan.seleksi.delete');
        });
      });
    });

    // Route Pelamar (Masyarakat dan Siswa Alumni)
    Route::prefix('/pelamar/{username}')->middleware('role:pelamar')->group(function () {
      Route::get('/profile', fn () => view('pelamar.profile'))->name('pelamar.index');

      Route::prefix('/dokumen')->group(function () {
        Route::get('/', fn () => view('pelamar.dokumen'))->name('pelamar.dokumen');
      });

      Route::prefix('/pengalaman-kerja')->controller(PengalamanKerjaController::class)->group(function () {
        Route::get('/', 'index')->name('pelamar.experience.index');
        Route::get('/tambah', 'create')->name('pelamar.experience.add');
        Route::post('/', 'store')->name('pelamar.experience.store');
        Route::get('/{id}/edit', 'edit')->name('pelamar.experience.edit');
        Route::put('/{id}', 'update')->name('pelamar.experience.update');
        Route::delete('/{id}', 'destroy')->name('pelamar.experience.delete');
      });

      Route::prefix('/pendidikan')->controller(PendidikanController::class)->group(function () {
        Route::get('/', 'index')->name('pelamar.pendidikan.index');
        Route::get('/tambah', 'create')->name('pelamar.pendidikan.add');
        Route::post('/', 'store')->name('pelamar.pendidikan.store');
      });

      Route::prefix('/lamaran-kerja')->group(function () {
        Route::get('/', fn () => view('pelamar.lamaran_kerja.index'))->name('pelamar.lamaran.index');
      });
    });
  });

  // Artisan command
  Route::get('/artisan', function () {
    Artisan::call('about');
    return Artisan::output();
  });
});

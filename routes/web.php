<?php

use App\Http\Controllers\BuscarFlujoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\DocumentosController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\GestionController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        // Crear una instancia del controlador
        $controller = new StatisticsController();
        // Obtener los datos llamando al método index
        $data = $controller->index();

        // Devolver la vista con los datos
        return view('dashboard', $data);
    })->name('dashboard');

    // Rutas para super-admin y admin
    Route::group(['middleware' => ['role:super-admin|admin']], function () {

        Route::resource('permissions', App\Http\Controllers\PermissionController::class);

        Route::resource('roles', App\Http\Controllers\RoleController::class);
        Route::get('roles/{roleId}/delete', [App\Http\Controllers\RoleController::class, 'destroy']);
        Route::get('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'addPermissionToRole']);
        Route::put('roles/{roleId}/give-permissions', [App\Http\Controllers\RoleController::class, 'givePermissionToRole']);

        Route::resource('users', App\Http\Controllers\UserController::class);
        Route::post('users/{user}/toggleStatus', [App\Http\Controllers\UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        // Ruta para el índice de reportes
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

        Route::resource('documentos', DocumentosController::class);
        Route::get('documentos/download/{id}', [DocumentosController::class, 'downloadPdf'])->name('documentos.download');
        Route::get('/generate-cite', [DocumentosController::class, 'generateCite'])->name('generateCite');

        Route::resource('programas', ProgramaController::class);
        Route::get('/dashboard/programas/get-documents/{year}', [ProgramaController::class, 'getDocumentsByYear'])->name('programas.getDocumentsByYear');

        Route::resource('gestion', GestionController::class);
        Route::get('/gestion/documents/{year}', [GestionController::class, 'getDocumentsByYear'])->name('gestion.documents');
    });

});

Route::post('/logout', function (Request $request) {
    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');

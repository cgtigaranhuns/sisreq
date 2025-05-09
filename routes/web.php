<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () { return redirect('/admin'); })->name('login');
/* 
Route::get('/', function () {
    return view('welcome');
});*/
/*
Route::get('requerimentos/{requerimento}/pdf', function (Requerimento $requerimento) {
    if (!$requerimento->pdf_path) {
        abort(404);
    }

    return Storage::download($requerimento->pdf_path);
})->name('requerimentos.pdf.download');*/

Route::get('/requerimento/{id}/download-temp', function ($id) {
    $requerimento = Requerimento::findOrFail($id);
    $pdf = (new AcompanhamentoResource)->gerarPdfRequerimento($requerimento);
    
    return Response::make($pdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment; filename="requerimento-'.$id.'.pdf"'
    ]);
})->name('requerimento.download-temp');
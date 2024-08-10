<?php

use App\Http\Controllers\PdfController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/personal');
});

Route::get('/pdf/generate/timesheet/{user}', [PdfController::class, 'TimesheetRecords'])->name('pdf.example');
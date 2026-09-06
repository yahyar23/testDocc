<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\PlanEvaluator; // مسار مكون Livewire للفحص
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
// 1. مسار عرض صفحة الفحص وإدخال البيانات
Route::get('/plan-evaluator', PlanEvaluator::class)->name('plan.evaluator');

// 2. مسار عرض واستخراج التقرير PDF للطباعة
Route::get('/plan-print/{id}', function ($id) {
    $plan = \App\Models\PatientPlan::findOrFail($id);
    return view('reports.plan-print', compact('plan'));
})->name('plan.print');

Route::get('/', function () {
    return view('welcome');
});

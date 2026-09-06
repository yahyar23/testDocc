<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير الخطة العلاجية - {{ $plan->patient_id }}</title>
    
    <!-- Bootstrap RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- خط Tajawal -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #fff;
            color: #333;
        }
        .report-header {
            border-bottom: 2px solid #0d6efd;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body class="p-4">

    <!-- أزرار التحكم العليا -->
    <div class="no-print d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <a href="javascript:history.back()" class="btn btn-secondary fw-bold">⬅ العودة للخلف</a>
        <button onclick="window.print()" class="btn btn-primary fw-bold">🖨 طباعة / حفظ كـ PDF</button>
    </div>

    <!-- رأس التقرير -->
    <div class="report-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-primary mb-1">🏥 تقرير تقييم الخطة العلاجية</h3>
            <p class="text-muted mb-0">Radiation Therapy Plan Evaluation Report</p>
        </div>
        <div class="text-end">
            <p class="mb-0 fw-bold">تاريخ التقرير: {{ now()->format('Y-m-d') }}</p>
            <small class="text-muted">رقم الخطة: #{{ $plan->id }}</small>
        </div>
    </div>

    <!-- بيانات المريض -->
    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header bg-light fw-bold">👤 معلومات المريض والحالة</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6"><strong>رقم الملف الطبي:</strong> {{ $plan->patient_id ?? '---' }}</div>
                <div class="col-6"><strong>اسم المريض:</strong> {{ $plan->patient_name ?? '---' }}</div>
                <div class="col-6"><strong>تقنية الخطة:</strong> {{ $plan->plan_type ?? '---' }}</div>
                <div class="col-6"><strong>تاريخ الإدخال:</strong> {{ $plan->created_at ? $plan->created_at->format('Y-m-d H:i') : '---' }}</div>
            </div>
        </div>
    </div>

    <!-- المؤشرات المحسوبة -->
    <div class="card mb-4 border-light shadow-sm">
        <div class="card-header bg-light fw-bold">📊 المؤشرات الحسابية (Computed Metrics)</div>
        <div class="card-body">
            <table class="table table-bordered text-center align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Homogeneity Index (HI)</th>
                        <th>Conformity Index (CI)</th>
                        <th>Gradient Index (GI)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="fs-5 fw-bold">{{ $plan->hi_index ?? '---' }}</td>
                        <td class="fs-5 fw-bold">{{ $plan->ci_index ?? '---' }}</td>
                        <td class="fs-5 fw-bold">{{ $plan->gi_index ?? '---' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- التقييم النهائي -->
    <div class="card border-light shadow-sm mb-4">
        <div class="card-header bg-light fw-bold">📋 التقييم النهائي والتوصيات الطبيّة</div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold m-0">الحالة: {{ $plan->status_label ?? '---' }}</h5>
                <span class="badge bg-dark fs-6">NCDI = {{ $plan->ncdi_value ?? '---' }}</span>
            </div>
            <p class="fs-6 text-secondary mb-0">{{ $plan->recommendation ?? 'لا توجد توصيات مدخلة.' }}</p>
        </div>
    </div>

    <!-- تذييل التقرير للتوقيع -->
    <div class="row mt-5 pt-4 text-center">
        <div class="col-6">
            <p class="fw-bold mb-4">الفيزيائي الطبي المسؤول</p>
            <p class="text-muted">---------------------------</p>
        </div>
        <div class="col-6">
            <p class="fw-bold mb-4">اعتماد الطبيب المعالج</p>
            <p class="text-muted">---------------------------</p>
        </div>
    </div>

    <!-- أمر فتح نافذة الطباعة تلقائياً عند تحميل الصفحة -->
    <script>
        window.onload = function() {
            // فتح نافذة الطباعة التلقائية، ويمكن من خلالها اختيار Save as PDF
            setTimeout(() => { window.print(); }, 500);
        };
    </script>
</body>
</html>
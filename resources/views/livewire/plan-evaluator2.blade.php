<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقرير تقييم الخطة العلاجية</title>
    <style>
        body { font-family: sans-serif; direction: rtl; text-align: right; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; color: #0056b3; }
        .section-title { background: #f0f4f8; padding: 8px 12px; font-weight: bold; border-right: 4px solid #0056b3; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 8px; text-align: center; font-size: 13px; }
        th { background-color: #f8f9fa; }
        .badge-green { color: #155724; background-color: #d4edda; padding: 5px; font-weight: bold; }
        .badge-yellow { color: #856404; background-color: #fff3cd; padding: 5px; font-weight: bold; }
        .badge-red { color: #721c24; background-color: #f8d7da; padding: 5px; font-weight: bold; }
        .footer { margin-top: 40px; text-align: left; font-size: 11px; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Radiation Therapy Plan Evaluation Report</h2>
        <p>تقرير تقييم واعتماد خطة العلاج الإشعاعي</p>
    </div>

    <div class="section-title">بيانات المريض والمعالجة</div>
    <table>
        <tr>
            <th>رقم هوية المريض</th>
            <td>{{ $plan->patient_id }}</td>
            <th>اسم المريض</th>
            <td>{{ $plan->patient_name ?? 'غير محدد' }}</td>
        </tr>
        <tr>
            <th>نوع تقنية الخطة</th>
            <td>{{ $plan->plan_type }}</td>
            <th>تاريخ التقييم</th>
            <td>{{ $plan->created_at->format('Y-m-d H:i') }}</td>
        </tr>
    </table>

    <div class="section-title">المدخلات الفيزيائية (Physical Inputs)</div>
    <table>
        <tr>
            <th>D2%</th>
            <th>D50%</th>
            <th>D98%</th>
            <th>V_PTV_Total</th>
            <th>V100%</th>
            <th>V95%</th>
            <th>V50%</th>
        </tr>
        <tr>
            <td>{{ $plan->d2_percent }}</td>
            <td>{{ $plan->d50_percent }}</td>
            <td>{{ $plan->d98_percent }}</td>
            <td>{{ $plan->v_ptv_total }}</td>
            <td>{{ $plan->v100_percent }}</td>
            <td>{{ $plan->v95_percent ?? '-' }}</td>
            <td>{{ $plan->v50_percent }}</td>
        </tr>
    </table>

    <div class="section-title">المؤشرات الحسابية (Calculated Metrics)</div>
    <table>
        <tr>
            <th>Homogeneity Index (HI)</th>
            <th>Conformity Index (CI)</th>
            <th>Gradient Index (GI)</th>
            <th>NCDI Value</th>
        </tr>
        <tr>
            <td>{{ $plan->hi_index ?? 'N/A' }}</td>
            <td>{{ $plan->ci_index ?? 'N/A' }}</td>
            <td>{{ $plan->gi_index ?? 'N/A' }}</td>
            <td><strong>{{ $plan->ncdi_value ?? 'N/A' }}</strong></td>
        </tr>
    </table>

    <div class="section-title">نتيجة التقييم والتوصية الطبية</div>
    <div style="margin-top: 10px; padding: 15px; border: 1px solid #ccc;">
        <p><strong>الحالة:</strong> {{ $plan->status_label }}</p>
        <p><strong>التوصية:</strong> {{ $plan->recommendation }}</p>
    </div>

    <div class="footer">
        طُبع بواسطة نظام RT Plan Evaluator تلقائياً.
    </div>

</body>
</html>
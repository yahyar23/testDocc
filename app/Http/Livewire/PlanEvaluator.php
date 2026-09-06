<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PatientPlan;

class PlanEvaluator extends Component
{
    // 1. تعريف خصائص المدخلات
    public $patient_id;
    public $patient_name;
    public $plan_type = 'Standard';

    public $d2_percent;
    public $d50_percent;
    public $d98_percent;
    public $v_ptv_total;
    public $v100_percent;
    public $v95_percent;
    public $v50_percent;

    // 2. نتائج الحسابات والتقييم
    public $hi_index;
    public $ci_index;
    public $gi_index;
    public $ncdi_value;

    public $passed_gatekeeper = false;
    public $status_level;
    public $status_label;
    public $recommendation;

    public $saved_plan_id;

    // 3. شروط التحقق من البيانات (Validation Rules)
    protected $rules = [
        'patient_id'   => 'required|string',
        'd2_percent'   => 'required|numeric|gt:0',
        'd50_percent'  => 'required|numeric|gt:0',
        'd98_percent'  => 'required|numeric|gt:0',
        'v_ptv_total'  => 'required|numeric|gt:0',
        'v100_percent' => 'required|numeric|gt:0',
        'v50_percent'  => 'required|numeric|gt:0',
    ];

    // 4. الحساب المباشر فور تغير أي قيمة مدخلة (Updated Hook)
    public function updated($propertyName)
    {
        $this->calculateMetrics();
    }

    // 5. دالة الحسابات والمنطق الرياضي
    public function calculateMetrics()
    {
        // التأكد من وجود الأساسيات قبل إجراء الحسابات
        if (!$this->d2_percent || !$this->d50_percent || !$this->d98_percent || !$this->v_ptv_total || !$this->v100_percent || !$this->v50_percent) {
            return;
        }

        // حساب Homogeneity Index (HI)
        // HI = (D2% - D98%) / D50%
        $this->hi_index = round(($this->d2_percent - $this->d98_percent) / $this->d50_percent, 4);

        // حساب Conformity Index (CI)
        if ($this->plan_type === 'SRS_SBRT') {
            // CI = V100% / V_PTV_Total
            $this->ci_index = round($this->v100_percent / $this->v_ptv_total, 4);
        } else {
            // Standard: CI = V95% / V_PTV_Total (إذا لم تتوفر V95 نستخدم V100)
            $v_target = $this->v95_percent ?: $this->v100_percent;
            $this->ci_index = round($v_target / $this->v_ptv_total, 4);
        }

        // حساب Gradient Index (GI)
        // GI = V50% / V100%
        $this->gi_index = round($this->v50_percent / $this->v100_percent, 4);

        // ----------------------------------------------------
        // Stage 1: Conditional Rule-Based Gatekeeper Filtration Loop
        // ----------------------------------------------------
        $is_hi_valid = $this->hi_index <= 0.20;
        $is_ci_valid = ($this->ci_index >= 0.80 && $this->ci_index <= 1.20);
        $is_gi_valid = $this->gi_index <= 5.0;

        if ($is_hi_valid && $is_ci_valid && $is_gi_valid) {
            $this->passed_gatekeeper = true;

            // Stage 2: Multiplicative Coupling (NCDI Calculation)
            // NCDI = CI * GI * HI
            $this->ncdi_value = round($this->ci_index * $this->gi_index * $this->hi_index, 4);

            // Quantitative Stratification Matrix
            $this->evaluateNCDI();
        } else {
            // Boundary Violation Loop (System Halt)
            $this->passed_gatekeeper = false;
            $this->ncdi_value = null;
            $this->status_level = 'system_halt';
            $this->status_label = 'Boundary Violation / Programmatic System Halt';
            $this->recommendation = 'الخطة خوارزمياً غير مقبولة لتجاوز حدود القياس الأساسية (HI > 0.20 أو CI خارج نطاق 0.80-1.20 أو GI > 5.0). يتوجب إعادة التخطيط.';
        }
    }

    // 6. تقييم مستويات NCDI
    private function evaluateNCDI()
    {
        if ($this->ncdi_value <= 0.10) {
            $this->status_level = 'green_light';
            $this->status_label = 'Outstanding / Excellent Plan (Green Light)';
            $this->recommendation = 'Plan Approved: Optimal Dose Distribution. الخطة ممتازة ومعتمدة للتنفيذ مباشرة.';
        } elseif ($this->ncdi_value <= 0.40) {
            $this->status_level = 'green_light';
            $this->status_label = 'High / Clinically Acceptable (Green Light)';
            $this->recommendation = 'Plan Approved: Proceed to Treat. الخطة مقبولة سريرياً ويمكن المضي قدماً في العلاج.';
        } elseif ($this->ncdi_value <= 0.80) {
            $this->status_level = 'yellow_light';
            $this->status_label = 'Borderline / Suboptimal (Yellow Light)';
            $this->recommendation = 'Mandatory Review: Requires Senior Sign. الخطة مقبولة ولكن تتطلب مراجعة واعتماد من الاستشاري المسؤول.';
        } else {
            $this->status_level = 'red_flag';
            $this->status_label = 'Unacceptable Quality / Critical Dose Deficit (Red Flag)';
            $this->recommendation = 'Hard Interruption: Mandatory Re-planning. جودة الخطة غير مقبولة وهناك نقص حاد في الجرعة. يتوجب توقيف الخطة وإعادة التخطيط.';
        }
    }

    // 7. صنف التنبيه المخصص للتصميم (Bootstrap Classes)
    public function getStatusBadgeClass()
    {
        return match ($this->status_level) {
            'green_light' => 'success',
            'yellow_light' => 'warning',
            'red_flag', 'system_halt' => 'danger',
            default => 'secondary',
        };
    }

    // 8. حفظ الخطة في قاعدة البيانات
    public function calculateAndSave()
    {
        $this->validate();
        $this->calculateMetrics();

        $plan = PatientPlan::create([
            'patient_id'        => $this->patient_id,
            'patient_name'      => $this->patient_name,
            'plan_type'         => $this->plan_type,
            'd2_percent'        => $this->d2_percent,
            'd50_percent'       => $this->d50_percent,
            'd98_percent'       => $this->d98_percent,
            'v_ptv_total'       => $this->v_ptv_total,
            'v100_percent'      => $this->v100_percent,
            'v95_percent'       => $this->v95_percent,
            'v50_percent'       => $this->v50_percent,
            'hi_index'          => $this->hi_index,
            'ci_index'          => $this->ci_index,
            'gi_index'          => $this->gi_index,
            'ncdi_value'        => $this->ncdi_value,
            'passed_gatekeeper' => $this->passed_gatekeeper,
            'status_level'      => $this->status_level,
            'status_label'      => $this->status_label,
            'recommendation'    => $this->recommendation,
        ]);

        $this->saved_plan_id = $plan->id;
        session()->flash('message', 'تم حفظ الخطة وتقييمها بنجاح!');
    }

    public function render()
    {
        return view('livewire.plan-evaluator');
    }
}
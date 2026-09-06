<div>
    <!-- Header Summary Bar -->
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <div>
            <h4 class="fw-bold mb-1 text-dark">
                <i class="bi bi-activity text-primary me-2"></i>منصة فحص وتقييم خطط SBRT / SRS
            </h4>
            <span class="text-muted small">SBRT Dosimetric & DVH Analysis Console</span>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-soft-primary text-primary px-3 py-2 border border-primary-subtle rounded-pill">
                <i class="bi bi-shield-check me-1"></i> بروتوكول SBRT المعتمد
            </span>
        </div>
    </div>

    <div class="row g-4">
        <!-- القسم الأيسر: نموذج إدخال البيانات -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-3 border-0 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold small text-uppercase tracking-wider">
                        <i class="bi bi-sliders me-2 text-info"></i>مدخلات خطة SBRT
                    </span>
                    <span class="badge bg-secondary-subtle text-light fs-7">Livewire Sync</span>
                </div>
                
                <div class="card-body p-4 bg-white">
                    <!-- معلومات المريض -->
                    <div class="mb-4">
                        <label class="form-label fs-7 fw-bold text-uppercase text-secondary mb-2">بيانات المريض والمعالجة</label>
                        
                        <div class="mb-3">
                            <label class="form-label small text-dark fw-medium">رقم الملف الطبي (Patient ID)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-vcard"></i></span>
                                <input type="text" wire:model.defer="patient_id" class="form-control bg-light border-start-0 @error('patient_id') is-invalid @enderror" placeholder="مثال: PAT-10092">
                            </div>
                            @error('patient_id') <div class="invalid-feedback d-block small mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label small text-dark fw-medium">اسم المريض الكامل</label>
                            <input type="text" wire:model.defer="patient_name" class="form-control bg-light" placeholder="اسم المريض الثلاثي">
                        </div>

                        <!-- تثبيت نوع التقنية على SBRT دون الحاجة لقائمة اختيار -->
                        <div>
                            <label class="form-label small text-dark fw-medium">تقنية العلاج (Plan Technique)</label>
                            <input type="text" class="form-control bg-light fw-bold text-primary" value="SBRT / SRS (Stereotactic Radiotherapy)" readonly>
                        </div>
                    </div>

                    <div class="my-4 border-top opacity-50"></div>

                    <!-- المدخلات الفيزيائية -->
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <label class="form-label fs-7 fw-bold text-uppercase text-primary mb-0">القيم الفيزيائية (SBRT DVH Statistics)</label>
                            <span class="text-muted fs-8">الوحدة: Gy / cc</span>
                        </div>

                        <!-- D-Metrics Group -->
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="d2_percent" class="form-control form-control-sm @error('d2_percent') is-invalid @enderror" id="d2_inp" placeholder="D2%">
                                    <label for="d2_inp" class="small">D2% (Gy)</label>
                                </div>
                                @error('d2_percent') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="d50_percent" class="form-control form-control-sm @error('d50_percent') is-invalid @enderror" id="d50_inp" placeholder="D50%">
                                    <label for="d50_inp" class="small">D50% (Gy)</label>
                                </div>
                                @error('d50_percent') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-4">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="d98_percent" class="form-control form-control-sm @error('d98_percent') is-invalid @enderror" id="d98_inp" placeholder="D98%">
                                    <label for="d98_inp" class="small">D98% (Gy)</label>
                                </div>
                                @error('d98_percent') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- V-Metrics Group -->
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="v_ptv_total" class="form-control form-control-sm @error('v_ptv_total') is-invalid @enderror" id="vptv_inp" placeholder="V_PTV">
                                    <label for="vptv_inp" class="small">V_PTV_Total (cc)</label>
                                </div>
                                @error('v_ptv_total') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="v100_percent" class="form-control form-control-sm @error('v100_percent') is-invalid @enderror" id="v100_inp" placeholder="V100%">
                                    <label for="v100_inp" class="small">V100% (cc)</label>
                                </div>
                                @error('v100_percent') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-4">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="v95_percent" class="form-control form-control-sm" id="v95_inp" placeholder="V95%">
                                    <label for="v95_inp" class="small">V95% (cc)</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" step="0.0001" wire:model.defer="v50_percent" class="form-control form-control-sm @error('v50_percent') is-invalid @enderror" id="v50_inp" placeholder="V50%">
                                    <label for="v50_inp" class="small">V50% (cc)</label>
                                </div>
                                @error('v50_percent') <span class="text-danger fs-8 d-block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <button wire:click="calculateAndSave" wire:loading.attr="disabled" class="btn btn-primary w-100 fw-bold py-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <span wire:loading.remove wire:target="calculateAndSave">
                            <i class="bi bi-cpu me-1"></i> معالجة وحفظ خطة SBRT
                        </span>
                        <span wire:loading wire:target="calculateAndSave">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                            جاري إجراء حسابات SBRT...
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- القسم الأيمن: عرض النتائج والتقييم اللحظي -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-white p-3 border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-dark">
                        <i class="bi bi-graph-up-arrow text-primary me-2"></i>مؤشرات SBRT الحسابية (Dosimetric Metrics)
                    </span>
                    <span class="badge bg-light text-muted border">Real-time Calculation</span>
                </div>
                
                <div class="card-body p-4">
                    <!-- Cards Grid -->
                    <div class="row g-3 text-center">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border border-light-subtle h-100 position-relative">
                                <span class="text-uppercase fs-8 text-muted fw-bold d-block mb-1">Homogeneity (HI)</span>
                                <div class="fs-3 fw-bolder text-dark mb-1">{{ $hi_index ?? '—' }}</div>
                                <span class="badge bg-white text-secondary border fs-8">الهدف: &le; 0.20</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border border-light-subtle h-100 position-relative">
                                <span class="text-uppercase fs-8 text-muted fw-bold d-block mb-1">Conformity (CI)</span>
                                <div class="fs-3 fw-bolder text-dark mb-1">{{ $ci_index ?? '—' }}</div>
                                <span class="badge bg-white text-secondary border fs-8">الهدف: 0.80 - 1.20</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border border-light-subtle h-100 position-relative">
                                <span class="text-uppercase fs-8 text-muted fw-bold d-block mb-1">Gradient (GI)</span>
                                <div class="fs-3 fw-bolder text-dark mb-1">{{ $gi_index ?? '—' }}</div>
                                <span class="badge bg-white text-secondary border fs-8">الهدف: &le; 5.0</span>
                            </div>
                        </div>
                    </div>

                    <div class="my-4 border-top opacity-50"></div>

                    <!-- التقييم والتصنيف النهائي -->
                    <div class="mb-2">
                        <h6 class="fw-bold text-dark mb-3">مصفوفة تقييم خطط SBRT (Decision Support System)</h6>

                        @if($status_level)
                            <div class="card border-0 bg-{{ $this->getStatusBadgeClass() }}-subtle text-{{ $this->getStatusBadgeClass() }} p-4 rounded-3 shadow-none">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill fs-4"></i>
                                        <h5 class="fw-bold mb-0">{{ $status_label }}</h5>
                                    </div>
                                    <span class="badge bg-dark text-white px-3 py-2 font-monospace">NCDI = {{ $ncdi_value }}</span>
                                </div>
                                <p class="mb-0 fs-6 text-dark opacity-75">{{ $recommendation }}</p>
                            </div>
                        @else
                            <div class="text-center py-5 border rounded-3 bg-light border-dashed">
                                <i class="bi bi-clipboard-data text-muted fs-1 d-block mb-2"></i>
                                <span class="text-muted small">قم بإدخال البيانات الفيزيائية واضغط على "معالجة خطة SBRT" لتوليد التقييم الطبي.</span>
                            </div>
                        @endif
                    </div>

                    <!-- أزرار الإجراءات التكميلية -->
                    @if($saved_plan_id)
                        <div class="mt-4 pt-3 border-top d-flex justify-content-end align-items-center gap-2">
                            <a href="{{ route('plan.print', $saved_plan_id) }}" target="_blank" class="btn btn-outline-danger fw-bold px-4 rounded-3 d-inline-flex align-items-center gap-2">
                                <i class="bi bi-file-earmark-pdf"></i> استخراج التقرير المعتمد (PDF)
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
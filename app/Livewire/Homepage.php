<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctors;
use App\Models\Webpage_content;
use App\Models\OrganizationInfo;
use App\Models\OnlineAppointment;

class Homepage extends Component
{
    public function render()
    {
        $doctors                    =   Doctors::where(['is_active'=> 1])
            ->orderBy('display_position', 'Asc')
            ->get();

        $whyChooseHighlightItem = Webpage_content::where(['type' => 1, 'is_active' => 1,'is_highlight_item'=> 1])
            ->orderBy('display_position', 'DESC')
            ->first();
        $whyChooseItem = Webpage_content::where(['type' => 1, 'is_active' => 1,'is_highlight_item'=> 0])
            ->orderBy('display_position', 'Asc')
            ->limit(3)
            ->get();

        $aboutUsHighlightItem = Webpage_content::where(['type' => 2, 'is_active' => 1,'is_highlight_item'=> 1])
            ->orderBy('display_position', 'DESC')
            ->first();
        $aboutUsItem = Webpage_content::where(['type' => 2, 'is_active' => 1,'is_highlight_item'=> 0])
            ->orderBy('display_position', 'Asc')
            ->limit(3)
            ->get();
        $service_treatment = Webpage_content::where(['type' => 3, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $service_emergency = Webpage_content::where(['type' => 4, 'is_active' => 1])->orderBy('display_position', 'Asc')
            ->get();
        $faqInfo = Webpage_content::where(['type' => 5, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        // Testimonials are now stored in company_infos.testimonials JSON field
        // (legacy Webpage_content type=6 is no longer used for this section)
        $organizationInfo = OrganizationInfo::orderBy('id', 'DESC')->first();
        $pictureItems = Webpage_content::where(['type' => 7, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $videoItems = Webpage_content::where(['type' => 8, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();

        return view('livewire.web.homepage',
            [
                'doctors' => $doctors,
                'whyChooseHighlightItem' => $whyChooseHighlightItem,
                'whyChooseItem' => $whyChooseItem,
                'aboutUsHighlightItem' => $aboutUsHighlightItem,
                'aboutUsItem' => $aboutUsItem,
                'service_treatment' => $service_treatment,
                'service_emergency' => $service_emergency,
                'faqInfo' => $faqInfo,
                'testimonials' => $organizationInfo?->testimonials ?? [],
                'testimonialsHeading' => $organizationInfo?->testimonials_heading ?? 'Testimonials',
                'testimonialsSubtext' => $organizationInfo?->testimonials_subtext ?? '',
                'organizationInfo' => $organizationInfo,
                'pictureItems' => $pictureItems,
                'videoItems' => $videoItems,
            ]
        )
            ->layout('layouts.web_app',
                [
                    'title' => 'Homepage :: Hope centre for cancer surgery and research ' . config('app.name'),
                    'meta_description' => 'Homepage of Hope centre for cancer surgery and research ' . config('app.name'),
                    'organizationInfo' => $organizationInfo,
                ]);
    }

    public $appt_doctor;
    public $appt_date;
    public $appt_name;
    public $appt_phone;
    public $appt_gender;
    public $appt_message;
    public $appt_patient_type = '1';
    public $appt_age;

    // Math captcha
    public $captchaNum1;
    public $captchaNum2;
    public $captchaInput;

    public function mount()
    {
        $this->refreshCaptcha();
    }

    public function refreshCaptcha()
    {
        $this->captchaNum1  = rand(1, 9);
        $this->captchaNum2  = rand(1, 9);
        $this->captchaInput = '';
    }

    protected function appointmentRules(): array
    {
        return [
            'appt_doctor'       => 'required|exists:doctors,id',
            'appt_date'         => 'required|date|after:now',
            'appt_name'         => 'required|string|max:255',
            'appt_phone'        => ['required', 'string', 'max:15', 'regex:/^[0-9+\-\s()]{6,15}$/'],
            'appt_gender'       => 'required|in:male,female,other',
            'appt_patient_type' => 'required|in:1,2',
            'appt_age'          => 'nullable|string|max:10',
            'appt_message'      => 'nullable|string|max:1000',
            'captchaInput'      => 'required|integer',
        ];
    }

    public function submitDoctorAppointment()
    {
        // Rate limit: 3 submissions per IP per 10 minutes
        $key = 'appt_submit_' . request()->ip();
        if (\Illuminate\Support\Facades\RateLimiter::tooManyAttempts($key, 3)) {
            $this->dispatch('swal:error', [
                'title' => 'Too many requests!',
                'text'  => 'Please wait a few minutes before submitting again.',
            ]);
            return;
        }

        $this->validate($this->appointmentRules(), [
            'appt_doctor.required'       => 'Please select a doctor.',
            'appt_date.required'         => 'Please pick an appointment date.',
            'appt_date.after'            => 'Appointment date must be in the future.',
            'appt_name.required'         => 'Patient name is required.',
            'appt_phone.required'        => 'Mobile number is required.',
            'appt_phone.regex'           => 'Enter a valid mobile number.',
            'appt_gender.required'       => 'Please select gender.',
            'appt_patient_type.required' => 'Please select patient type.',
            'captchaInput.required'      => 'Please answer the security question.',
        ]);

        // Verify captcha
        if ((int) $this->captchaInput !== ($this->captchaNum1 + $this->captchaNum2)) {
            $this->addError('captchaInput', 'Incorrect answer. Please try again.');
            $this->refreshCaptcha();
            return;
        }

        \Illuminate\Support\Facades\RateLimiter::hit($key, 600);

        OnlineAppointment::create([
            'doctor_id'    => $this->appt_doctor,
            'date_time'    => $this->appt_date,
            'patient_name' => strip_tags($this->appt_name),
            'mobile'       => $this->appt_phone,
            'gender'       => $this->appt_gender,
            'patient_type' => $this->appt_patient_type,
            'age'          => $this->appt_age,
            'message'      => strip_tags($this->appt_message ?? ''),
            'status'       => 1,
            'created_ip'   => request()->ip(),
        ]);

        $this->reset(['appt_doctor','appt_date','appt_name','appt_phone','appt_gender','appt_message','appt_age']);
        $this->appt_patient_type = '1';
        $this->refreshCaptcha();

        $this->dispatch('swal:success', [
            'title' => 'Request Sent!',
            'text'  => 'Your appointment request has been sent successfully. We will contact you shortly.',
        ]);
    }

}

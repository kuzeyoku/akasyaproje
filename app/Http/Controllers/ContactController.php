<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactRequest;
use App\Models\Page;
use App\Services\ContactService;
use App\Services\RecaptchaService;
use App\Services\SeoService;

class ContactController extends Controller
{
    public function __construct(private ContactService $contactService, private RecaptchaService $recaptchaService, private SeoService $seoService) {}

    public function index()
    {
        $this->seoService->index();
        $recaptcha = $this->recaptchaService->getConfig();
        $privacy_page = Page::active()->whereType('privacy_policy')->first();
        $subjects = [
            'genel' => 'Genel Bilgi',
            'teklif' => 'Teklif Talebi',
            'destek' => 'Teknik Destek',
            'basvuru' => 'İş Başvurusu',
            'ortaklık' => 'Ortaklık Teklifi',
            'diger' => 'Diğer',
        ];

        return view('contact', compact('recaptcha', 'subjects', 'privacy_page'));
    }

    public function send(ContactRequest $request)
    {
        if (! $this->recaptchaService->validation($request->validated())) {
            return back()->with('error', __('front/recaptcha.failed'));
        }
        try {
            $this->contactService->sendMail($request->validated());

            return back()
                ->with('success', __('front/contact.send_success'));
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', __('front/contact.send_error'));
        }
    }
}

<?php

namespace App\Services;

use App\Enums\StatusEnum;
use App\Models\BlockedUser;
use App\Models\Message;
use Exception;
use Illuminate\Support\Facades\Mail;

class ContactService
{
    /**
     * @throws Exception
     */
    public function sendMail(array $data): void
    {

        $this->checkBlocked($data);
        $this->createMessage($data);
        $this->setEmailSettings();
        Mail::to(SettingService::get('contact', 'email'))
            ->send(new \App\Mail\Contact($data));
    }

    /**
     * @throws Exception
     */
    private function checkBlocked($data): void
    {
        $blockedUser = BlockedUser::where('email', $data['email'])
            ->orWhere('ip', request()->ip())
            ->exists();
        if ($blockedUser) {
            throw new Exception(__('front/contact.blocked'));
        }
    }

    private function createMessage($data): Message
    {
        return Message::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => StatusEnum::Unread->value,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            // "consent" => $request->terms
        ]);
    }

    private function setEmailSettings()
    {
        $setting = SettingService::getByCategory('smtp');

        if (empty($setting)) {
            return false;
        }
        config([
            'mail.mailers.smtp.host' => $setting['host'],
            'mail.mailers.smtp.port' => $setting['port'],
            'mail.mailers.smtp.encryption' => $setting['encryption'],
            'mail.mailers.smtp.username' => $setting['username'],
            'mail.mailers.smtp.password' => $setting['password'],
            'mail.from.address' => $setting['from_address'],
            'mail.from.name' => $setting['from_name'],
        ]);
    }
}

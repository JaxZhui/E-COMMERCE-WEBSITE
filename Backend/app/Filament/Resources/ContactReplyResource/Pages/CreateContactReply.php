<?php

namespace App\Filament\Resources\ContactReplyResource\Pages;

use App\Filament\Resources\ContactReplyResource;
use App\Models\ContactReply;
use App\Mail\ContactReplyMail;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CreateContactReply extends CreateRecord
{
    protected static string $resource = ContactReplyResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function afterCreate(): void
    {
        $reply = $this->record;
        $contact = $reply->contact;

        // If send_immediately was checked, send the email
        if ($this->data['send_immediately'] ?? false) {
            try {
                Mail::send(new ContactReplyMail($contact, $reply));
                
                $reply->update([
                    'is_sent' => true,
                    'sent_at' => now(),
                ]);

                // Mark contact as read
                $contact->update(['is_read' => true]);
                
                Notification::make()
                    ->title('Reply sent successfully!')
                    ->body('Email sent to ' . $contact->email)
                    ->success()
                    ->send();
            } catch (\Exception $e) {
                Notification::make()
                    ->title('Failed to send reply')
                    ->body('The reply was saved as draft. Error: ' . $e->getMessage())
                    ->danger()
                    ->send();
            }
        }
    }
}

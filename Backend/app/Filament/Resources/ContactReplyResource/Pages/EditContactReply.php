<?php

namespace App\Filament\Resources\ContactReplyResource\Pages;

use App\Filament\Resources\ContactReplyResource;
use App\Mail\ContactReplyMail;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class EditContactReply extends EditRecord
{
    protected static string $resource = ContactReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('send_now')
                ->label('Send Now')
                ->icon('heroicon-o-paper-airplane')
                ->color('success')
                ->action(function () {
                    $reply = $this->record;
                    $contact = $reply->contact;

                    if ($reply->is_sent) {
                        Notification::make()
                            ->title('Already sent')
                            ->body('This reply has already been sent.')
                            ->warning()
                            ->send();
                        return;
                    }

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
                            ->body('Error: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                })
                ->visible(fn (): bool => !$this->record->is_sent),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

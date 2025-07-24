<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\Contact;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\Action::make('mark_all_as_read')
                ->label('Mark All as Read')
                ->icon('heroicon-o-envelope-open')
                ->color('success')
                ->action(function () {
                    Contact::unread()->update(['is_read' => true]);
                    $this->redirect(request()->header('Referer'));
                })
                ->visible(fn (): bool => Contact::unread()->exists()),
        ];
    }

    // Optional: Auto-mark as read when user visits the contacts page
    public function mount(): void
    {
        parent::mount();
        
        // Uncomment the line below if you want to auto-mark all as read when visiting the page
        // Contact::unread()->update(['is_read' => true]);
    }
}

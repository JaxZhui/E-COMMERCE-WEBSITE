<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContact extends ViewRecord
{
    protected static string $resource = ContactResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    // Mark as read when viewing the contact
    public function mount(int | string $record): void
    {
        parent::mount($record);
        
        if (!$this->record->is_read) {
            $this->record->update(['is_read' => true]);
        }
    }
}

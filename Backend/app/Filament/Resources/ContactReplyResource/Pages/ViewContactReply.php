<?php

namespace App\Filament\Resources\ContactReplyResource\Pages;

use App\Filament\Resources\ContactReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactReply extends ViewRecord
{
    protected static string $resource = ContactReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

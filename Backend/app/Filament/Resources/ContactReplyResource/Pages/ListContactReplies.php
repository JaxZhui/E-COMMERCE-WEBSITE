<?php

namespace App\Filament\Resources\ContactReplyResource\Pages;

use App\Filament\Resources\ContactReplyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactReplies extends ListRecords
{
    protected static string $resource = ContactReplyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactReplyResource\Pages;
use App\Models\ContactReply;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;

class ContactReplyResource extends Resource
{
    protected static ?string $model = ContactReply::class;

    protected static ?string $navigationIcon = 'heroicon-o-paper-airplane';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?string $navigationLabel = 'Email Replies';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('contact_id')
                    ->relationship('contact', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->email})"),
                Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->rows(6),
                Forms\Components\Checkbox::make('send_immediately')
                    ->label('Send email immediately')
                    ->default(true)
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact.name')
                    ->label('Contact')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contact.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Replied By')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_sent')
                    ->boolean()
                    ->label('Status')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
                Tables\Columns\TextColumn::make('sent_at')
                    ->label('Sent At')
                    ->dateTime()
                    ->sortable()
                    ->placeholder('Not sent'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_sent')
                    ->label('Status')
                    ->options([
                        '1' => 'Sent',
                        '0' => 'Draft',
                    ]),
                Tables\Filters\SelectFilter::make('contact_id')
                    ->label('Contact')
                    ->relationship('contact', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Reply Information')
                    ->schema([
                        TextEntry::make('contact.name')
                            ->label('Contact Name'),
                        TextEntry::make('contact.email')
                            ->label('Contact Email')
                            ->copyable(),
                        TextEntry::make('subject')
                            ->label('Subject'),
                        TextEntry::make('user.name')
                            ->label('Replied By'),
                        TextEntry::make('is_sent')
                            ->label('Status')
                            ->badge()
                            ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Sent' : 'Draft'),
                        TextEntry::make('sent_at')
                            ->label('Sent At')
                            ->dateTime()
                            ->placeholder('Not sent yet'),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                    ])
                    ->columns(2),
                Section::make('Reply Message')
                    ->schema([
                        TextEntry::make('message')
                            ->prose()
                            ->hiddenLabel(),
                    ]),
                Section::make('Original Contact Message')
                    ->schema([
                        TextEntry::make('contact.message')
                            ->label('Original Message')
                            ->prose(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactReplies::route('/'),
            'create' => Pages\CreateContactReply::route('/create'),
            'view' => Pages\ViewContactReply::route('/{record}'),
            'edit' => Pages\EditContactReply::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $draftCount = static::getModel()::where('is_sent', false)->count();
        return $draftCount > 0 ? (string) $draftCount : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('is_sent', false)->count() > 0 ? 'warning' : null;
    }
}

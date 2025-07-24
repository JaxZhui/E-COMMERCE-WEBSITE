<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Mail\ContactReplyMail;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Mail;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->required()
                    ->rows(4)
                    ->maxLength(1000),
                Forms\Components\Toggle::make('is_read')
                    ->label('Mark as Read')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\IconColumn::make('is_read')
                    ->boolean()
                    ->trueIcon('heroicon-o-envelope-open')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->label('Status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight(fn (Contact $record): string => $record->is_read ? 'normal' : 'bold'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight(fn (Contact $record): string => $record->is_read ? 'normal' : 'bold'),
                Tables\Columns\TextColumn::make('message')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    })
                    ->weight(fn (Contact $record): string => $record->is_read ? 'normal' : 'bold'),
                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Replies')
                    ->counts('replies')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('is_read')
                    ->label('Status')
                    ->options([
                        '1' => 'Read',
                        '0' => 'Unread',
                    ]),
                Tables\Filters\Filter::make('has_replies')
                    ->label('Has Replies')
                    ->query(fn (Builder $query): Builder => $query->has('replies')),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From Date'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until Date'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\Action::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('info')
                    ->form([
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->default(fn (Contact $record): string => 'Re: Contact from ' . $record->name)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(6)
                            ->placeholder('Type your reply message here...'),
                        Forms\Components\Checkbox::make('send_immediately')
                            ->label('Send email immediately')
                            ->default(true),
                    ])
                    ->action(function (Contact $record, array $data) {
                        $reply = ContactReply::create([
                            'contact_id' => $record->id,
                            'user_id' => auth()->id(),
                            'subject' => $data['subject'],
                            'message' => $data['message'],
                            'is_sent' => $data['send_immediately'],
                            'sent_at' => $data['send_immediately'] ? now() : null,
                        ]);

                        if ($data['send_immediately']) {
                            try {
                                Mail::send(new ContactReplyMail($record, $reply));
                                
                                // Mark contact as read
                                $record->update(['is_read' => true]);
                                
                                Notification::make()
                                    ->title('Reply sent successfully!')
                                    ->body('Email sent to ' . $record->email)
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                $reply->update(['is_sent' => false, 'sent_at' => null]);
                                
                                Notification::make()
                                    ->title('Failed to send reply')
                                    ->body('The reply was saved as draft. Error: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        } else {
                            Notification::make()
                                ->title('Reply saved as draft')
                                ->body('You can send it later from the Email Replies section')
                                ->success()
                                ->send();
                        }
                    }),
                Tables\Actions\Action::make('view_replies')
                    ->label('View Replies')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('gray')
                    ->url(fn (Contact $record): string => '/admin/contact-replies?tableFilters[contact_id][value]=' . $record->id)
                    ->visible(fn (Contact $record): bool => $record->replies()->count() > 0),
                Tables\Actions\Action::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-envelope-open')
                    ->color('success')
                    ->action(function (Contact $record) {
                        $record->update(['is_read' => true]);
                        
                        Notification::make()
                            ->title('Marked as read')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Contact $record): bool => !$record->is_read),
                Tables\Actions\Action::make('mark_as_unread')
                    ->label('Mark as Unread')
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->action(function (Contact $record) {
                        $record->update(['is_read' => false]);
                        
                        Notification::make()
                            ->title('Marked as unread')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Contact $record): bool => $record->is_read),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-envelope-open')
                    ->color('success')
                    ->action(function ($records) {
                        $records->each->update(['is_read' => true]);
                        
                        Notification::make()
                            ->title('Marked ' . $records->count() . ' contacts as read')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\BulkAction::make('mark_as_unread')
                    ->label('Mark as Unread')
                    ->icon('heroicon-o-envelope')
                    ->color('warning')
                    ->action(function ($records) {
                        $records->each->update(['is_read' => false]);
                        
                        Notification::make()
                            ->title('Marked ' . $records->count() . ' contacts as unread')
                            ->success()
                            ->send();
                    }),
                          Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Contact Information')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Full Name'),
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->copyable(),
                        TextEntry::make('is_read')
                            ->label('Status')
                            ->badge()
                            ->color(fn (bool $state): string => $state ? 'success' : 'warning')
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Read' : 'Unread'),
                        TextEntry::make('created_at')
                            ->label('Submitted At')
                            ->dateTime(),
                    ])
                    ->columns(2),
                Section::make('Original Message')
                    ->schema([
                        TextEntry::make('message')
                            ->prose()
                            ->hiddenLabel(),
                    ]),
                Section::make('Replies History')
                    ->schema([
                        TextEntry::make('replies')
                            ->hiddenLabel()
                            ->formatStateUsing(function (Contact $record) {
                                if ($record->replies->isEmpty()) {
                                    return 'No replies sent yet.';
                                }
                                
                                return $record->replies->map(function ($reply) {
                                    $status = $reply->is_sent ? '✅ Sent' : '📝 Draft';
                                    $date = $reply->sent_at ? $reply->sent_at->format('M d, Y g:i A') : 'Not sent';
                                    $repliedBy = $reply->user ? $reply->user->name : 'Unknown';
                                    
                                    return "**{$reply->subject}** ({$status} - {$date})\n" .
                                           "Replied by: {$repliedBy}\n\n" .
                                           "{$reply->message}\n" .
                                           "---";
                                })->join("\n\n");
                            })
                            ->prose(),
                    ])
                    ->visible(fn (Contact $record): bool => $record->replies->isNotEmpty())
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'view' => Pages\ViewContact::route('/{record}'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    // Show only unread contacts count in navigation badge
    public static function getNavigationBadge(): ?string
    {
        $unreadCount = static::getModel()::unread()->count();
        return $unreadCount > 0 ? (string) $unreadCount : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::unread()->count() > 0 ? 'warning' : null;
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        $unreadCount = static::getModel()::unread()->count();
        return $unreadCount > 0 ? "{$unreadCount} unread contact(s)" : null;
    }
}

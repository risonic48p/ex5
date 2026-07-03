<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortLinkResource\Pages;
//use App\Filament\Resources\ShortLinkResource\RelationManagers;
use App\Models\ShortLink;
use App\Models\ShortLinksLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webbingbrasil\FilamentCopyActions\Tables\Actions\CopyAction;
use App\Filament\Resources\ShortLinkResource\RelationManagers\ShortLinksLogsRelationManager;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

final class ShortLinkResource extends Resource
{
    protected static ?string $model = ShortLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'Шортлинк';
    protected static ?string $pluralModelLabel = 'короткие ссылки';
    protected static ?string $navigationLabel = 'Короткие ссылки';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(['user_id' => auth()->id()]);
    }

    public static function infoList(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('url')
                    ->label('Ссылка')
                    ->url(fn (ShortLink $record): string => $record->url)
                    ->openUrlInNewTab(),

                TextEntry::make('shortUrl')
                    ->label('Шортлинк')
                    ->url(fn (ShortLink $record): string => $record->shortUrl)
                    ->openUrlInNewTab()
                    ->state(function (ShortLink $record): string {
                    return $record->shortUrl;
                     }),

                TextEntry::make('shortLinksLogs.count')
                    ->label('Переходов по ссылке')
                    ->state(function (ShortLink $record): string {
                        return $record->shortLinksLogs->count();
                    }),

            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('url')
                    ->required()
                    ->rules(['url'])
                    ->maxLength(500),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label('Оригинальная ссылка')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('hash')
                    ->label('Короткая ссылка')
                    ->prefix(fn (ShortLink $record): string => route('short.redirect', ['hash' => '/']) . '/' )
                    ->url(fn (ShortLink $record): string => $record->shortUrl)
                    ->openUrlInNewTab()
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Подробно'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ShortLinksLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortLinks::route('/'),
            'create' => Pages\CreateShortLink::route('/create'),
            'view' => Pages\ViewShortLink::route('/{record}'),
            'edit' => Pages\EditShortLink::route('/{record}/edit'),
        ];
    }
}

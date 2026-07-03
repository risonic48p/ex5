<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortLinksLogResource\Pages;
//use App\Filament\Resources\ShortLinksLogResource\RelationManagers;
use App\Models\ShortLinksLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ShortLinksLogResource extends Resource
{
    protected static ?string $model = ShortLinksLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Статистика переходов';
    protected static ?string $pluralModelLabel = 'Статистика переходов';
    protected static ?string $navigationLabel = 'Статистика переходов';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(['creator_id' => auth()->id()]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user_ip', 'created_at', 'shortLink.url'];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('shortLink.url')
                    ->required()
                    ->label('Ссылка'),
                Forms\Components\TextInput::make('user_ip')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->header(view('tables.header', [
                'count' => self::getEloquentQuery()->count(),
            ]))
            ->columns([
                Tables\Columns\TextColumn::make('shortLink.url')
                    ->label('Ссылка')
                    ->limit(50)
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_ip')
                    ->label('IP пользователя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Время перехода')
                    ->dateTime('Y-m-d H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),

            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make('view')
                    ->label('Подробно')
                    ->url(fn (ShortLinksLog $record): string => route('filament.admin.resources.short-links.view', ['record' => $record->link_id]))
                    ->openUrlInNewTab()
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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortLinksLogs::route('/'),
        ];
    }
}

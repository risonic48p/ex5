<?php

namespace App\Filament\Resources\ShortLinkResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

final class ShortLinksLogsRelationManager extends RelationManager
{
    protected static string $relationship = 'shortLinksLogs';

    public function getTableHeading(): string
    {
        return 'Статистика переходов';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
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
            ->filters([
                //
            ])
            ->headerActions([

            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

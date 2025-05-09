<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\BannerAdvertisement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerAdvertisementResource\Pages;
use App\Filament\Resources\BannerAdvertisementResource\RelationManagers;

class BannerAdvertisementResource extends Resource
{
    protected static ?string $model = BannerAdvertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('link')
                ->activeUrl()
                ->required()
                ->maxLength(255),

                Forms\Components\FileUpload::make('thumbnail')
                ->required()
                ->image(),

                Forms\Components\Select::make('is_active')
                ->options([
                    'active' => 'Active',
                    'not_active' => 'Not Active',
                ])
                ->required()
                ->default('not_active'),

                Forms\Components\Select::make('type')
                ->options([
                    'banner' => 'Banner',
                    'square' => 'Square',
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('link')
                ->searchable(),

                Tables\Columns\TextColumn::make('is_active')
                ->badge()
                ->color(function ($state) {
                    return match ((string) $state) {
                        'active' => 'success',
                        'not_active' => 'danger',
                        default => 'gray',
                    };
                }),



                Tables\Columns\ImageColumn::make('thumbnail'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBannerAdvertisements::route('/'),
            'create' => Pages\CreateBannerAdvertisement::route('/create'),
            'edit' => Pages\EditBannerAdvertisement::route('/{record}/edit'),
        ];
    }
}

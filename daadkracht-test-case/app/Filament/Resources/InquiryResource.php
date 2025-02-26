<?php

namespace App\Filament\Resources;

use App\Enums\Country;
use App\Enums\Status;
use App\Filament\Resources\InquiryResource\Pages;
use App\Filament\Resources\InquiryResource\RelationManagers;
use App\Models\Category;
use App\Models\Inquiry;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Fieldset::make('Customer Information')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->required()
                            ->tel()
                            ->maxLength(255),
                    ]),
                Fieldset::make('Address Information')
                    ->schema([
                        TextInput::make('addressLine1')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('addressLine2')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('state')
                            ->maxLength(255),
                        TextInput::make('zip')
                            ->required()
                            ->maxLength(255),
                        Select::make('country')
                            ->options(Country::class)
                            ->searchable()
                            ->required(),
                    ]),
                Select::make('category_id')
                    ->name('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('status')
                    ->name('Status')
                    ->options(Status::class)
                    ->default(Status::Pending)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name'),
                TextColumn::make('email')
                    ->sortable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('status')
                    ->getStateUsing(fn($record) => Status::getLabel($record->status))
                    ->color(fn ($record) => Status::getColor($record->status))
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
            RelationManagers\CategoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInquiries::route('/'),
            'create' => Pages\CreateInquiry::route('/create'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}

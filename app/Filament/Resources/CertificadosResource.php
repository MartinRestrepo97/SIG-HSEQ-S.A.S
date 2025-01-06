<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificadosResource\Pages;
use App\Filament\Resources\CertificadosResource\RelationManagers;
use App\Models\Certificados;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;

class CertificadosResource extends Resource
{
    protected static ?string $model = Certificados::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('curso')
                    ->required()
                    ->unique(),
                Forms\Components\DatePicker::make('fecha_inicio')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_fin')
                    ->required(),
                Forms\Components\TextInput::make('norma_cumplida')
                    ->required(),
                Forms\Components\Select::make('estado')
                    ->options([
                        'Activo' => 'Activo',
                        'Vencido' => 'Vencido',
                    ])
                    ->default('Activo')
                    ->required(),
                Forms\Components\FileUpload::make('documento_pdf')
                    ->label('Documento PDF')
                    ->directory('certificados_pdf')
                    ->preserveFilenames()
                    ->acceptedFileTypes(['application/pdf']),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date(),
                Tables\Columns\TextColumn::make('fecha_fin')
                    ->date(),
                Tables\Columns\TextColumn::make('norma_cumplida'),
                Tables\Columns\TextColumn::make('estado')
                    ->icon(fn ($state) => $state === 'Activo' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn ($state) => $state === 'Activo' ? 'success' : 'danger'),   
                Tables\Columns\TextColumn::make('documento_pdf')
                    ->label('PDF')
                    ->searchable(),
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
            RelationManagers\ClientesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificados::route('/'),
            'create' => Pages\CreateCertificados::route('/create'),
            'edit' => Pages\EditCertificados::route('/{record}/edit'),
        ];
    }
}

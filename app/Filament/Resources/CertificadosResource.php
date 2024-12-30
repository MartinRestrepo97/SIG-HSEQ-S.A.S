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

class CertificadosResource extends Resource
{
    protected static ?string $model = Certificados::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('curso')
                    ->required()
                    ->unique(),
                Forms\Components\DatePicker::make('fecha_emision')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_expiracion')
                    ->required(),
                Forms\Components\TextInput::make('norma_cumplida')
                    ->required(),
                Forms\Components\Select::make('estado')
                    ->options([
                        'Active' => 'Activo',
                        'Expired' => 'Vencido',
                    ])
                    ->default('Active')
                    ->required(),
                Forms\Components\FileUpload::make('documento_pdf')
                    ->label('Documento PDF')
                    ->directory('certificados_pdf') // Directorio donde se guardarán los PDFs
                    ->preserveFilenames() // Preservar el nombre original del archivo
                    ->acceptedFileTypes(['application/pdf']), // Aceptar solo archivos PDF
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('fecha_emision')->date(),
                Tables\Columns\TextColumn::make('fecha_expiracion')->date(),
                Tables\Columns\TextColumn::make('norma_cumplida'),
                Tables\Columns\TextColumn::make('estado'),
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

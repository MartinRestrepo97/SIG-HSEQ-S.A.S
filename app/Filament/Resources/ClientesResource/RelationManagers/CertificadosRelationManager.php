<?php

namespace App\Filament\Resources\ClientesResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\DatePicker;
use App\Models\Certificados;


class CertificadosRelationManager extends RelationManager
{
    protected static string $relationship = 'certificados';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curso')
                    ->options(Certificados::all()->pluck('curso','id'))
                    ->required(),
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')->date(),
                Tables\Columns\TextColumn::make('fecha_fin')->date(),
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
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\AttachAction::make()
                    ->form(fn (Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\DatePicker::make('fecha_inicio_validez')
                            ->label('Fecha Inicio Validez'),
                        Forms\Components\DatePicker::make('fecha_fin_validez')
                            ->label('Fecha Fin Validez'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('curso')
                                    ->options(Certificados::all()->pluck('curso','id'))
                                    ->required(),
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
                                Forms\Components\DatePicker::make('fecha_inicio_validez')
                                    ->required(),
                                Forms\Components\DatePicker::make('fecha_fin_validez')
                                    ->required(),
                            ])        
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
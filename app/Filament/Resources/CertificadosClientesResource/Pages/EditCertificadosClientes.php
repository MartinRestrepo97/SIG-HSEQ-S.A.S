<?php

namespace App\Filament\Resources\CertificadosClientesResource\Pages;

use App\Filament\Resources\CertificadosClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificadosClientes extends EditRecord
{
    protected static string $resource = CertificadosClientesResource::class;

    // Sobrescribir el método para redirigir al listado después de editar
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

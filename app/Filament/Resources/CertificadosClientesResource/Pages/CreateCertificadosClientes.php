<?php

namespace App\Filament\Resources\CertificadosClientesResource\Pages;

use App\Filament\Resources\CertificadosClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificadosClientes extends CreateRecord
{
    protected static string $resource = CertificadosClientesResource::class;

    // Sobrescribir el método para redirigir al listado después de crear
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index'); // Redirige al listado
    }

    protected function getCreatedNotificationMessage(): ?string
    {
        return 'Certificado_Cliente creado exitosamente'; // Mensaje personalizado
    }
}

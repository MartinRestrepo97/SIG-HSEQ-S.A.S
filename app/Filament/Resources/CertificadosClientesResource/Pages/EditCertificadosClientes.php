<?php

namespace App\Filament\Resources\CertificadosClientesResource\Pages;

use App\Filament\Resources\CertificadosClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCertificadosClientes extends EditRecord
{
    protected static string $resource = CertificadosClientesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

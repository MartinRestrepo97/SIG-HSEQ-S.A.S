<?php

namespace App\Filament\Resources\CertificadosClientesResource\Pages;

use App\Filament\Resources\CertificadosClientesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCertificadosClientes extends ListRecords
{
    protected static string $resource = CertificadosClientesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

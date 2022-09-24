<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Models\Brand;
use Filament\Pages\Actions;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\BrandResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\MarkdownEditor;

class CreateBrand extends CreateRecord 
{
    protected static string $resource = BrandResource::class;

}

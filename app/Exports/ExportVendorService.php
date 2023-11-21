<?php

namespace App\Exports;

use App\User;
use App\VendorService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportVendorService implements FromCollection, WithHeadings, WithStyles
{
    public $service;
    public function __construct($service)
    {
        $this->service = $service;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 16]],

        ];
    }
    public function headings(): array
    {
        return [
            'Business name',
            'Full address',
            'Service name',
            'Actual price',
            'Discount',
            'List price'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  $this->service;
    }
}

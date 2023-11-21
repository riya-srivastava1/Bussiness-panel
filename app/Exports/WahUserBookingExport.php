<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WahUserBookingExport implements FromCollection, WithHeadings, WithStyles
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true, 'size' => 12]],

        ];
    }

    public function headings(): array
    {
        return [
            'User Name',
            'User Phone',
            'Artist Name',
            'Artist Phone',
            'Service Name',
            'Booking Date',
            'Booking Time',
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  $this->data;
    }
}

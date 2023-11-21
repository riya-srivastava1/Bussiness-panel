<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportVendorBooking implements FromCollection, WithHeadings, WithStyles
{
    public $vendorPhoneEmail;
    public function __construct($vendorPhoneEmail)
    {
        $this->vendorPhoneEmail = $vendorPhoneEmail;
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
            'Owner Name',
            'Email',
            'Gender',
            'Phone',
            'city',
            'locality',
            'Full Address',
            'zipcode',
            'Booking Count',
            'Completed Booking'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  $this->vendorPhoneEmail;
    }
}

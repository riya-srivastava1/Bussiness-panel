<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WahBookingExport implements FromCollection, WithHeadings,WithStyles
{
    public $data;
    public function __construct($data)
    {
        $this->data = $data;
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
            'name',
            'phone',
            'city',
            'booking_date_time',
            'amount',
            'coupon_wallet_discount',
            'discount_media',
            'net_amount',
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

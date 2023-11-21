<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserBookingExport implements FromCollection, WithHeadings, WithStyles
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
            'business_name',
            'location',
            'order_id',
            'services',
            'datetime',
            'amount',
            'coupon_wallet_discount',
            'discount_media',
            'save_amount',
            'net_amount',
            'pay_with',
            'created_at',
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

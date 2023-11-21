<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithHeadings
{
    public $users;
    public function __construct($users)
    {
        $this->users = $users;
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
            'email',
            'phone',
            'booking_date_time',
            'type',
            'city',
            'registered_date',
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  $this->users;
    }
}

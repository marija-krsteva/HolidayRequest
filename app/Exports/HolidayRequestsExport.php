<?php

namespace App\Exports;

use App\Models\HolidayRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class HolidayRequestsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $manager_requests;

    /**
     * HolidayRequestsExport constructor.
     * @param $manager_requests
     */
    public function __construct($manager_requests)
    {
        $this->manager_requests = $manager_requests;
    }

    /**
     * The headers in the .csv file
     *
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'First Name',
            'Last Name',
            'Email',
            'Phone number',
            'Start date',
            'End date',
        ];
    }

    /**
     * The collection that will be be saved in the .csv file
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $requestForExport = $this->manager_requests->map(function ($item, $key) {
            return [
                'firstname' => $item->firstname,
                'lastname' => $item->lastname,
                'email' => $item->email,
                'phone_number' => $item->phone_number,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
            ];
        });
        return $requestForExport;

    }
}

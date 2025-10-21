<?php

namespace App\Exports;

use App\Models\SupplyRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SupplyReportsExport implements FromCollection, WithHeadings
{
    protected $status;
    protected $startDate;
    protected $endDate;

    public function __construct($status = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = SupplyRequest::query();

        if (!empty($this->status)) {
            $query->where('request_status', $this->status);
        }

        if ($this->status === 'Completed' && !empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('updated_at', [$this->startDate, $this->endDate]);
        }

        return $query->select('name', 'email', 'supply_name', 'quantity', 'date_completed', 'request_status')->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Supply Requested', 'Quantity', 'Date Completed', 'Status'];
    }
}

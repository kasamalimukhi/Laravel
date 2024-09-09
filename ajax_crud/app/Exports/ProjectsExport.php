<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProjectsExport implements FromCollection, WithHeadings
{
    protected $projects;

    // Modify constructor to accept dynamic projects
    public function __construct($projects)
    {
        $this->projects = $projects;
    }

    // Return the collection of projects dynamically
    public function collection()
    {
        return $this->projects;
    }

    // Define the headings for the export
    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Name',
            'Description',
            'Author',
            'Prize',
        ];
    }
}

<?php

namespace App\Imports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class ProjectsImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new Project([
            'id'          => $row['id'], 
            'title'       => $row['title'],
            'name'        => $row['name'],
            'description' => $row['description'],
            'author'      => $row['author'],
            'prize'       => is_numeric($row['prize']) ? $row['prize'] : 0,
        ]);
    }
}

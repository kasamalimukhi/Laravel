<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProjectsImport;
use App\Exports\ProjectsExport;
use Exception;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $projects = Project::all();
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // Validate the request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'author' => 'required|string|max:255',
            'prize' => 'required|numeric',
        ]);

        // Create a new projects record
        $project = Project::create($validated);


        // Redirect to a specific route with a success message
        return response()->json([
            'success' => 'project created successfully.',
            'customer' => $project
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $project = Project::findOrFail($id);
        return response()->json($project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json([
            'message' => 'Your data is updated',
            'id' => $project->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Project::destroy($id);
        return response()->json([
            'message' => 'Your data is deleted successfully',
            'id' => $id
        ]);
    }

    // Bulk delete method
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            // Delete the projects with the given IDs
            Project::whereIn('id', $ids)->delete();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'No items selected']);
    }

    public function fetchProjects()
    {
        // $projects = Project::all();
        // return view('projects.project-rows', compact('projects'))->render();


        $projects = Project::all();
        return response()->json($projects);
    }

    public function exportProjects(Request $request)
    {

        try {
            // Check if specific project IDs were selected
            $selectedIds = $request->input('selected_ids');

            // Fetch the selected projects or all projects if no selection
                // if (!empty($selectedIds)) {
                //     $projects = Project::select('id', 'title', 'name', 'description', 'author', 'prize')
                //         ->whereIn('id', $selectedIds)
                //         ->get();
                // } else {
                //     $projects = Project::select('id', 'title', 'name', 'description', 'author', 'prize')->get();
                // }

                // Using Ternary Operator for more concise and removes redundancy
                $projects = !empty($selectedIds)
                    ? Project::select('id', 'title', 'name', 'description', 'author', 'prize')
                        ->whereIn('id', $selectedIds)
                        ->get()
                    : Project::select('id', 'title', 'name', 'description', 'author', 'prize')
                        ->get();
            //

            // Define the file path for saving the CSV
            $filePath = 'export/projects.csv';

            // Export the projects to a CSV using the modified ProjectsExport class
            Excel::store(new ProjectsExport($projects), $filePath, 'public');

            // Return the file as a download response
            return response()->json(['fileUrl' => asset('storage/' . $filePath)]);

        } catch (Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function importProjects(Request $request)
    {

        try {
            // Validate the file
            $request->validate([
                'csvFile' => 'required|mimes:csv,txt|max:5120' // Ensure it’s a CSV or TXT file and is within size limits
            ]);

            // Handle the import using Laravel Excel or another package
            Excel::import(new ProjectsImport, $request->file('csvFile'));

            return response()->json(['success' => 'Data imported successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function exportProjectsPdf()
    {
        try {
            $projects = Project::all();

            $data = [
                'title' => 'Welcome to MKcode.com',
                'date' => date('m/d/Y'),
                'projects' => $projects
            ];

            // Load the view for the PDF and pass the data
            $pdf = Pdf::loadView('projects.pdf', $data);

            // Define the file name for the download
            $fileName = 'projects.pdf';

            // Return the PDF as a download response
            return $pdf->download($fileName);
        } catch (Exception $e) {
            // Handle any exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $projects = Project::where('title', 'LIKE', "%$query%")
            ->orWhere('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->orWhere('author', 'LIKE', "%$query%")
            ->get();

            if ($projects->isEmpty()) {
                return response('<tr><td colspan="7">No results found</td></tr>');
            }

        // Return only the rows to update the table body
        $output = '';
        foreach ($projects as $project) {
            $output .= '
            <tr>
                <td>' . $project->id . '</td>
                <td>' . $project->title . '</td>
                <td>' . $project->name . '</td>
                <td>' . $project->description . '</td>
                <td>' . $project->author . '</td>
                <td>' . $project->prize . '</td>
                <td>
                    <input type="checkbox" name="selected_ids[]" value="' . $project->id . '">
                    <button class="btn btn-info btn-show" data-id="' . $project->id . '">Show</button>
                    <button class="btn btn-success btn-edit" data-id="' . $project->id . '">Edit</button>
                    <button type="submit" class="btn btn-danger btn-sm ms-3 btn-delete" data-id="' . $project->id . '">Delete</button>
            </td>
            </tr>
        ';
        }


        return response($output);
        // return response()->json($projects);
    }

}

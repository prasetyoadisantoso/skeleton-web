<?php

namespace App\Http\Controllers\Testing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class Pagination extends Controller
{
    public function get_post(Request $request)
    {

        $perPage = 10; // Number of items per page
        $page = $request->input('page', 1); // Current page number, default is 1

        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        // Get the JSON response body
        $data = $response->json();

        // Get the data to be paginated
        $allData = collect($data); // Assuming data is provided in a 'data' key

        // Create a LengthAwarePaginator instance manually
        $paginator = new LengthAwarePaginator(
            $allData->forPage($page, $perPage), // Items for the current page
            count($allData), // Total number of items
            $perPage, // Items per page
            $page, // Current page
            ['path' => $request->url(), 'query' => $request->query()] // Additional pagination options
        );

        return response()->json($paginator);
    }
}

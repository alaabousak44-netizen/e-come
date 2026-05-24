<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'destination_interest' => ['required', 'string', 'max:100'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $travelRequest = TravelRequest::create($validated);

        return redirect()
            ->route('travel-requests.sent')
            ->with('request_reference', $travelRequest->id);
    }

    public function sent(): View
    {
        return view('requests.sent');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SubscribeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Website $website)
    {
        // Validate
        $validated = $request->validate(
            [
                'name' => ['nullable'],
                'email' => ['required', 'email']
            ],
        );

        // Create and Attach
        $user = User::where('website_id', $website->id)->where('email', $validated['email'])->first();
        if ($user) {
            return response()->json([
                'email' => 'This email is already subscribed to this website.'
            ], 422);
        }

        $user = $website->users()->create($validated);

        // Response
        return response()->json([
            'data' => [
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email
                ]
            ]
        ], 201);
    }
}

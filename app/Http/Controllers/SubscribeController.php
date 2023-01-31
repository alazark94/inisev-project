<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
                'email' => ['required', 'email', Rule::unique('users', 'email')]
            ],
            $messages = [
                'email.unique' => 'The email you provide has already subscribed for the given website'
            ]
        );

        // Create and Attach
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

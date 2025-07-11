<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException; // Add this for sendResetLinkEmail and reset methods

class PasswordController extends Controller
{
    use ResetsPasswords, SendsPasswordResetEmails {
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
        SendsPasswordResetEmails::broker insteadof ResetsPasswords;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/login'; // Redirect to admin login after reset

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle a POST request to send a password reset link.
     * This corresponds to route('password.email').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request) // <-- This handles the POST for forgot-password
    {
        // This method's logic is typically provided by SendsPasswordResetEmails trait's sendResetLinkEmail method
        // We're essentially just exposing it for the route to call.
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Display the password reset form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\View\View
     */
    public function reset(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Handle a POST request to reset the user's password.
     * This corresponds to route('password.store').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request) // <-- This handles the POST for reset-password
    {
        // This method's logic is typically provided by ResetsPasswords trait's reset method
        // We're essentially just exposing it for the route to call.
        return $this->reset($request); // Calls the reset method from ResetsPasswords trait
    }

    // You might also need to ensure these methods are public if the trait methods are protected
    // and you're calling them directly from your exposed methods. Laravel's traits usually
    // make these accessible, but sometimes custom setups require explicit exposure.
    //
    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     return $request->wantsJson()
    //                 ? new JsonResponse(['message' => trans($response)], 200)
    //                 : back()->with('status', trans($response));
    // }
    //
    // protected function sendResetResponse(Request $request, $response)
    // {
    //     return $request->wantsJson()
    //                 ? new JsonResponse(['message' => trans($response)], 200)
    //                 : redirect($this->redirectPath())->with('status', trans($response));
    // }
    //
    // protected function sendResetFailedResponse(Request $request, $response)
    // {
    //     throw ValidationException::withMessages([
    //         'email' => [trans($response)],
    //     ]);
    // }
}
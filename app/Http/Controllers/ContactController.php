<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $site = SiteSetting::current();

        return view('pages.contact', compact('site'));
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'message' => 'required|string|min:5',
        ], [
            'name.required' => 'Veuillez indiquer votre nom.',
            'email.required' => 'Veuillez indiquer votre adresse e-mail.',
            'email.email' => 'L’adresse e-mail n’est pas valide.',
            'message.required' => 'Veuillez écrire un message.',
            'message.min' => 'Le message doit contenir au moins 5 caractères.',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        $this->notifySite($validated);

        $success = 'Votre message a bien été envoyé. Nous vous répondrons rapidement.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => $success]);
        }

        return redirect()->route('contact')->with('success', $success);
    }

    /**
     * @param  array<string, string|null>  $validated
     */
    private function notifySite(array $validated): void
    {
        $to = SiteSetting::current()->email;

        if (! is_string($to) || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return;
        }

        try {
            Mail::raw(
                "Nouveau message de contact\n\n"
                ."Nom : {$validated['name']}\n"
                ."E-mail : {$validated['email']}\n"
                .'Téléphone : '.($validated['phone'] ?: '—')."\n"
                .'Sujet : '.($validated['subject'] ?: '—')."\n\n"
                .$validated['message'],
                function ($message) use ($to, $validated) {
                    $message->to($to)
                        ->replyTo($validated['email'], $validated['name'])
                        ->subject('Contact A2 Consulting : '.($validated['subject'] ?: 'Nouveau message'));
                }
            );
        } catch (\Throwable) {
            // Le message est déjà enregistré en base, l’e-mail ne doit pas bloquer l’envoi.
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BoiteReceptionMail;

class BoiteReceptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mailData = [
            'title'=> 'Email pour Easymail',
            'body'=> "Ceci est de tester l' utilisation des eamils smtp",
        ];

        Mail::to("madjiguened835@gmail.com")->send(new BoiteReceptionMail($mailData));
        dd('Email envoyé avec succés.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Method implementation here
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Method implementation here
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Method implementation here
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Method implementation here
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Method implementation here
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Method implementation here
    }
}

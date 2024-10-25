<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Contact;
class FEHomeController extends Controller
{
    //
    public function index()
    {
        return view('home');
    }

    public function bestaand()
    {
        return view('bestaand');
    }

    public function nieuwbouw()
    {
        return view('nieuwbouw');
    }
    public function projecten()
    {
        $projects = Project::where('status','published')->get();
        // dd($projects);
        return view('projecten',compact('projects'));
    }


    public function submitContactForm(Request $request)
    {

        // Validate the form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'address_1' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'question' => 'required|string|max:2000',
            'g-recaptcha-response' => 'required|captcha',
        ]);
    
        // Save the contact data to the database
        $contact = new Contact();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->address_1 = $request->address_1;
        $contact->address_2 = $request->address_2;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->question = $request->question;
        $contact->save();
    
        // Prepare details for the emails
        $details = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'address_1' => $request->address_1,
            'address_2' => $request->address_2,
            'phone' => $request->phone,
            'question' => $request->question,
            'title' => 'Bedankt voor uw aanvraag'  // Adding the title key
        ];
    
        // Ensure the email addresses are valid before sending
        $adminEmail = env('ADMIN_EMAIL');
        $userEmail = $request->email;
    
        if (!filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['error' => 'Invalid admin email.']);
        }
    
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors(['error' => 'Invalid user email.']);
        }
    
        // Send email notifications
        \Mail::to($adminEmail)->send(new \App\Mail\ContactNotification($details));
        \Mail::to($userEmail)->send(new \App\Mail\ThanksContactQuery($details));
    
        // Redirect or return a response
        return redirect()->to('/#Offerte')->with('success', 'Your message has been submitted successfully!');
    }
    

}

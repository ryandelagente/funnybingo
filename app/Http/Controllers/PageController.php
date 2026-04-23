<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'meta_title'       => 'About Funny Bingo | Free Online Bingo Caller & Card Generator',
            'meta_description' => 'Learn about Funny Bingo — the free, browser-based bingo caller and card generator built for game nights, classrooms, fundraisers, and senior events.',
        ]);
    }

    public function contact()
    {
        return view('pages.contact', [
            'meta_title'       => 'Contact Us | Funny Bingo',
            'meta_description' => 'Have a question or feedback about Funny Bingo? Get in touch with us.',
        ]);
    }

    public function privacyPolicy()
    {
        return view('pages.privacy-policy', [
            'meta_title'       => 'Privacy Policy | Funny Bingo',
            'meta_description' => 'Read the Funny Bingo privacy policy. Learn how we handle your data, use cookies, and display Google AdSense advertisements.',
        ]);
    }

    public function terms()
    {
        return view('pages.terms', [
            'meta_title'       => 'Terms of Service | Funny Bingo',
            'meta_description' => 'Read the Funny Bingo terms of service and usage conditions.',
        ]);
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:5000',
        ]);

        // Store in session for now; swap for Mail::to() when email is configured
        return redirect()->route('page.contact')
                         ->with('success', 'Thank you! Your message has been received. We will respond within 1–2 business days.');
    }

    public function sitemap()
    {
        $posts = \App\Models\Post::published()->latest('published_at')->get();
        return response()->view('sitemap', ['posts' => $posts])
                         ->header('Content-Type', 'application/xml');
    }
}

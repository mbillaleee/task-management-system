<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    
    public function contactMessage()
    {
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact_subscriber.contact_message', compact('contacts'));
    }

    public function destroyContactMessage(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contact_messages.index')
            ->with('success', 'Contact message deleted successfully.');
    }

    public function subscriberEmail()
    {
        $subscribers = NewsletterSubscriber::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.contact_subscriber.subscriber_email', compact('subscribers'));
    }

    public function destroySubscriberEmail(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('admin.newsletter_subscribers.index')
            ->with('success', 'Subscriber deleted successfully.');
    }
}

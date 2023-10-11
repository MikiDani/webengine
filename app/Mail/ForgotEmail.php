<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForgotEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
	public $user;
	public $activate_url = null;

    /**
     * Create a new message instance.
     */
    public function __construct($email)
    {
        $this->email = $email;

        $this->user = User::where('email', $this->email)->first();

        $this->activate_url = URL::temporarySignedRoute('admin_newpass', now()->addMinutes(120), ['id' => $this->user->id, 'identifier' => Hash::make($this->user->identifier)]);
    }
    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.forgotemail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $username = ucfirst($this->user->name);
        return $this->subject('Forgotten Password - WebEngine')->view('emails.forgotemail')
        ->with([
            'username' => $username,
            'activate_url' => $this->activate_url
        ]);
    }
}

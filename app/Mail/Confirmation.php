<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class Confirmation extends Mailable
{
	use Queueable, SerializesModels;

	public $email;
	public $user;
	public $activate_url = null;

    public function __construct($email)
    {
        $this->email = $email;

        $this->user = User::where('email', $this->email)->first();
        $code = Hash::make($this->user->identifier);

        $this->activate_url = URL::temporarySignedRoute('admin_confirmation', now()->addMinutes(1), ['code' => $code]);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.emails.confirmation',
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

    public function build()
    {
        $username = ucfirst($this->user->name);
        return $this->subject('Confirmation of your e-mail address')->view('emails.forgotemail')
        ->with([
            'username' => $username,
            'activate_url' => $this->activate_url
        ]);
    }
}
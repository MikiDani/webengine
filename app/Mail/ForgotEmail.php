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
use Illuminate\Support\Facades\Lang;
use App\Models\User;

class ForgotEmail extends Mailable
{
	use Queueable, SerializesModels;

	public $email;
	public $user;
	public $linkroute;
	public $activate_url = null;

	/**
	 * Create a new message instance.
	 */
	public function __construct($email, $type)
	{
		$this->email = $email;
		
		$this->linkroute = ($type == 'admin') ? 'admin_newpass' : 'start';

		$this->user = User::where('email', $this->email)->first();

		$this->activate_url = URL::temporarySignedRoute($this->linkroute, now()->addMinutes(10), ['id' => $this->user->id, 'identifier' => Hash::make($this->user->identifier)]);
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
	 * Build the message.
	 */
	public function build()
	{
		$username = ucfirst($this->user->name);

		$emailSubject = Lang::get('messages.forgotemail.textlabel');

		return $this->subject($emailSubject)->view('emails.forgotemail')
		->with([
			'username' => $username,
			'activate_url' => $this->activate_url
		]);
	}
}

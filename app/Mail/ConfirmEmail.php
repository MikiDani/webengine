<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\Models\User;


class ConfirmEmail extends Mailable
{
	use Queueable, SerializesModels;

	public $email;
	public $linkroute;
	public $user;
	public $activate_url = null;

	public function __construct($email, $type)
	{
		$this->email = $email;

		//$this->linkroute = ($type == 'admin') ? 'admin_confirmation' : 'api_confirmation'; !!!
		$this->linkroute = ($type == 'admin') ? 'admin_confirmation' : 'admin_confirmation';

		$this->user = User::where('email', $this->email)->first();

		$this->activate_url = URL::temporarySignedRoute($this->linkroute, now()->addMinutes(10), ['id' => $this->user->id, 'identifier' => Hash::make($this->user->identifier)]);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			view: 'emails.confirmemail',
		);
	}

	public function build()
	{
		$username = ucfirst($this->user->name);

		$emailSubject = Lang::get('messages.confirm.textlabel');

		return $this->subject($emailSubject)->view('emails.confirmemail')
		->with([
			'username' => $username,
			'activate_url' => $this->activate_url
		]);
	}
}
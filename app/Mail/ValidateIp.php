<?php

namespace App\Mail;

use App\Models\AccessAttempts;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidateIp extends Mailable
{
    use Queueable, SerializesModels;

    public AccessAttempts $attempt;
    public User $user;
    public string $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AccessAttempts $attempt, User $user)
    {
        $this->user = $user;
        $this->attempt = $attempt;
        $this->url = route('releaseAccess') . '?token=' . $attempt->token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Valide o seu Acesso')->markdown('emails.validate-access');
    }
}

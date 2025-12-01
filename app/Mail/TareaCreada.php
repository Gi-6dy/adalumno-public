<?php

namespace App\Mail;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TareaCreada extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(public Tarea $tarea)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Nueva tarea creada: ' . $this->tarea->nombre,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tareas.creada',
            with: [
                'tarea' => $this->tarea,
                'usuario' => $this->tarea->user,
            ],
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

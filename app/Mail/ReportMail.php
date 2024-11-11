<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Report $report
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Report generated at {$this->report->created_at->toDateTimeString()}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.report-mail',
        );
    }
}

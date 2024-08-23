<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalaryPdfMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $month;
    public $pdfContent;
    public $fileName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $month, $pdfContent, $fileName)
    {
        $this->name = $name;
        $this->month = $month;
        $this->pdfContent = $pdfContent;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.salary_email')
                    ->subject('Your Salary Details for ' . $this->month)
                    ->attachData($this->pdfContent, $this->fileName, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
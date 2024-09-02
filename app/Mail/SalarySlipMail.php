<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SalarySlipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $pdfContent;
    public $fileName;

    public function __construct($user, $pdfContent, $fileName)
    {
        $this->user = $user;
        $this->pdfContent = $pdfContent;
        $this->fileName = $fileName;
    }

    public function build()
    {
        return $this->view('emails.salary_slip')
                    ->subject('Your Salary Slip')
                    ->attachData($this->pdfContent, $this->fileName, [
                        'mime' => 'application/pdf',
                    ]);
    }
}
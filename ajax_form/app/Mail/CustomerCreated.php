<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class CustomerCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $customer;
    public $fullName;

    public function __construct($customer,$fullName)
    {
        //
        $this->customer = $customer;
        $this->fullName = $fullName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // return new Envelope(
        //     from: [$this->customer->email => $this->customer->first_name . ' ' . $this->customer->last_name],
        //     subject: 'New Customer Created'
        // );

        $fullName = $this->customer->first_name . ' ' . $this->customer->last_name;

        return new Envelope(
            from: new Address($this->customer->email, $fullName),
            subject: 'Account Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_created',
            with: ['customer' => $this->customer,'fullName' => $this->fullName] // Pass the customer data to the view
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
}

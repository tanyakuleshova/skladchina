<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\Billing\Order;

class OrderSupportProjectMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $order;
    
    protected $order_email;
    
    protected $order_subject;
    
    protected $user_name;
    
    protected $project_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
        $this->order_email      = $this->order->user->email;
        $this->user_name        = $this->order->user->fullName;
        $this->project_name     = $this->order->project?'"'.$order->project->name.'"':'';
        $this->order_subject    = 'Поддержка проекта '.$this->project_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->order_email, $this->user_name)
                ->subject($this->order_subject)
                ->view('emails.email_user_support_project')->with([
                        'order'         => $this->order,
                        'order_email'   => $this->order_email,
                        'user_name'     => $this->user_name,
                        'project_name'  => $this->project_name
                    ]);
    }
}

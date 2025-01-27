<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSuggestionEmail implements ShouldQueue
{
    use Queueable , InteractsWithQueue,Queueable , SerializesModels;
    public $data;
    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;
        Mail::send([], [], function ($message) use ($data) {
            $message->to('cotacao@cotacao.bmsys.com.br')
                ->from('cotacao@cotacao.bmsys.com.br', 'Cotação')
                ->replyTo($data['email'], $data['name'])  // Aqui você define o e-mail do remetente
                ->subject($data['subject'])
                ->html($data['message']);
        });
    }
}

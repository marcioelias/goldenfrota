<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Boolean;

class NovoRegistroAtualizacaoApp
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $registro;
    public $exclusao;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $registro, Bool $exclusao = false)
    {
        $this->registro = $registro;
        $this->exclusao = $exclusao;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        //
    }
}

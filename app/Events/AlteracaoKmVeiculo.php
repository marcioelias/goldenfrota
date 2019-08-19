<?php

namespace App\Events;

use App\Veiculo;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use phpDocumentor\Reflection\Types\Float_;
use PhpParser\Node\Expr\Cast\Double;

class AlteracaoKmVeiculo
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $veiculo;
    public $kmAtualizado;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Veiculo $veiculo, float $kmAtualizado)
    {
        $this->veiculo = $veiculo;
        $this->kmAtualizado = $kmAtualizado;
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

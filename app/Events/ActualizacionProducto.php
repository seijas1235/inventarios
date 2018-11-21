<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;

class ActualizacionProducto extends Event
{
    public $producto;
    public $transaccion;
    public $ingreso;
    public $salida;
    public $existencia_anterior;

    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($producto, $transaccion, $ingreso, $salida, $existencia_anterior, $saldo)
    {
        $this->producto = $producto;
        $this->transaccion = $transaccion;
        $this->ingreso = $ingreso;
        $this->salida = $salida;
        $this->existencia_anterior = $existencia_anterior;
        $this->saldo = $saldo;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

<?php

namespace App\Events;

use App\Models\Row;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RowCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $row;

    public function __construct(Row $row)
    {
        $this->row = $row;
    }

    public function broadcastOn()
    {
        return new Channel('rows');
    }

    public function broadcastAs()
    {
        return 'row.created';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->row->toJson(),
        ];
    }

    public function broadcastConnections()
    {
        return [
            'redis'
        ];
    }
}

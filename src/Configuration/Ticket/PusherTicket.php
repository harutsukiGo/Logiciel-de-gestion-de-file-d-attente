<?php

namespace App\file\Configuration\Ticket;

use Pusher\Pusher;

class PusherTicket
{
    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            '0113c2d38580481c73f9',
            '76b65f4902cfafbcbefb',
            '2039045',
            $options
        );
    }

    public function trigger($channel, $event, $data)
    {
        return $this->pusher->trigger($channel, $event, $data);
    }
}




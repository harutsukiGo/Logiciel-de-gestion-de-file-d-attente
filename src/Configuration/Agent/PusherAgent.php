<?php
namespace App\file\Configuration\Agent;

use Pusher\Pusher;

class PusherAgent
{
    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            'd7bb9117b19bb62a9a43',
            'c3bf220b54f125815bfb',
            '2037939',
            $options
        );
    }

    public function trigger($channel, $event, $data)
    {
        return $this->pusher->trigger($channel, $event, $data);
    }
}

<?php
namespace App\file\Configuration\Guichet;

use Pusher\Pusher;

class PusherGuichet
{

    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            'af1fa86b0285d98a104e',
            '5d3925e0b03881065c61',
            '2038204',
            $options
        );
    }

    public function trigger($channel, $event, $data)
    {
        return $this->pusher->trigger($channel, $event, $data);
    }
}
<?php
namespace App\file\Configuration\Publicite;

use Pusher\Pusher;

class PusherPublicite
{

    private $pusher;

    public function __construct()
    {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            'cbb5eb4a126a9d026d02',
            '273800f3f94ced4098da',
            '2038133',
            $options
        );
    }

    public function trigger($channel, $event, $data)
    {
        return $this->pusher->trigger($channel, $event, $data);
    }
}
<?php
namespace App\file\Configuration\Service;

use Pusher\Pusher;

class PusherService {
    private $pusher;

    public function __construct() {
        $options = [
            'cluster' => 'eu',
            'useTLS' => true
        ];

        $this->pusher = new Pusher(
            'da5a8b9ef5f31e2a1ad8',
            'cab6d338afcabb234749',
            '2037622',
            $options
        );
    }

    public function trigger($channel, $event, $data) {
        return $this->pusher->trigger($channel, $event, $data);
    }
}
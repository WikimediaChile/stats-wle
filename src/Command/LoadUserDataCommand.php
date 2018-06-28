<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\User;
use App\Service\Commons;
use \Requests;

class LoadUserDataCommand extends Command
{
    private $user;

    public function __construct(User $user, Commons $commons)
    {
        $this->user = $user;
        $this->commons = $commons;
        parent::__construct();
    }

    protected function configure()
    {
        $this
          ->setName('app:load-users')
          ->setDescription('Retrieve external data from Commons')
          ->setHelp('This command retrieves the images from Category in Wikimedia Commons');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->commons->getUsers();
        $payload = [
          'action' => 'query', 'format' => 'json', 'list' => 'users',
          'usprop' => 'registration'];

        while (count($users)){
          $local = array_splice($users, 0, 50);
          $payload['ususers'] = implode("|", $local);
          $url = 'https://commons.wikimedia.org/w/api.php?'.http_build_query($payload);
          $request = Requests::get($url);
          $data = json_decode($request->body, true);
          $this->user->process($data['query']['users']);
        }


    }
}

<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Service\Commons;
use \Requests;

class LoadDataCommand extends Command
{
    private $commons;

    public function __construct(Commons $commons)
    {
        $this->commons = $commons;
        parent::__construct();
    }

    protected function configure()
    {
        $this
          ->setName('app:load-data')
          ->setDescription('Retrieve external data from Commons')
          ->setHelp('This command retrieves the images from Category in Wikimedia Commons');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'https://tools.wmflabs.org/superzerocool/files-wle-2018.json';
        $request = Requests::get($url);
        $data = json_decode($request->body, true);
        $this->commons->addPhotos($data);
    }
}

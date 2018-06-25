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
          ->setHelp('This command retrieves the inmages from Category in Wikimedia Commons');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $url = 'https://commons.wikimedia.org/w/api.php?';

        $url .= http_build_query(['action'=> 'query', 'format'=> 'json', 'generator'=> 'categorymembers',
               'prop'=> 'imageinfo', 'iiprop'=> 'user|timestamp',
               'gcmtitle'=> 'Category:Images from Wiki Loves Earth 2018 in Chile', 'gcmtype'=> 'file',
               'gcmlimit'=> 'max', 'gcmsort'=> 'timestamp']);
        $request = Requests::get($url);
        $data = json_decode($request->body);
        $this->commons->addPhotos($data->query->pages);
    }
}

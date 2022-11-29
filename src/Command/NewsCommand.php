<?php

namespace App\Command;

use App\Controller\NewsController;

use App\Service\MessageService;
use App\Service\ProcessNews;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class NewsCommand extends Command
{
    

    protected static $defaultName = 'app:read:news';

    public function __construct(MessageService $processNews, NewsController $nc, ManagerRegistry $doctrine)
    {
      $this->news = $processNews;
      $this->controller = $nc;
      $this->doctrine = $doctrine;
      parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Parses news from a source')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Dry run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $news = json_decode($this->news->curlService(), true);
        $articles = $news['articles'];
        $total = count($articles);
        $this->arr = [];
        for ($i=0; $i<$total; $i++) {
            $message = [
                'title' => $articles[$i]['title'],
                'short_description' => $articles[$i]['description'],
                'image' => $articles[$i]['urlToImage'],
                'publishedAt' => $articles[$i]['publishedAt']
            ];
            $this->controller->save($this->doctrine, $message['title'], $message);


            array_push($this->arr, $message);
           
        }
        return 0;
        
    }
}
<?php 
namespace App\Service;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use	 Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

class ProcessNews extends ServiceEntityRepository{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    public function fetchNews(){

    }

    public function produceNews(){
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'hello');
        $channel->close();
        $connection->close();

    }

    public function countArticles(){
      return $this->createQueryBuilder('a')
      ->select('count(a.id)')
      ->getQuery()
      ->getSingleScalarResult();
      }

      public function paginateArticles(int $offset=1)
      {
        return $qb = $this->getEntityManager() ->createQuery('SELECT a.id, a.date_added, a.title, a.picture, a.short_description FROM App\Entity\Articles a ORDER BY a.date_added DESC')
        ->setMaxResults(6)
        ->setFirstResult(($offset-1) * 6)
        ->getResult();
         
      }

      
  

}

?>
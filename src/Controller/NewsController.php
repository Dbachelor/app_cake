<?php

namespace App\Controller;

use App\MessageHandler\MessageServiceHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Articles;
// use App\Repository\ArticlesRepository;
use App\Service\MessageService;
use App\Service\ProcessNews;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Process\Process;

class NewsController extends AbstractController
{

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

     /**
     * @Route("/news", name="app_news")
     */
    
    #[Route('/news', name: 'app_news')]
    public function index(Request $request, ProcessNews $pn ): Response
    {

       

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_USER');
        $offset = 1; 
        $totalArticles = $pn->countArticles();
        $pages = $totalArticles / 6;
        if($request->get('offset')){
            $offset = $request->get('offset');
        }

        $pagi = $pn->paginateArticles($offset);
        return $this->render('news/index.html.twig', [
            'data' => $pagi,
            'pages' => ceil($pages)
            
        ]);
    }
    //07032215149
     /**
     * @Route("/news_save", name="app_save_news")
     */
  
    public function save(ManagerRegistry $doctrine, $checker, $array): Response{
        $entityManager = $doctrine->getManager();
        $repository = $doctrine->getRepository(Articles::class);
        // look for a single Product by name
        $products = $repository->findOneBy(['title' => $checker]);
        $product = new Articles();
        if (!$products){
            $product->setTitle($array['title']);
            $product->setShortDescription($array['short_description']);
            $product->setPicture($array['image']);
            $product->setDateAdded(new \DateTime());
            $entityManager->persist($product);
            $entityManager->flush();
        }else{
            print_r($products->getDateAdded());
            $products->setDateAdded(new \DateTime());
            //$products->setPicture('....');
           // $entityManager->persist($product);
            $entityManager->flush();
        }
        

        return new Response('Saved news with title '.$product->getTitle());
    }

     /**
     * @Route("/news_delete/{id}", name="app_delete_news")
     */
    // #[Route('/news_delete/{id}', name: 'app_delete_news')]
    public function delete(ManagerRegistry $doctrine, Request $request, int $id){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $entityManager = $doctrine->getManager();
        $article = $entityManager->getRepository(Articles::class)->find($id);
        if(!$article){
            return json_encode(["message"=>"faied to delete record", "status"=>400]);
    
        }
        $entityManager->remove($article);
        $entityManager->flush();
        return  json_encode(["message"=>"data deleted", "status"=>200]);

      }

    #[Route('/news_update', name: 'app_update_news')]
    public function update(Request $request){

    }
     /**
     * @Route("/news_create", name="app_update_news")
     */
    public function createMessages(): JsonResponse
    {
        $message = new MessageService();//('user@example.com', 'Welcome!', 'Registration has been completed.');
        if ($this->dispatchMessage(new MessageServiceHandler())) {
            return new JsonResponse(['status' => 'Sent!']);
        }
        return new JsonResponse(["stats"=>"failed"]);
    }




}
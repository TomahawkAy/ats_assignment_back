<?php

namespace App\Command;

use App\Entity\Product;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PullProductsCommand extends Command
{
    protected static $defaultName = 'app:pull:products';
    private $entityManager;
    private $httpClient;
    public function __construct(string $name = null,EntityManagerInterface $manager,HttpClientInterface $client)
    {
        parent::__construct($name);
        $this->entityManager=$manager;
        $this->httpClient = $client;

    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->httpClient->request(
            'GET',
            'http://test.ats-digital.com:3000/products?size=100'
        );
        if ($response->getStatusCode() == 200){
            $output->writeln('api fetched successfully');
            $content = $response->toArray();
            foreach ( $content['products'] as $key=>$item){
                $product = new Product();
                $product->setCreatedAt(new \DateTime($item['createdAt']));
                $product->setCategory($item['category']);
                $product->setTag($item['tag']);
                $product->setProductName($item['productName']);
                $product->setDescription($item['description']);
                $product->setColor($item['color']);
                $product->setProductMaterial($item['productMaterial']);
                $product->setPrice((float)$item['price']);
                $product->setImageUrl($item['imageUrl']);
                $this->entityManager->persist($product);
                foreach ($item['reviews'] as $review){
                    $rev = new Review();
                    $rev->setContent($review['content']);
                    $rev->setRating($review['rating']);
                    $rev->setProduct($product);
                    $this->entityManager->persist($rev);
                }
            }
            $this->entityManager->flush();
        }
        return 0;
    }
}

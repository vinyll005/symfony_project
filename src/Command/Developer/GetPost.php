<?php

namespace App\Command\Developer;

use App\Repository\PostRepositoryInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class GetPost extends Command
{

    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    protected function configure()
    {
        $this
            ->setName('learning:get:post')
            ->setDescription('Get post')
            ->setHelp('Get post')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $posts = $this->postRepository->getAllPost();
        foreach ($posts as $post) {
            $io->newLine(2);
            $io->text($post->getTitle());
        }

        return 0;
    }
}
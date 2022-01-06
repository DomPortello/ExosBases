<?php

namespace App\Command;

use App\Repository\GameRepository;
use App\Service\TextService;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\CodeCoverage\Report\Text;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SlugCommand extends Command
{
    private TextService $textService;
    private GameRepository $gameRepository;
    private EntityManagerInterface $em;


    /**
     * @param TextService $textService
     */

    public function __construct(
        TextService $textService,
        GameRepository $gameRepository,
        EntityManagerInterface $em,
    )
    {
        parent::__construct();
        $this->textService = $textService;
        $this->gameRepository = $gameRepository;
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('app:slugThis')
        ->setDescription('Slug this s**t');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $games =  $this->gameRepository->findAll();
        $output->writeln('Command starting...');
        $progressBar = new ProgressBar($output, count($games));
        $progressBar->start();
        // Traitement pour générer les slugs puis les modifier en BDD
        // A chaque fin de traitement, on avance la progressbar


        foreach ($games as $game){
            $gameSlugged = $game->setSlug($this->textService->slugify($game->getName()));
            $this->em->persist($gameSlugged);
            $progressBar->advance();
        }
        $progressBar->finish();
        $this->em->flush();
        $output->writeln('Command finished !');
        return 0;
    }

    /**
     * @return TextService
     */
    public function getTextService(): TextService
    {
        return $this->textService;
    }

    /**
     * @param TextService $textService
     */
    public function setTextService(TextService $textService): void
    {
        $this->textService = $textService;
    }

    /**
     * @return GameRepository
     */
    public function getGameRepository(): GameRepository
    {
        return $this->gameRepository;
    }

    /**
     * @param GameRepository $gameRepository
     */
    public function setGameRepository(GameRepository $gameRepository): void
    {
        $this->gameRepository = $gameRepository;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEm(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * @param EntityManagerInterface $em
     */
    public function setEm(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }

}
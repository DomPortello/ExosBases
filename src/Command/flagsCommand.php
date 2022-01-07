<?php

namespace App\Command;

use App\Repository\LanguageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class flagsCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private LanguageRepository $languageRepository;

    public function __construct(EntityManagerInterface $entityManager, LanguageRepository $languageRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->languageRepository = $languageRepository;
    }

    protected function configure()
    {
        $this->setName('app:getFlags')
        ->setDescription('Get flags with the French name of the country');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $output->writeln('Command starting...');
        $languages = $this->languageRepository->findAll();

        foreach ($languages as $language){
            $code = $language->getCode();
            $url = "https://flagcdn.com/24x18/$code.png";
            $flag = $language->setFlag($url);
            $this->entityManager->persist($flag);
        }
        $this->entityManager->flush();
        $output->writeln('Command finished !');
        return 0;
    }

    /**
     * @return EntityManagerInterface
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function setEntityManager(EntityManagerInterface $entityManager): void
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return LanguageRepository
     */
    public function getLanguageRepository(): LanguageRepository
    {
        return $this->languageRepository;
    }

    /**
     * @param LanguageRepository $languageRepository
     */
    public function setLanguageRepository(LanguageRepository $languageRepository): void
    {
        $this->languageRepository = $languageRepository;
    }

}
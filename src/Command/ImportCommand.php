<?php
namespace App\Command;

use App\Exception\FeedException;
use App\Feed\FeedImport;
use Lyssal\Doctrine\Orm\Manager\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Command which save all new feed items.
 */
class ImportCommand extends Command
{
    /**
     * @var \App\Feed\FeedImport The feed import
     */
    private $feedImport;

    /**
     * @var \Lyssal\Doctrine\Orm\Manager\EntityManager The Feed manager
     */
    private $feedManager;


    /**
     * ImportCommand constructor.
     *
     * @param \App\Feed\FeedImport                       $feedImport  The feed import
     * @param \Lyssal\Doctrine\Orm\Manager\EntityManager $feedManager The Feed manager
     */
    public function __construct(FeedImport $feedImport, EntityManager $feedManager)
    {
        parent::__construct();

        $this->feedImport = $feedImport;
        $this->feedManager = $feedManager;
    }


    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:feed:import')
            ->setDescription('Import all the new feed items')
        ;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $feeds = $this->feedManager->findAll();

        foreach ($feeds as $feed) {
            $feedTitle = (null !== $feed->getTitle() ? $feed->getTitle() : '<fg=yellow>Titre inconnu</>');

            try {
                $savedItemCount = $this->feedImport->importFeed($feed);
            } catch (FeedException $e) {
                $savedItemCount = 0;
                $output->writeln('<fg=red;options=bold>'.$feedTitle.' : '.$e->getMessage().'</>');
            }

            if ($savedItemCount > 0) {
                $output->writeln($feedTitle.' :  <fg=green;options=bold>'.$savedItemCount.'</> item'.($savedItemCount > 1 ? 's' : '').' saved.');
            }
        }
    }
}

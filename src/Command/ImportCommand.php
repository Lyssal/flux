<?php
namespace App\Command;

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
            $output->writeln('Reading '.$feed);
            $savedItemCount = $this->feedImport->importFeed($feed);

            if ($savedItemCount > 0) {
                $output->writeln('  '.$savedItemCount.' item'.($savedItemCount > 1 ? 's' : '').' saved.');
            }
        }
    }
}

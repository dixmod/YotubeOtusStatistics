<?php

namespace Dixmod\Command;

use Dixmod\Builder\ChannelBuilder;
use Dixmod\Services\Config;
use Dixmod\Services\Video;
use MongoCursorException;
use MongoCursorTimeoutException;
use MongoException;
use Symfony\Component\Console\{Command\Command, Input\InputInterface, Output\OutputInterface};

class Import extends Command
{
    /**
     *
     */
    protected function configure()
    {
        $this->setName('statistics:import')
            ->setDescription('Importing OTUS channel statistics to Youtube');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws MongoCursorException
     * @throws MongoCursorTimeoutException
     * @throws MongoException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>START</info>');
        $channels = Config::getOptions('youtube')['channels'];

        $channelBuilder = new ChannelBuilder();
        foreach ($channels as $channelId) {
            $output->write('['.$channelId);

            $channel = $channelBuilder->buildById($channelId);
            $channel->Save();

            /** @var Video $video */
            foreach ($channel->getItems() as $video) {
                try {
                    $video->Save();
                    $output->write('<info>.</info>');
                } catch (\Exception $exception) {
                    $output->writeln('<error>'. $exception->getMessage(). '</error>');
                }
            }
            $output->writeln(']');
        }

        $output->writeln('<info>FINISH</info>');
    }
}
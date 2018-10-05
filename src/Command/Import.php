<?php

namespace App\Command;

use App\Entity\Channel;
use App\Entity\Video;
use App\Repository\Youtube;
use App\Service\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use App\Service\Channel\ConverterChannelFromApi;

class Import extends Command
{
    protected function configure(): void
    {
        $this->setName('statistics:import')
            ->setDescription('Importing OTUS channel statistics to Youtube');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        global $container;

        $output->writeln('<info>START</info>');

        $channels = Config::getOptions('youtube')['channels'];
        $api = $container->get(Youtube::class);

        $converterChannelFromApi = $container->get(ConverterChannelFromApi::class);

        foreach ($channels as $id) {
            $nextPageToken = '';
            $apiChannel = [];
            do {
                // Получаем данные из Youtube
                $apiChannelPage = $api->getChannel($id, $nextPageToken);
                if ($nextPageToken) {
                    $apiChannel['items'] = array_merge(
                        $apiChannel['items'],
                        $apiChannelPage['items']);
                } else {
                    $apiChannel = $apiChannelPage;
                }

                $nextPageToken = $apiChannelPage['nextPageToken'] ?? '';
            } while (!empty($nextPageToken));

            // Преобразуем в требуемый формат
            $channelDto = $converterChannelFromApi->createChannel($apiChannel);
            $channel = new Channel($channelDto);

            $output->writeln('Channel: ' . $channel->getTitle());

            // Сохраняем
            $channel->save();

            // Сохраняем информацию по видео
            $channel->getVideos()->iterate(function (video $video) use ($output) {
                $video->save();
                $output->write('<info>.</info>');
            });

            $output->writeln('[' . count($apiChannel['items']) . ']');
        }

        $output->writeln('<info>FINISH</info>');
    }
}
<?php

namespace Dixmod\Command;

use Dixmod\Repository\VideoRepository;
use Symfony\Component\Console\{Command\Command, Input\InputInterface, Output\OutputInterface};

class Show extends Command
{

    /** @var VideoRepository */
    private static $repositoryVideo;

    /**
     *
     */
    protected function configure()
    {
        $this->setName('statistics:show')
            ->setDescription('Displaying OTUS channel statistics on Youtube');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \MongoDB\Driver\Exception\Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!self::$repositoryVideo) {
            self::$repositoryVideo = new VideoRepository();
        }

        $arResult = self::$repositoryVideo->Aggregate([
            [
                '$group' => [
                    '_id' => '$channel',
                    'totalViews' => [
                        '$sum' => '$views'
                    ],
                    'totalLikes' => [
                        '$sum' => '$likes'
                    ],
                    'totalDislikes' => [
                        '$sum' => '$dislikes'
                    ]
                ],
            ],
            [
                '$sort' => [
                    'totalViews' => -1,
                ],
            ],
            [
                '$limit' => 10
            ]
        ]);

        printf("%30s %15s %15s %15s\n",
            'ID Chennal',
            'Views',
            'Likes',
            'Dislikes'
        );

        foreach ($arResult as $chennal) {
            printf("%30s | %15d | %15d | %15d\n",
                $chennal->_id,
                $chennal->totalViews,
                $chennal->totalLikes,
                $chennal->totalDislikes
            );
        }
    }
}
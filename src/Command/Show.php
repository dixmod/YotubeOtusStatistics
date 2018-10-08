<?php

namespace App\Command;

use App\Repository\VideoRepository;
use MongoDB\Driver\Exception\Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
     * @throws Exception
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
                    ],
                ],
            ],
            [
                '$project' => [
                    '_id' => 1,
                    'totalViews' => 1,
                    'totalLikes' => 1,
                    'totalDislikes' => 1,
                    'rating' => [
                        '$divide' => [
                            '$totalLikes',
                            '$totalDislikes'
                        ]
                    ],
                    'channel.title' => 1
                ],
            ],
            [
                '$lookup' =>
                    [
                        'from' => 'channels',
                        'localField' => '_id',
                        'foreignField' => 'id',
                        'as' => 'channel'
                    ]
            ],
            [
                '$unwind' => '$channel'
            ],
            [
                '$sort' => [
                    'rating' => -1,
                ],
            ],
            [
                '$limit' => 10
            ]
        ]);

        printf("%8s   %8s   %8s   %8s   %s\n",
            'Views',
            'Likes',
            'Dislikes',
            'Rating',
            'Channel title'
        );

        foreach ($arResult as $statChannel) {
            /*print_r($statChannel);
continue;*/
            /*if (!$statChannel->_id) {
                continue;
            }*/

            printf("%8d | %8d | %8d | %8.02f | %0s  \n",
                $statChannel->totalViews,
                $statChannel->totalLikes,
                $statChannel->totalDislikes,
                $statChannel->rating,
                $statChannel->channel->title
            );

        }
    }
}
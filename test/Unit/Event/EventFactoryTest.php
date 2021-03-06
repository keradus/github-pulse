<?php

declare(strict_types=1);

/**
 * Copyright (c) 2017 Andreas Möller.
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @link https://github.com/localheinz/github-pulse
 */

namespace Localheinz\GitHub\Pulse\Test\Unit\Event;

use Localheinz\GitHub\Pulse\Event;
use Localheinz\GitHub\Pulse\Resource;
use Localheinz\Test\Util\Helper;
use PHPUnit\Framework;

final class EventFactoryTest extends Framework\TestCase
{
    use Helper;

    public function testImplementsEventFactoryInterface(): void
    {
        $this->assertClassImplementsInterface(
            Event\EventFactoryInterface::class,
            Event\EventFactory::class
        );
    }

    public function testFromPullRequestReturnsArrayWithPullRequestEvent(): void
    {
        $pullRequest = $this->createPullRequestMock();

        $factory = new Event\EventFactory();

        $events = $factory->fromPullRequest($pullRequest);

        $this->assertInternalType('array', $events);
        $this->assertCount(1, $events);
        $this->assertContainsOnly(Event\PullRequestEventInterface::class, $events);

        /** @var Event\PullRequestEventInterface $event */
        $event = \array_shift($events);

        $this->assertSame($pullRequest, $event->pullRequest());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Resource\PullRequestInterface
     */
    private function createPullRequestMock(): Resource\PullRequestInterface
    {
        return $this->createMock(Resource\PullRequestInterface::class);
    }
}

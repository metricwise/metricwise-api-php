<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once('MetricWiseAPI.php');

final class MetricWiseAPITest extends TestCase
{
    private $mwapi;

    protected function setUp(): void
    {
        $this->mwapi = new MetricWiseAPI();
        $this->mwapi->setAccessKey($_ENV['TEST_ACCESS_KEY']);
        $this->mwapi->setHostname($_ENV['TEST_HOST']);
        $this->mwapi->setUsername($_ENV['TEST_USER']);
    }

    public function testSubmitLeadPass(): void
    {
        $lead = array('lastname' => 'test');
        $this->assertTrue($this->mwapi->submitLead($lead), $this->mwapi->getError());
    }

    public function testSubmitLeadFail(): void
    {
        $lead = array();
        $this->mwapi->setAccessKey('bogus');
        $this->assertFalse($this->mwapi->submitLead($lead));
        $this->assertEquals($this->mwapi->getError(), 'Forbidden');
    }
}

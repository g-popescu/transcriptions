<?php

namespace Tests;

use ArrayAccess;
use PHPUnit\Framework\TestCase;
use Laracasts\Transcriptions\Transcription;
use Laracasts\Transcriptions\TranscriptionLine;

class TranscriptionTest extends TestCase
{
    protected string $transcriptFilePath = __DIR__ . '/stubs/basic-example.vtt';
    protected Transcription $transcription;

    protected function setUp(): void
    {
        $this->transcription = Transcription::load($this->transcriptFilePath);
    }

    /** @test */
    public function loadsVTTFileAsString()
    {
        $this->assertStringContainsString('Here is a', $this->transcription->lines());
    }

    /** @test */
    public function convertedtToArrayOfTranscriptionLineObjects()
    {
        $lines = $this->transcription->lines();
        $this->assertCount(2, $lines);
        $this->assertContainsOnlyInstancesOf(TranscriptionLine::class, $lines);
    }

    /** @test */
    public function discardsRelevantLines()
    {
        $this->assertStringNotContainsString('WEBVTT', $this->transcription->lines());
    }

    /** @test */
    public function rendersLineAsHtml()
    {
        $expected = <<<EOT
            <a href="?time=00:03.210">Here is a</a>
            <a href="?time=00:04.110">example of a VTT file.</a>
            EOT;

        $this->assertEquals(
            $expected,
            $this->transcription->lines()->asHtml()
        );
    }

    /** @test */
    public function supportsArrayAccess()
    {
        $lines = $this->transcription->lines();
        $this->assertInstanceOf(ArrayAccess::class, $lines);
        $this->assertInstanceOf(TranscriptionLine::class, $lines[0]);
    }
}

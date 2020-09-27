<?php

namespace Tests;

use SmoothyCloud\ApplicationTemplateValidator\Testing\Browser\Browser;
use SmoothyCloud\ApplicationTemplateValidator\Testing\TemplateTest;

class Test extends TemplateTest
{
    /** @test */
    public function the_syntax_of_the_template_is_correct()
    {
        $this->validateTemplate();
    }

    /** @test */
    public function the_image_files_can_be_parsed_with_npm()
    {
        $imageFiles = $this->parseImageFiles([
            'package_manager' => 'npm',
            'build_script' => [
                'npm run build',
            ],
        ]);

        $this->assertParsedImageFilesMatchFolderContents($imageFiles, __DIR__ . "/concerns/npm_result");
    }

    /** @test */
    public function the_image_files_can_be_parsed_with_yarn()
    {
        $imageFiles = $this->parseImageFiles([
            'package_manager' => 'yarn',
            'build_script' => [
                'yarn run build',
            ]
        ]);

        $this->assertParsedImageFilesMatchFolderContents($imageFiles, __DIR__ . "/concerns/yarn_result");
    }

    /** @test */
    public function the_application_works_correctly_when_deployed_with_npm()
    {
        $variables = [
            'vue_application' => __DIR__."/concerns/application",
            'package_manager' => 'npm',
            'build_script' => [
                'npm run build',
            ],
        ];

        $this->deployApplication($variables);
        $this->assertApplicationWorksCorrectly();
    }

    /** @test */
    public function the_application_works_correctly_when_deployed_with_yarn()
    {
        $variables = [
            'vue_application' => __DIR__."/concerns/application",
            'package_manager' => 'yarn',
            'build_script' => [
                'yarn run build',
            ],
        ];

        $this->deployApplication($variables);
        $this->assertApplicationWorksCorrectly();
    }

    private function assertApplicationWorksCorrectly(): void
    {
        $browser = new Browser('http://localhost:50000');

        $browser->visit('/');
        $this->assertTrue($browser->pathIs("/"));
        $this->assertTrue($browser->see("You are viewing page: foo"));

        $browser->visit('/bar');
        $this->assertTrue($browser->pathIs("/bar"));
        $this->assertTrue($browser->see("You are viewing page: bar"));

        $browser->visit('/baz');
        $this->assertTrue($browser->pathIs("/404"));
        $this->assertTrue($browser->see("Oops, page not found!"));
    }
}

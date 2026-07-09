<?php

declare(strict_types=1);

namespace Omaressaouaf\PlainKit\Tests;

class HelpersTest extends TestCase
{
    public function test_base_path_returns_paths_relative_to_the_app_root(): void
    {
        $this->assertSame(
            PLAINKIT_BASE_PATH . 'config/app.php',
            base_path('config/app.php')
        );
    }

    public function test_app_path_returns_paths_inside_the_app_directory(): void
    {
        $this->assertSame(
            PLAINKIT_BASE_PATH . 'app/Http/Controllers/home.php',
            app_path('Http/Controllers/home.php')
        );
    }

    public function test_e_escapes_html(): void
    {
        $this->assertSame('&lt;script&gt;alert(1)&lt;/script&gt;', e('<script>alert(1)</script>'));
    }

    public function test_r_echoes_escaped_output(): void
    {
        ob_start();
        _r('<strong>hi</strong>');
        $output = ob_get_clean();

        $this->assertSame('&lt;strong&gt;hi&lt;/strong&gt;', $output);
    }
}

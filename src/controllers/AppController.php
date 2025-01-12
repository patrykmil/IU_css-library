<?php

class AppController
{
  protected function isGet(): bool
  {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
  }

  protected function isPost(): bool
  {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  protected function render(?string $template = null, array $variables = []): void
  {
    $templatePath = 'public/views/' . $template . '.html.php';
    $output = 'File not found';

    if (file_exists($templatePath)) {
      extract($variables);

      ob_start();
      include $templatePath;
      $output = ob_get_clean();
    }
    print $output;
  }
}
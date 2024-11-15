<?php

class AppController
{
  // Changed from protected to public
  public function render(string $template = null, array $variables = [])
  {
    $templatePath = 'code/views/' . $template . '.html';
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

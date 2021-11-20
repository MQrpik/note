<?php

declare(strict_types=1);

namespace App;

class View
{
  public function render(string $page, array $params = []): void
  {
    require_once("templates/layout.php");
  }

  private function escape(array $params): array {
    $clearParams = [];
    return $clearParams;
  }
}

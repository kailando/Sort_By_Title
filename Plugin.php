<?php

namespace Kanboard\Plugin\Sort_By_Title;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize(): void
    {
        $this->template->hook->attach(
            'template:board:column:dropdown',
            'Sort_By_Title:board/column_dropdown'
        );
    }

    public function getPluginName(): string { return 'Sort_By_Title'; }
    public function getPluginDescription(): string { return 'One-time reorder tasks in a column by title and color (persist position).'; }
    public function getPluginAuthor(): string { return 'Kai Griswold'; }
    public function getPluginVersion(): string { return '1.0.0'; }
    public function getCompatibleVersion(): string { return '>=1.2.0'; }
}

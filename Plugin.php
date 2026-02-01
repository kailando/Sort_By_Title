<?php

namespace Kanboard\Plugin\AlphaTitleReorder;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize(): void
    {
        $this->template->hook->attach(
            'template:board:column:dropdown',
            'AlphaTitleReorder:board/column_dropdown'
        );
    }

    public function getPluginName(): string { return 'Alpha Title Reorder'; }
    public function getPluginDescription(): string { return 'One-time reorder tasks in a column by title (persist position).'; }
    public function getPluginAuthor(): string { return 'Nathan'; }
    public function getPluginVersion(): string { return '1.0.0'; }
    public function getCompatibleVersion(): string { return '>=1.2.0'; }
}

<?php

namespace Kanboard\Plugin\AlphaTitleReorder\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Model\TaskModel;

class ReorderController extends BaseController
{
    public function alphaSort()
    {
        $projectId  = $this->request->getIntegerParam('project_id');
        $columnId   = $this->request->getIntegerParam('column_id');
        $swimlaneId = $this->request->getIntegerParam('swimlane_id');

        // Permission check
        $this->getProject($projectId);

        // Fetch active tasks in this column + swimlane
        $tasks = $this->db
        ->table(TaskModel::TABLE)
        ->eq('project_id', $projectId)
        ->eq('column_id', $columnId)
        ->eq('swimlane_id', $swimlaneId)
        ->eq('is_active', 1)
        ->columns('id', 'title')
        ->findAll();

        usort($tasks, fn($a, $b) => strnatcasecmp($a['title'] ?? '', $b['title'] ?? ''));

        // Persist by rewriting positions
        $pos = 1;
        foreach ($tasks as $task) {
            $this->taskPositionModel->movePosition(
                $projectId,
                (int) $task['id'],
                                                   $columnId,
                                                   $pos,
                                                   $swimlaneId
            );
            $pos++;
        }

        $this->flash->success(t('Column reordered alphabetically by title.'));

        return $this->response->redirect(
            $this->helper->url->to('BoardViewController', 'show', ['project_id' => $projectId])
        );
    }
}

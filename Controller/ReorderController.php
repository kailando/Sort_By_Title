<?php

namespace Kanboard\Plugin\Sort_By_Title\Controller;

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

        // Fetch active tasks in this column + swimlane (include color)
        $tasks = $this->db
        ->table(TaskModel::TABLE)
        ->eq('project_id', $projectId)
        ->eq('column_id', $columnId)
        ->eq('swimlane_id', $swimlaneId)
        ->eq('is_active', 1)
        ->columns('id', 'title', 'color_id')
        ->findAll();

        // Sort by color first, then by title (case-sensitive)
        usort($tasks, function ($a, $b) {
            $ca = (int) ($a['color_id'] ?? 0);
            $cb = (int) ($b['color_id'] ?? 0);

            if ($ca !== $cb) {
                return $ca <=> $cb;
            }

            return strcmp($ca['title'] ?? '', $cb['title'] ?? '');
        });

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

        $this->flash->success(t('Column reordered by color, then by title (case-sensitive).'));

        return $this->response->redirect(
            $this->helper->url->to('BoardViewController', 'show', ['project_id' => $projectId])
        );
    }
}

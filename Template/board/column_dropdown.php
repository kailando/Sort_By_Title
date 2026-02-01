<?php
$projectId = 0;

if (isset($project) && isset($project['id'])) {
    $projectId = (int) $project['id'];
} elseif (isset($project_id)) {
    $projectId = (int) $project_id;
} elseif (isset($_GET['project_id'])) {
    $projectId = (int) $_GET['project_id'];
}

$columnId   = isset($column['id']) ? (int) $column['id'] : 0;
$swimlaneId = isset($swimlane['id']) ? (int) $swimlane['id'] : 0;

if ($projectId <= 0 || $columnId <= 0 || $swimlaneId <= 0) {
    return;
}

$url = '/?controller=ReorderController'
. '&action=alphaSort'
. '&plugin=AlphaTitleReorder'
. '&project_id=' . $projectId
. '&column_id=' . $columnId
. '&swimlane_id=' . $swimlaneId;
?>
<li>
<a href="<?= $this->text->e($url) ?>"
class="js-confirm"
data-confirm="<?= t('Reorder tasks in this column alphabetically by title? This overwrites manual order.') ?>">
<?= t('Sort titles A→Z (one-time)') ?>
</a>
</li>

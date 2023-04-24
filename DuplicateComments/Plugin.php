<?php

namespace Kanboard\Plugin\DuplicateComments;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{
    public function initialize()
    {
        $this->hook->on('model:task:project_duplication:aftersave', function ($hook_values) {
            $Comments = $this->commentModel->getAll($hook_values['source_task_id']);
            foreach ($Comments as $Comment) {
                $NewComment = array(
                    'task_id' => $hook_values['destination_task_id'],
                    'comment' => $Comment['comment'],
                    'user_id' => $Comment['user_id'],
                    'reference' => $Comment['reference'],
                );
                $this->commentModel->create($NewComment);
            }
        });
    }

    public function getPluginName()
    {
        return 'DuplicateComments';
    }

    public function getPluginDescription()
    {
        return 'Include comments when duplicating a task to another project';
    }

    public function getPluginAuthor()
    {
        return 'Tomas Dittmann';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }
}

<?php

namespace App\Support\Traits;

trait CommandTrait
{
    protected $command;

    public function report($message, $level = 'info')
    {
        if ($this->command != null) {
            $this->command->$level($message);
        }
    }

    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }
}

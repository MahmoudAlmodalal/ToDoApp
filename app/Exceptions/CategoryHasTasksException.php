<?php

namespace App\Exceptions;

use Exception;
use App\Models\Category;

class CategoryHasTasksException extends Exception
{
    protected $category;
    protected $taskCount;

    public function __construct(Category $category, int $taskCount, $code = 0, Throwable $previous = null)
    {
        $this->category = $category;
        $this->taskCount = $taskCount;
        
        $message = "Cannot delete category '{$category->name}' because it has {$taskCount} associated task(s). Please delete or reassign the tasks first.";
        
        parent::__construct($message, $code, $previous);
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getTaskCount()
    {
        return $this->taskCount;
    }
}


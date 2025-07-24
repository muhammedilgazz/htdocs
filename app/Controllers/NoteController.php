<?php

namespace App\Controllers;

use App\Models\Note;

class NoteController {
    private $noteModel;

    public function __construct(Note $noteModel)
    {
        $this->noteModel = $noteModel;
    }

    public function index() {
        $rows = $this->noteModel->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/notes/index.php';
    }
}

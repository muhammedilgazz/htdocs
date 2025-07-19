<?php

namespace App\Controllers;

use App\Models\Note;

class NoteController {
    public function index() {
        $note_model = new Note();
        $rows = $note_model->getAll();

        $csrf_token = generate_csrf_token();

        require_once ROOT_PATH . '/views/notes/index.php';
    }
}

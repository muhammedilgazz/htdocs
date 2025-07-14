<?php

require_once 'C:/xampp/htdocs/models/Note.php';

class NoteController {
    public function index() {
        $note_model = new Note();
        $rows = $note_model->getAll();

        require_once 'C:/xampp/htdocs/views/notes/index.php';
    }
}
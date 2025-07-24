<?php

namespace App\Controllers;

use App\Models\Todo;
use Exception;

class TodoController
{
    private $todo_model;

    // Bağımlılığı constructor üzerinden enjekte et
    public function __construct(Todo $todo_model)
    {
        $this->todo_model = $todo_model;
    }

    public function index()
    {
        $todos = $this->todo_model->getAll();
        require ROOT_PATH . '/views/todo_list/index.php';
    }

    /**
     * AJAX isteği ile yeni bir yapılacaklar öğesi ekler.
     * @return array JSON yanıtı
     */
    public function ajax_add()
    {
        // CSRF ve method kontrolü bootstrap.php ve ajax.php'de yapıldığı için burada tekrar gerekmez.
        
        $task = trim($_POST['task'] ?? '');
        $due_date = $_POST['due_date'] ?? null;

        if (empty($task)) {
            http_response_code(400); // Bad Request
            return ['status' => 'error', 'message' => 'Görev boş olamaz!'];
        }

        try {
            $data = [
                'task' => $task,
                'status' => 'Beklemede', // Varsayılan durum
                'due_date' => $due_date
            ];

            if ($this->todo_model->add($data)) {
                return ['status' => 'success', 'message' => 'Görev başarıyla eklendi.'];
            } else {
                http_response_code(500); // Internal Server Error
                return ['status' => 'error', 'message' => 'Görev eklenirken bir hata oluştu.'];
            }
        } catch (Exception $e) {
            error_log("AJAX Add Todo Error: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            return ['status' => 'error', 'message' => 'Sunucu tarafında bir hata oluştu.'];
        }
    }
}
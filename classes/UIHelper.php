<?php

class UIHelper {

    /**
     * Generates a form input field.
     *
     * @param string $label The label for the input.
     * @param string $name The name and id for the input.
     * @param string $type The input type (e.g., 'text', 'number', 'password').
     * @param bool $required Whether the input is required.
     * @param string $value The default value for the input.
     * @param string $placeholder The placeholder text.
     * @return string The HTML for the form input.
     */
    public static function render_input($label, $name, $type = 'text', $required = true, $value = '', $placeholder = '', $options = [], $min = null) {
        $html = '<div class="mb-3">';
        $html .= '    <label for="' . $name . '" class="form-label">' . htmlspecialchars($label) . '</label>';

        if ($type === 'textarea') {
            $html .= '    <textarea class="form-control" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required ';
            }
            if ($placeholder) {
                $html .= 'placeholder="' . htmlspecialchars($placeholder) . '" ';
            }
            $html .= '>' . htmlspecialchars($value) . '</textarea>';
        } elseif ($type === 'select') {
            $html .= '    <select class="form-select" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required';
            }
            $html .= '>';
            foreach ($options as $option) {
                $selected = ($option['value'] == $value) ? ' selected' : '';
                $html .= '        <option value="' . htmlspecialchars($option['value']) . '"' . $selected . '>' . htmlspecialchars($option['text']) . '</option>';
            }
            $html .= '    </select>';
        } else {
            $html .= '    <input type="' . $type . '" class="form-control" id="' . $name . '" name="' . $name . '" ';
            if ($required) {
                $html .= 'required ';
            }
            if ($placeholder) {
                $html .= 'placeholder="' . htmlspecialchars($placeholder) . '" ';
            }
            if ($min !== null) {
                $html .= 'min="' . htmlspecialchars($min) . '" ';
            }
            $html .= 'value="' . htmlspecialchars($value) . '">';
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * Generates a modal window.
     *
     * @param string $id The ID for the modal.
     * @param string $title The title of the modal.
     * @param string $form_id The ID for the form inside the modal.
     * @param string $body_html The HTML content for the modal body (usually form fields).
     * @param string $footer_html The HTML content for the modal footer (usually buttons).
     * @return string The HTML for the modal.
     */
    public static function render_modal($id, $title, $form_id, $body_html, $footer_html) {
        $html = '<div class="modal fade" id="' . $id . '" tabindex="-1" aria-labelledby="' . $id . 'Label" aria-hidden="true">';
        $html .= '    <div class="modal-dialog">';
        $html .= '        <div class="modal-content">';
        $html .= '            <div class="modal-header">';
        $html .= '                <h5 class="modal-title" id="' . $id . 'Label">' . htmlspecialchars($title) . '</h5>';
        $html .= '                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
        $html .= '            </div>';
        $html .= '            <form id="' . $form_id . '">';
        $html .= '                <div class="modal-body">';
        $html .= $body_html;
        $html .= '                </div>';
        $html .= '                <div class="modal-footer">';
        $html .= $footer_html;
        $html .= '                </div>';
        $html .= '            </form>';
        $html .= '        </div>';
        $html .= '    </div>';
        $html .= '</div>';
        return $html;
    }
}

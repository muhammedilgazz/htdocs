<?php
/**
 * Generates a standard empty state message.
 *
 * @param string $icon The Bootstrap Icons class for the icon (e.g., 'bi bi-cart-plus').
 * @param string $title The main message title.
 * @param string $description A short description below the title.
 * @param string|null $button_text Text for an optional action button.
 * @param string|null $button_target The modal target for the button (e.g., '#myModal').
 */
function generate_empty_state($icon, $title, $description, $button_text = null, $button_target = null) {
    echo '<div class="text-center py-5">';
    echo '    <div style="font-size: 4rem; color: #e3e8ef; margin-bottom: 1rem;">';
    echo '        <i class="' . htmlspecialchars($icon) . '"></i>';
    echo '    </div>';
    echo '    <h4 style="color: #7b8ab8; font-weight: 600; margin-bottom: 0.5rem;">' . htmlspecialchars($title) . '</h4>';
    echo '    <p style="color: #a0a8c0; margin-bottom: 2rem;">' . htmlspecialchars($description) . '</p>';
    if ($button_text && $button_target) {
        echo '    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="' . htmlspecialchars($button_target) . '" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 8px; font-weight: 500;">';
        echo '        <i class="bi bi-plus-circle me-2"></i>' . htmlspecialchars($button_text) . '';
        echo '    </button>';
    }
    echo '</div>';
}
?>
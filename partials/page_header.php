<?php
/**
 * Generates a standard page header with a title, description, and breadcrumbs.
 *
 * @param string $title The main title of the page.
 * @param string $description A short description shown below the title.
 * @param array $breadcrumbs An array of breadcrumb items. Each item is an array with 'link' and 'text'.
 */
function generate_page_header($title, $description, $breadcrumbs = []) {
    echo '<div class="container-fluid py-1" style="background:#f7f9fb;">';
    echo '    <div class="d-flex justify-content-between align-items-center flex-wrap">';
    echo '        <div>';
    echo '            <h2 class="mb-1" style="font-weight:700; color:#1f2e4e; font-size:1.5rem;">' . htmlspecialchars($title) . '</h2>';
    echo '            <div style="color:#7b8ab8; font-size:1rem;">' . htmlspecialchars($description) . '</div>';
    echo '        </div>';
    echo '        <nav aria-label="breadcrumb">';
    echo '            <ol class="breadcrumb mb-0" style="background:transparent;">';
    foreach ($breadcrumbs as $crumb) {
        if (isset($crumb['active']) && $crumb['active']) {
            echo '                <li class="breadcrumb-item active" aria-current="page" style="color:#7b8ab8;">' . htmlspecialchars($crumb['text']) . '</li>';
        } else {
            echo '                <li class="breadcrumb-item"><a href="' . htmlspecialchars($crumb['link']) . '" style="color:#7b8ab8; text-decoration:none;">' . htmlspecialchars($crumb['text']) . '</a></li>';
        }
    }
    echo '            </ol>';
    echo '        </nav>';
    echo '    </div>';
    echo '</div>';
}
?>
<?php
/**
 * Plugin Name: User Login Count
 * Description: Show the number of logins for each user in the Users page.
 * Version: 1.0
 * Author: Your Name
 */

// Hook for adding admin columns
add_filter('manage_users_columns', 'adding_custom_columns');
add_action('manage_users_custom_column', 'manage_custom_columns', 10, 3);

function adding_custom_columns($columns) {
    $columns['login_count'] = 'Login Count';
    return $columns;
}

function manage_custom_columns($val, $column_name, $user_id) {
    if ($column_name == 'login_count') {
        return get_user_meta($user_id, '_user_login_count', true);
    }
    return $val;
}

// Hook for counting logins
add_action('wp_login', 'count_user_logins', 10, 2);

function count_user_logins($user_login, $user) {
    $count = get_user_meta($user->ID, '_user_login_count', true);
    $count = empty($count) ? 1 : $count + 1;
    update_user_meta($user->ID, '_user_login_count', $count);
}
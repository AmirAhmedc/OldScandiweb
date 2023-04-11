<?php

// The furniture dimensions in the database are set in this format: '[number, number, number]'.
// With the helper function I remove the square brackets and converting it to a string format: e.g.: 12x23x45
function extract_from_database_array($string)
{
    $arr = json_decode($string, true);
    $new_array = array_map('intval', $arr);
    $new_string = implode('x', $new_array);
    return $new_string;
}

// Display errors
function display_errors($errors = [], $class = 'errors')
{
    $output = '';
    if (!empty($errors)) {
        $output .= sprintf('<div class="%s alert">', $class);
        $output .= '<h3>Errors::</h3><ul>';
        foreach ($errors as $i => $error) {
            $output .= sprintf('<li>[%d] %s</li>', $i + 1, $error);
        }
        $output .= '</ul></div>';
    }
    return $output;
}

function get_current_inputs()
{
    $input_values = ['sku', 'name', 'price'];

    if ($_POST['typeSwitcher'] == 'dvd') {
        $input_values[] = 'size';
    }

    if ($_POST['typeSwitcher'] == 'book') {
        $input_values[] = 'weight_kg';
    }

    if ($_POST['typeSwitcher'] == 'furniture') {
        $input_values[] = 'width';
        $input_values[] = 'length';
        $input_values[] = 'height';
    }

    return $input_values;
}

// Validate inputs
function validate_inputs($database)
{
    // Initialize empty errors array
    $errors = [];

    // If form was not submitted, return early
    if (!isset($_POST['submit'])) {
        return;
    }

    // Get current form inputs
    $inputs = get_current_inputs();

    // Check for empty required fields
    foreach ($inputs as $input) {
        if (empty($_POST[$input]) || trim($_POST[$input]) == '') {
            $errors[] = ucfirst($input) . " can't be empty.";
        }
    }

    // Check if SKU already exists in the database
    $sku = $_POST['sku'];
    $stmt = $database->prepare("SELECT * FROM products WHERE sku = ?");
    $stmt->bind_param("s", $sku);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $errors[] = "This SKU already exists. Please provide a unique stock keeping unit (SKU).";
    }

    // Check that numeric fields contain numeric values
    $numeric_inputs = array_diff($inputs, ["sku", "name"]);
    foreach ($numeric_inputs as $input) {
        check_numeric_value($_POST, $input, $errors);
    }

    // If there are any errors, display them
    if (!empty($errors)) {
        return display_errors($errors);
    }
}

function check_numeric_value($post, $field, &$errors)
{
    if (!empty($post[$field]) && !is_numeric($post[$field])) {
        $errors[] = "Please provide a numeric value for the " . $field . ".";
    }
}

// Get the selected type
function get_selected_type($type)
{
    if (isset($_POST['typeSwitcher']) && $_POST['typeSwitcher'] == $type) {
        echo 'selected';
    }
}

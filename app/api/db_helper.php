<?php
// this is because you can use this file in different project level make sure you includes the database connection file
if (file_exists("../system/cogs/db.php")) {
    include_once '../system/cogs/db.php';
}
if (file_exists("../../system/cogs/db.php")) {
    include_once '../../system/cogs/db.php';
}
if (file_exists("app/system/cogs/db.php")) {
    include_once 'app/system/cogs/db.php';
}

/**
 * Create a PDO connection.
 */
function getDB() {
    global $pdo;
    return $pdo;
}

/**
 * 1️⃣ Generate HTML form for insert or update.
 * 
 * @param string $table       Table name
 * @param array  $columns     Array of column names
 * @param int|null $id        ID for update (optional)
 * @return string             HTML form string
 */
function generateForm($table, $columns = [], $id = null) {
    $pdo = getDB();
    $values = [];

    // Fetch PK
    $stmt = $pdo->prepare("SHOW KEYS FROM `$table` WHERE Key_name = 'PRIMARY'");
    $stmt->execute();
    $pk = $stmt->fetch(PDO::FETCH_ASSOC)['Column_name'] ?? null;

    // Fetch existing row if update
    if ($id && $pk) {
        $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE `$pk` = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $values = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    // If columns not passed, fetch all except PK auto-increment / timestamps
    if (empty($columns)) {
        $cols = executeQuery("DESC `$table`")['data'];
        $columns = [];
        foreach ($cols as $c) {
            if ($c['Extra'] === 'auto_increment' || strpos($c['Type'], 'timestamp') !== false) continue;
            $columns[] = ['name' => $c['Field'], 'type' => 'text'];
        }
    }

    $action = $id ? "update" : "insert";
    $html = "<form method='POST' id='$table' action='/create/$table' enctype='multipart/form-data' data-ajax=1>";
    $html .= "<input type='hidden' name='table' value='$table'>";
    $html .= "<input type='hidden' name='action' value='$action'>";
    if ($id && $pk) $html .= "<input type='hidden' name='$pk' value='$id'>";

    foreach ($columns as $col) {
        // Handle plain string column name
        if (is_string($col)) $col = ['name' => $col, 'type' => 'text'];

        $name = $col['name'] ?? '';
        if ($name === $pk) continue; // skip PK
        $alias = $col['alias'] ?? ucwords(str_replace('_', ' ', $name));
        $type = $col['type'] ?? 'text';
        $class = $col['classes'] ?? 'form-control';
        $value = $values[$name] ?? ($col['default'] ?? '');
        $min = isset($col['min_length']) ? " minlength='{$col['min_length']}' " : '';
        $max = isset($col['max_length']) ? " maxlength='{$col['max_length']}' " : '';
        $step = isset($col['step']) ? " step='{$col['step']}' " : '';
        $validation = $col['validation'] ?? '';

        // Handle validation patterns
        $pattern = '';
        if ($validation) {
            $rules = explode(',', $validation);
            foreach ($rules as $r) {
                if ($r === 'number') $pattern = " pattern='[0-9]*' ";
                if ($r === 'email') $pattern = " pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$' ";
                if ($r === 'phone') $pattern = " pattern='[0-9]{10,15}' ";
                if ($r === 'text') $pattern = '';
                if (preg_match('/^regex:(.*)$/', $r, $m)) $pattern = " pattern='{$m[1]}' ";
            }
        }

        $html .= "<div class='mb-3'>";
        $html .= "<label for='$name' class='form-label'>$alias</label>";

        // Handle types
        switch ($type) {
            case 'textarea':
                $html .= "<textarea class='$class' name='$name' id='$name'$min$max>$value</textarea>";
                break;

            case 'select':
                $options = '';
                if (!empty($col['data_from_table'])) {
                    [$tbl, $val_col, $text_col] = $col['data_from_table'];
                    $rows = executeQuery("SELECT `$val_col`,`$text_col` FROM `$tbl`")['data'];
                    foreach ($rows as $r) {
                        $selected = ($r[$val_col] == $value) ? " selected" : '';
                        $options .= "<option value='{$r[$val_col]}'$selected>{$r[$text_col]}</option>";
                    }
                } elseif (!empty($col['enum'])) {
                    foreach ($col['enum'] as $opt) {
                        $selected = ($opt == $value) ? " selected" : '';
                        $options .= "<option value='$opt'$selected>$opt</option>";
                    }
                }
                $html .= "<select class='$class' name='$name' id='$name'>$options</select>";
                break;

            case 'radio':
            case 'checkbox':
                if (!empty($col['enum'])) {
                    foreach ($col['enum'] as $opt) {
                        $checked = ($opt == $value) ? ' checked' : '';
                        $html .= "<div class='form-check'><input class='form-check-input' type='$type' name='{$name}[]' value='$opt'$checked><label class='form-check-label'>$opt</label></div>";
                    }
                }
                break;

            case 'file':
            case 'image':
                $html .= "<input type='file' class='$class' name='$name' id='$name'>";
                if ($value && $type === 'image') $html .= "<img src='$value' class='img-thumbnail mt-2' style='max-height:100px;'>";
                break;

            default:
                $html .= "<input type='$type' class='$class' name='$name' id='$name' value='$value'$min$max$step$pattern required>";
        }

        $html .= "</div>";
    }

    $html .= "<button type='submit' class='btn btn-primary rounded-pill btn-lg'>" . ($id ? "Edit" : "SUBMIT") . "</button></form>";

    return $html;
}


/**
 * 2️⃣ Fetch data and render in various formats
 * 
 * @param string $query        SQL query
 * @param array  $params       Parameters (associative)
 * @param string $format       'array'|'index'|'json'|'table'|'card'|'list'
 * @param array|null $actions  ['update','delete','view'] — only for visual formats
 */
function fetchAndRender($query, $params = [], $format = 'array', $actions = []) {
    $pdo = getDB();
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Basic data returns
    switch ($format) {
        case 'json':
            return json_encode($data, JSON_PRETTY_PRINT);
        case 'array':
            return $data;
        case 'index':
            $result = [];
            foreach ($data as $row) {
                $result[] = array_values($row);
            }
            return $result;
    }

    // Visual outputs
    if (in_array($format, ['table', 'list', 'card'])) {
        $html = "";

        // ---- Table format ----
        if ($format === 'table') {
            if (count($data)) {
                $html .= "<table class='table table-bordered table-hover'><thead><tr>";
                foreach (array_keys($data[0]) as $col) {
                    $html .= "<th>" . htmlspecialchars($col) . "</th>";
                }
                if ($actions) $html .= "<th>Actions</th>";
                $html .= "</tr></thead><tbody>";

                foreach ($data as $row) {
                    $html .= "<tr>";
                    foreach ($row as $v) {
                        $html .= "<td>" . htmlspecialchars($v) . "</td>";
                    }

                    if ($actions) {
                        $html .= "<td>";
                        foreach ($actions as $act) {
                            $id = reset($row); // assume first col = ID
                            $html .= "<button data-id='$id' data-action='$act' class='btn btn-sm btn-outline-primary me-1'>$act</button>";
                        }
                        $html .= "</td>";
                    }
                    $html .= "</tr>";
                }
                $html .= "</tbody></table>";
            } else {
                $html .= "<p class='text-muted'>No records found.</p>";
            }
        }

        // ---- Card format ----
        elseif ($format === 'card') {
            if (count($data)) {
                foreach ($data as $row) {
                    $html .= "<div class='card mb-3 shadow-sm'><div class='card-body'>";
                    foreach ($row as $col => $val) {
                        $html .= "<p><strong>" . htmlspecialchars($col) . ":</strong> " . htmlspecialchars($val) . "</p>";
                    }
                    if ($actions) {
                        $id = reset($row);
                        $html .= "<div class='mt-2'>";
                        foreach ($actions as $act) {
                            $html .= "<button data-id='$id' data-action='$act' class='btn btn-sm btn-outline-primary me-1'>$act</button>";
                        }
                        $html .= "</div>";
                    }
                    $html .= "</div></div>";
                }
            } else {
                $html .= "<p class='text-muted'>No data found.</p>";
            }
        }

        // ---- List format ----
        elseif ($format === 'list') {
            $html .= "<ul class='list-group'>";
            foreach ($data as $row) {
                $label = implode(' | ', array_map('htmlspecialchars', $row));
                $html .= "<li class='list-group-item d-flex justify-content-between align-items-center'>$label";
                if ($actions) {
                    $id = reset($row);
                    foreach ($actions as $act) {
                        $html .= "<button data-id='$id' data-action='$act' class='btn btn-sm btn-outline-primary ms-1'>$act</button>";
                    }
                }
                $html .= "</li>";
            }
            $html .= "</ul>";
        }

        return $html;
    }

    return $data;
}

/**
 * 3️⃣ Execute a query safely (insert/update/delete/select)
 * 
 * @param string $query
 * @param array $params
 * @return array [success=>bool, message=>string, data=>mixed|null]
 */

function executeQuery($query, $params = []) {
    $pdo = getDB();
    $response = ['success' => false, 'message' => '', 'data' => null];

    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        if (preg_match('/^select|show|desc|describe|explain/i', $query)) {
            $response['data'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $response['success'] = true;
            $response['message'] = 'Query executed successfully.';
        }
    } catch (PDOException $e) {
        $response['message'] = 'DB Error: ' . $e->getMessage();
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    return $response;
}


function is_empty(...$values) {
    foreach ($values as $value) {
        if (empty($value)) {
            echo $value . " is Empty";
            exit;
        }
    }
}

function getPK($tb='')
 {
    $data = executeQuery("DESC `$tb`")['data'];
    foreach ($data as $key => $value) {
        if ($value['Key'] == 'PRI') {
            return $pk = $value['Field'];
        }
    }
    return false;
 }

function fetch_select($tb,$text,$fk_column = ''){
    $pk = getPk($tb);
    $data = format_output(executeQuery("SELECT $pk, $text FROM `$tb`")['data'],'<select>@for <option value="*'.$pk.'">*'.$text.'</option> @end</select>');
    return $data;
}

function format_output($data, $content) {
    $output = '';

    // Extract the looping section between @for and @end
    $start = strpos($content, '@for');
    $end = strpos($content, '@end');

    if ($start === false || $end === false) {
        return $content; // No loop markers, return as is
    }

    // Get the loop template section
    $loop_template = substr($content, $start + 4, $end - ($start + 4));

    foreach ($data as $row) {
        $temp = $loop_template;

        foreach ($row as $key => $val) {
            // Detect type and format accordingly
            if (is_int($val) || is_float($val)) {
                $formatted = is_int($val) ? (string)$val : number_format($val, 2);
            } elseif (is_string($val)) {
                // Detect and format dates automatically (if looks like a date)
                if (stripos($key, 'date') !== false && strtotime($val)) {
                    $formatted = date("F j, Y", strtotime($val)); // e.g., June 25, 2025
                } else {
                    $formatted = htmlspecialchars($val, ENT_QUOTES);
                }
            } elseif (is_bool($val)) {
                $formatted = $val ? 'true' : 'false';
            } elseif (is_null($val)) {
                $formatted = '';
            } else {
                $formatted = htmlspecialchars(json_encode($val), ENT_QUOTES);
            }

            $temp = str_replace('*' . $key, $formatted, $temp);
        }

        // --- Handle PHP logic blocks (@php ... @endphp) ---
        $temp = preg_replace_callback('/@php(.*?)@endphp/s', function ($matches) use ($row) {
            ob_start();
            extract($row, EXTR_SKIP); // make row keys available as variables
            eval($matches[1]);
            return ob_get_clean();
        }, $temp);

        // --- Handle simple conditional directives ---
        $temp = preg_replace_callback('/@if\s*\((.*?)\)(.*?)((@elseif.*?)*)(@else(.*?))?@endif/s', function ($matches) use ($row) {
            extract($row, EXTR_SKIP);
            $condition = $matches[1];
            $ifBlock = $matches[2];
            $elseifBlocks = $matches[3];
            $elseBlock = isset($matches[6]) ? $matches[6] : '';

            ob_start();
            try {
                if (eval('return ' . $condition . ';')) {
                    echo $ifBlock;
                } elseif (preg_match_all('/@elseif\s*\((.*?)\)(.*?)(?=@elseif|@else|@endif|$)/s', $elseifBlocks, $parts)) {
                    $printed = false;
                    foreach ($parts[1] as $i => $cond) {
                        if (eval('return ' . $cond . ';')) {
                            echo $parts[2][$i];
                            $printed = true;
                            break;
                        }
                    }
                    if (!$printed && $elseBlock) echo $elseBlock;
                } elseif ($elseBlock) {
                    echo $elseBlock;
                }
            } catch (Throwable $e) {
                echo "<!-- Error in conditional: {$e->getMessage()} -->";
            }
            return ob_get_clean();
        }, $temp);

        $output .= $temp;
    }

    // Replace @for...@end block with rendered result
    $final = substr($content, 0, $start) . $output . substr($content, $end + 4);

    return $final;
}


// <?= fetch_select('trainings','training_name'); 

?>
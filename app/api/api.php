 <?php
 header("Content-Type:application/json");
/**
 * Get detailed info about a filesystem entry (file or directory).
 *
 * Returns an associative array with:
 *  - name
 *  - path (realpath)
 *  - type (mimetype)
 *  - is_file, is_dir
 *  - size_bytes, size_mb
 *  - inode
 *  - owner_uid, owner_name (if available)
 *  - group_gid, group_name (if available)
 *  - perms_octal (string like "0755")
 *  - perms_human (rwxr-xr-x)
 *  - created_at (timestamp or null)  -- on many Unix systems this is inode change time (ctime)
 *  - modified_at (timestamp)
 *  - accessed_at (timestamp)
 */
function get_file_details(string $path): array
{
    $result = [
        'exists' => false,
        'name' => null,
        'path' => null,
        'type' => null,
        'is_file' => false,
        'is_dir' => false,
        'size_bytes' => null,
        'size_mb' => null,
        'inode' => null,
        'owner_uid' => null,
        'owner_name' => null,
        'group_gid' => null,
        'group_name' => null,
        'perms_octal' => null,
        'perms_human' => null,
        'created_at' => null,
        'modified_at' => null,
        'accessed_at' => null,
    ];

    // basic existence check
    if (!file_exists($path)) {
        return $result;
    }

    $result['exists'] = true;

    // full canonical path (if available)
    $real = realpath($path);
    $pth = $real !== false ? $real : $path;
    $result['path'] = str_replace('\\', "/\n",$pth);
    $result['name'] = basename($path);
    $result['is_file'] = is_file($path);
    $result['is_dir']  = is_dir($path);

    // size
    if (is_file($path)) {
        $size = filesize($path);
        $result['size_bytes'] = $size === false ? null : $size;
        $result['size_mb'] = ($size === false) ? null : round($size / 1024 / 1024, 3);
    } else {
        $result['size_bytes'] = null;
        $result['size_mb'] = null;
    }

    // inode & times via stat
    $st = @stat($path);
    if ($st !== false) {
        $result['inode'] = $st['ino'] ?? null;
        $result['modified_at'] = $st['mtime'] ?? null;
        $result['accessed_at'] = $st['atime'] ?? null;
        // NOTE: on many Unix systems filectime is inode-change-time, not creation time.
        $result['created_at'] = $st['ctime'] ?? null;
    }

    // owner/group
    $owner = @fileowner($path);
    if ($owner !== false) {
        $result['owner_uid'] = $owner;
        // try to resolve name if posix functions exist
        if (function_exists('posix_getpwuid')) {
            $pw = posix_getpwuid($owner);
            $result['owner_name'] = $pw['name'] ?? null;
        }
    }
    $group = @filegroup($path);
    if ($group !== false) {
        $result['group_gid'] = $group;
        if (function_exists('posix_getgrgid')) {
            $gr = posix_getgrgid($group);
            $result['group_name'] = $gr['name'] ?? null;
        }
    }

    // permissions
    $perms = fileperms($path);
    if ($perms !== false) {
        $result['perms_octal'] = sprintf('%04o', $perms & 0x0FFF);
        $result['perms_human'] = perms_to_string($perms);
    }

    // mime/type detection (for files)
    if (is_file($path)) {
        if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($finfo !== false) {
                $mt = finfo_file($finfo, $path);
                finfo_close($finfo);
                $result['type'] = $mt ?: null;
            }
        }
        // fallback
        if (empty($result['type']) && function_exists('mime_content_type')) {
            $result['type'] = @mime_content_type($path) ?: null;
        }
    } else {
        // directories can be reported as "directory"
        $result['type'] = 'directory';
    }

    return $result;
}

/**
 * Convert fileperms() int to rwxr-xr-x string.
 * Source: adapted common implementation.
 */
function perms_to_string(int $perms): string
{
    $info = '';

    // file type
    if (($perms & 0xC000) === 0xC000) {
        $info .= 's'; // socket
    } elseif (($perms & 0xA000) === 0xA000) {
        $info .= 'l'; // symbolic link
    } elseif (($perms & 0x8000) === 0x8000) {
        $info .= '-'; // regular
    } elseif (($perms & 0x6000) === 0x6000) {
        $info .= 'b'; // block special
    } elseif (($perms & 0x4000) === 0x4000) {
        $info .= 'd'; // directory
    } elseif (($perms & 0x2000) === 0x2000) {
        $info .= 'c'; // character special
    } elseif (($perms & 0x1000) === 0x1000) {
        $info .= 'p'; // fifo pipe
    } else {
        $info .= 'u'; // unknown
    }

    // owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
                (($perms & 0x0800) ? 's' : 'x') :
                (($perms & 0x0800) ? 'S' : '-'));

    // group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
                (($perms & 0x0400) ? 's' : 'x') :
                (($perms & 0x0400) ? 'S' : '-'));

    // world
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
                (($perms & 0x0200) ? 't' : 'x') :
                (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}

/**
 * Recursively list a directory and return details for each entry.
 * - $path must be a directory
 * - returns array of file detail arrays
 */
// function list_directory_details(string $path, bool $recursive = false): array
// {
//     $out = [];
//     if (!is_dir($path)) return $out;

//     $it = new DirectoryIterator($path);
//     foreach ($it as $node) {
//         if ($node->isDot()) continue;
//         $p = $node->getPathname();
//         $out[] = get_file_details($p);
//         if ($recursive && $node->isDir()) {
//             $out = array_merge($out, list_directory_details($p, true));
//         }
//     }
//     return $out;
// }

/* Example usage */
// single file
// $info = get_file_details('/path/to/file.txt');
// echo json_encode($info, JSON_PRETTY_PRINT);

// directory recursive
// $all = list_directory_details('/path/to/dir', true);
// echo json_encode($all, JSON_PRETTY_PRINT);


// api.php

// Make sure a file path is provided
if (!isset($_GET['action'])  || empty($_GET['action']) ) {
    http_response_code(400);
    echo json_encode(['error' => 'No action specified']);
    exit;
}

// Sanitize input to prevent directory traversal attacks
// $file = basename($_GET['file']); // Only allow the file name, no directories
// $directory = __DIR__ . '/uploads/'; // Path to your files folder
// $fullPath = $directory . $file;

$fullPath = $_GET['file']??'./';
$fullPath = ltrim($fullPath,'./');
if ($_GET['action'] == 'file_detail') {
    $info = get_file_details('../../'.$fullPath);
    echo json_encode($info, JSON_PRETTY_PRINT);
}elseif ($_GET['action'] == 'file_delete') {
    $fullPath = '../../' . ltrim($_GET['file'], './');

    if (!file_exists($fullPath)) {
        echo json_encode(['message' => 'File or folder not found', 'success' => false]);
        exit;
    }

    // If it's a directory, recursively delete
    if (is_dir($fullPath)) {
        $deleted = delete_directory($fullPath);
        if ($deleted) {
            echo json_encode(['message' => 'Folder deleted successfully', 'success' => true]);
        } else {
            echo json_encode(['message' => 'Failed to delete folder', 'success' => false]);
        }
    } else {
        // It's a file
        if (unlink($fullPath)) {
            echo json_encode(['message' => 'File deleted successfully', 'success' => true]);
        } else {
            echo json_encode(['message' => 'Failed to delete file', 'success' => false]);
        }
    }
    exit;
}

elseif ($_GET['action'] == 'download_folder') {
    $fullPath = '../../' . ltrim($_GET['file'], './');

    if (!is_dir($fullPath)) {
        http_response_code(404);
        echo json_encode(['message' => 'Folder not found', 'success' => false]);
        exit;
    }

    $zipName = basename($fullPath) . '.zip';
    $zipPath = sys_get_temp_dir() . '/' . $zipName;
    include_once"../system/cogs/functions.php";
    $zip = zipFolder($fullPath,"$fullPath.zip");
    echo json_encode($zip);

    exit;
}elseif ($_GET['action'] == 'delete_download_folder') {
    $fullPath = trim($_GET['file']);

    if (!is_dir($fullPath)) {
        http_response_code(404);
        echo json_encode(['message' => 'Folder not found', 'success' => false]);
        exit;
    }

    header('Content-Disposition: attachment; filename="' . $fullPath . '"');
    header('Content-Length: ' . filesize($zipPath));
    readfile($zipPath);

    // Delete the temporary zip after sending
    unlink($zipPath);
    echo json_encode(['message'=>'done',"success"=>true]);
    exit;
}


elseif ($_GET['action'] == 'file_edit') {
    if (is_dir('../../'.$fullPath)) {
        echo json_encode(['message'=>'Failed to edit given file','success'=>false]);
        exit;
    }
    if (file_exists('../../'.$fullPath)) {
        $content = file_get_contents('../../'.$fullPath);
        $content = htmlentities($content);
        // echo json_encode(['message'=>'Data fetched from file '.$fullPath,'success'=>true,'data'=>$content]);
        if ($content && !empty($content)) {
            echo json_encode(['message'=>'Data fetched from file '.$fullPath,'success'=>true,'data'=>$content]);
        }else{
            echo json_encode(['message'=>'File is Empty','success'=>false,'data'=>$content]);
        }
    }else{
        echo json_encode(['message'=>'File not found','success'=>false]);
    }
}elseif ($_GET['action'] == 'save_file_edited_content') {
    $fullPath = trim($_GET['file']);
    if (is_dir('../../'.$fullPath)) {
        echo json_encode(['message'=>'Failed to edit given file','success'=>false]);
        exit;
    }
    if (file_exists('../../'.$fullPath)) {
        $content = $_POST['content']??'';
        if (file_put_contents('../../'.$fullPath,$content)) {
            echo json_encode(['message'=>'Content changed: '.$fullPath,'success'=>true]);
        }else{
            echo json_encode(['message'=>'Content not changed','success'=>false]);
        }
    }else{
        echo json_encode(['message'=>'File not found','success'=>false]);
    }
}elseif ($_GET['action'] == 'create_folder') {
    // Example: ?action=create_folder&file=path/to/dir&name=NewFolder
    $basePath = '../../' . ltrim($_GET['file'], './');
    $folderName = $_GET['name'] ?? '';
    $targetPath = rtrim($basePath, '/') . '/' . $folderName;

    if (empty($folderName)) {
        echo json_encode(['message' => 'Folder name cannot be empty', 'success' => false]);
        exit;
    }

    if (file_exists($targetPath)) {
        echo json_encode(['message' => 'A folder or file with that name already exists', 'success' => false]);
        exit;
    }

    if (mkdir($targetPath, 0777, true)) {
        echo json_encode(['message' => 'Folder created successfully', 'success' => true]);
    } else {
        echo json_encode(['message' => 'Failed to create folder', 'success' => false]);
    }

}elseif ($_GET['action'] == 'create_file') {
    // POST: name, content; GET: file (path)
    $basePath = '../../' . ltrim($_POST['path'] ?? $_GET['file'], './');
    $fileName = $_POST['name'] ?? '';
    $content = $_POST['content'] ?? '';
    $targetPath = rtrim($basePath, '/') . '/' . $fileName;

    if (empty($fileName)) {
        echo json_encode(['message' => 'File name cannot be empty', 'success' => false]);
        exit;
    }

    if (file_exists($targetPath)) {
        echo json_encode(['message' => 'A file or folder with that name already exists', 'success' => false]);
        exit;
    }

    if (file_put_contents($targetPath, $content) !== false) {
        echo json_encode(['message' => 'File created successfully', 'success' => true]);
    } else {
        echo json_encode(['message' => 'Failed to create file', 'success' => false]);
    }

}elseif ($_GET['action'] == 'file_upload') {
    // Handles Dropzone uploads
    $basePath = '../../' . ltrim($_GET['path'] ?? $_GET['file'], './');

    if (!is_dir($basePath)) {
        echo json_encode(['success' => false, 'message' => 'Invalid upload directory']);
        exit;
    }

    if (!empty($_FILES['file']['name'])) {
        $tmp = $_FILES['file']['tmp_name'];
        $name = basename($_FILES['file']['name']);
        $target = rtrim($basePath, '/') . '/' . $name;

        if (move_uploaded_file($tmp, $target)) {
            echo json_encode(['success' => true, 'message' => 'File uploaded successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save uploaded file']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    }

}else{
    http_response_code(400);
    echo json_encode(['error' => 'Unknown action']);
}
// if (!file_exists($fullPath)) { 
//     http_response_code(404);
//     echo json_encode(['error' => 'File not found']);
//     exit;
// }

// Set headers to force download
// header('Content-Description: File Transfer');
// header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename="' . $file . '"');
// header('Expires: 0');
// header('Cache-Control: must-revalidate');
// header('Pragma: public');
// header('Content-Length: ' . filesize($fullPath));

// Clear output buffer and read the file
// ob_clean();
// flush();
// readfile($fullPath);
exit;

?>
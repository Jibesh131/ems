<?php
include_once('includes/session.php');
include_once("includes/header.php");

$baseDir = __DIR__ . '/../user/attachments';
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : 'size';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'desc';

function folderSize($dir)
{
    $size = 0;
    if (!is_dir($dir)) return 0;
    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)) as $f) {
        if ($f->isFile()) $size += $f->getSize();
    }
    return $size;
}

function formatSize($bytes)
{
    if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
    elseif ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
    elseif ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
    return $bytes . ' Bytes';
}

function fileCount($dir)
{
    $count = 0;
    if (!is_dir($dir)) return 0;
    foreach (scandir($dir) as $f) {
        if ($f !== '.' && $f !== '..' && is_file($dir . '/' . $f)) $count++;
    }
    return $count;
}

function lastModified($dir)
{
    if (!is_dir($dir)) return 0;
    $latest = file_exists($dir) ? filemtime($dir) : 0;
    foreach (scandir($dir) as $f) {
        if ($f === '.' || $f === '..') continue;
        $path = $dir . '/' . $f;
        if (is_file($path)) $latest = max($latest, filemtime($path));
    }
    return $latest ?: filectime($dir);
}

$folders = [];
$totalSize = 0;
if (is_dir($baseDir)) {
    foreach (scandir($baseDir) as $f) {
        if ($f === '.' || $f === '..') continue;
        $path = $baseDir . '/' . $f;
        if (is_dir($path)) {
            $size = folderSize($path);
            $folders[] = [
                'name' => $f,
                'path' => $path,
                'size' => $size,
                'files' => fileCount($path),
                'modified' => lastModified($path)
            ];
            $totalSize += $size;
        }
    }
}

usort($folders, function ($a, $b) use ($sortColumn, $sortOrder) {
    $valA = $a[$sortColumn];
    $valB = $b[$sortColumn];
    if ($valA == $valB) return 0;
    return ($sortOrder === 'asc') ? (($valA < $valB) ? -1 : 1) : (($valA > $valB) ? -1 : 1);
});

$totalFolders = count($folders);
function nextOrder($o)
{
    return $o === 'asc' ? 'desc' : 'asc';
}
function sortLink($c, $curSort, $curOrder, $label)
{
    $arrow = '';
    if ($curSort === $c) {
        $rotation = ($curOrder === 'asc') ? '180deg' : '0deg';
        $arrow = '<img src="../images/asc_order.gif" border="0" style="margin-left:2px; transform: rotate(' . $rotation . '); vertical-align: middle;">';
    }
    $order = ($curSort === $c) ? nextOrder($curOrder) : 'asc';
    return "<a href='?sort={$c}&order={$order}'>{$label} {$arrow}</a>";
}
?>

<link href="../user/includes/style.css" rel="stylesheet" type="text/css">

<form method="post" id="folderForm" action="delete_folders.php">
    <table class="onepxtable" width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td colspan="5" class="body_title_style">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" class="body_title_style">&nbsp;Attachments Folder</td>
                        <td align="right" class="body_title_style">
                            &nbsp;<?php echo str_pad($totalFolders, 4, '0', STR_PAD_LEFT); ?> Folder(s) found (Total Size: <?php echo formatSize($totalSize); ?>)&nbsp;
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="alternate_color1">
            <td class="light_text_bold" align="center">Select</td>
            <td class="light_text_bold" align="center"><?php echo sortLink('name', $sortColumn, $sortOrder, 'Folder Name'); ?></td>
            <td class="light_text_bold" align="center"><?php echo sortLink('size', $sortColumn, $sortOrder, 'Folder Size'); ?></td>
            <td class="light_text_bold" align="center"><?php echo sortLink('files', $sortColumn, $sortOrder, 'File Count'); ?></td>
            <td class="light_text_bold" align="center"><?php echo sortLink('modified', $sortColumn, $sortOrder, 'Last Modified'); ?></td>
        </tr>

        <?php
        $rowClass = 'alternate_color2';
        if ($totalFolders === 0) {
            echo "<tr class='{$rowClass}'><td colspan='5' class='light_text' align='center'>No folders found</td></tr>";
        } else {
            foreach ($folders as $f) {
                $name = htmlspecialchars($f['name']);
                $size = formatSize($f['size']);
                $files = $f['files'];
                $date = date('Y-m-d H:i:s', $f['modified']);
                echo "<tr class='{$rowClass}'>
                <td class='light_text' align='center'><input type='checkbox' class='folderCheckbox' name='folders[]' value='{$name}'></td>
                <td class='light_text' align='center'>{$name}</td>
                <td class='light_text' align='center'>{$size}</td>
                <td class='light_text' align='center'>{$files}</td>
                <td class='light_text' align='center'>{$date}</td>
              </tr>";
                $rowClass = ($rowClass === 'alternate_color2') ? 'alternate_color1' : 'alternate_color2';
            }
        }
        ?>
    </table>

    <div id="deleteButtonContainer" style="margin-top:10px; display:none;">
        <input type="submit" value="Delete Selected Folders" class="btn">
    </div>
</form>

<script>
    const checkboxes = document.querySelectorAll('.folderCheckbox');
    const deleteContainer = document.getElementById('deleteButtonContainer');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', () => {
            deleteContainer.style.display = Array.from(checkboxes).some(c => c.checked) ? 'block' : 'none';
        });
    });
</script>

<?php
include("includes/footer.php");
$_SESSION['msg'] = "";
?>
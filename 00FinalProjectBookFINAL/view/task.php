<?php
    // Parse data
    $category_id = $task['categoryID'];
    $task_name = $task['taskName'];
    $location = $task['location'];
    $num_required = $task['numRequired'];
    $time = $task['time'];

?>
<h2><?php echo htmlspecialchars($task_name); ?></h2>


<h2>Assignment Information</h2>

    <table>
        <tr>
            <th>Task Name</th>
            <th>Number of Gals Required</th>
            <th>Location</th>
            <th>Time</th>

        </tr>
        <tr>
            <td><?php echo $task_name; ?></td>
            <td><?php echo $num_required; ?></td>
            <td><?php echo $location; ?></td>
            <td><?php echo $time; ?></td>

        </tr>
    </table>
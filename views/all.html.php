<?php
    include_once 'index.html.php';
?>
<h1>SHOW ALL</h1>

<table>
  <tr>
    <th>doi</th>
    <th>title</th> 
    <th>abstract</th>
    <th>pub_date</th>
  </tr>
  <?php 
    foreach($show_all_data as $show_all_data_val)
    {
        echo '<tr>
                <td>' . $show_all_data_val['doi'] . '</td>
                <td>' . $show_all_data_val['title'] . '</td>
                <td>' . $show_all_data_val['abstract'] . '</td>
                <td>' . $show_all_data_val['pub_date'] . '</td>
              </tr>';
    }
  ?>
</table>


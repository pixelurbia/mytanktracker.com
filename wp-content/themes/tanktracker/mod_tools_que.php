<?php
/*
Template Name: mod tools que
*/
?>

<?php 
$secure = new Security();
?>

		<?php 
			 global $wpdb;
			 $status = $_GET['status']; //no/yes/reject
			 $date_to = $_GET['date_to'];
			 $date_from = $_GET['date_from'];


        $reported_posts = $wpdb->get_results("SELECT * FROM mod_log");
    
            echo '<table>';
            echo '<tr>';
            echo '<th>Reporting User</th>';
            echo '<th>Ref ID</th>';
            echo '<th>Reported User ID</th>';
            echo '<th>Content type</th>';
            echo '<th>Date Reported</th>';
            echo '<th>Mod Approval</th>';
            echo '<th>Mod Approval ID</th>';
            echo '<th>Approve?</th>';
            echo '<th>Reject?</th>';
            echo '</tr>';
                foreach($reported_posts as $report){
                    $post_link = get_post_permalink($report->ref_id);
                    echo '<tr>';
                        echo '<td>'.$report->reporting_user_id.'</td>';
                        echo '<td><a href="'.$post_link.'">'.$report->ref_id.'</a></td>';
                        echo '<td>'.$report->author_id.'</td>';
                        echo '<td>'.$report->content_type.'</td>';
                        echo '<td>'.$report->date_reported.'</td>';
                        echo '<td>'.$report->mod_approved.'</td>';
                        echo '<td>'.$report->mod_id.'</td>';
                        echo '<td>Approve</td>';
                        echo '<td>Reject</td>';
                    echo '</tr>';
                }                    
            echo '</table>';
            echo '</div>'; 
		?>
	

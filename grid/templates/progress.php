<?php defined('ABSPATH') or die("you do not have access to this page!"); ?>

<?php
	$percentage_completed = RSSSL()->really_simple_ssl->get_score_percentage();
	$lowest_possible_task_count = RSSSL()->really_simple_ssl->get_lowest_possible_task_count();
?>

<div class="rsssl-progress-block">
    <div class="rsssl-progress-bar-text">
        <div class="progress-bar-container">
            <div class="progress">
                <div class="bar" style="width:<?php echo $percentage_completed?>%"></div>
            </div>
        </div>

        <div class="progress-text">
            <span class="rsssl-progress-percentage">
                <?php echo $percentage_completed?>%
            </span>
            <span class="rsssl-progress-text">
                <?php
                $open_task_count = RSSSL()->really_simple_ssl->get_remaining_tasks_count();
                $open_tasks_html = '<div class="rsssl-progress-count">'.$open_task_count.'</div>';
                $doing_well = sprintf( _n( "You're doing well. You still have %s task open.", "You're doing well. You still have %s tasks open.", $open_task_count, 'complianz-gdpr' ), $open_tasks_html );
                if (RSSSL()->really_simple_ssl->ssl_enabled) {
                	if ( $open_task_count === 0 ) {
		                _e("SSL configuration finished!", "really-simple-ssl");
	                } elseif ( !defined('rsssl_pro_version') ){
                		if ( $open_task_count >= $lowest_possible_task_count) {
			                echo $doing_well;
		                } else {
			                printf(__("Basic SSL configuration finished! Improve your score with %sReally Simple SSL Pro%s.", "really-simple-ssl"), '<a target="_blank" href="' . RSSSL()->really_simple_ssl->pro_url . '">', '</a>');
		                }
	                } else {
		                echo $doing_well;
	                }
                } else {
                	if ( !is_network_admin() ) _e("SSL is not yet enabled on this site." , "really-simple-ssl");
                }
                do_action('rsssl_progress_feedback');
                ?>
            </span>
        </div>
    </div>

	<div  ss-container class="rsssl-task-list">
        <table class="rsssl-progress-table">
        <thead></thead>
			<tbody>
			<?php
			$notices = RSSSL()->really_simple_ssl->get_notices_list(array( 'status' => 'all' ));
            foreach ($notices as $id => $notice) {
                RSSSL()->really_simple_ssl->notice_row($id, $notice);
            }
			?>
			</tbody>
        </table>
	</div>
</div>
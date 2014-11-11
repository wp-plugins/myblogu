<div class="mbu-menu">
   <a href="<?php echo admin_url('admin.php?page=mbu_interviews&mbu_page=new_interview'); ?>" class="mbu-btn <?php echo (($active_page == 'new_interview') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">New Interview</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_interviews&mbu_page=active_interviews'); ?>" class="mbu-btn <?php echo (($active_page == 'active_interviews') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">Interviews List</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_interviews&mbu_page=archive'); ?>" class="mbu-btn <?php echo (($active_page == 'archive') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">Archive</a>
</div>

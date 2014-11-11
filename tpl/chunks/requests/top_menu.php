<div class="mbu-menu">
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=new_brainstorm'); ?>" class="mbu-btn <?php echo (($active_page == 'new_brainstorm') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">New Project</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=active_brainstorms'); ?>" class="mbu-btn <?php echo (($active_page == 'active_brainstorms') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">Active Projects</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=brainstorm_archive'); ?>" class="mbu-btn <?php echo (($active_page == 'brainstorm_archive') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">Archive</a>
   <a href="<?php echo admin_url('admin.php?page=mbu_brainstorms&mbu_page=ideas'); ?>" class="mbu-btn <?php echo (($active_page == 'ideas') ? 'mbu-blue-btn' : 'mbu-orange-btn'); ?>">All Ideas</a>
</div>

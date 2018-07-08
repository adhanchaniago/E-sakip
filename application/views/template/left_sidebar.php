<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
   <aside class="main-sidebar">
      <section class="sidebar">
      <div class="user-panel">
         <div class="pull-left image">
            <img src="<?php echo (!$this->session->userdata('account')->photo) ? base_url("public/image/user/avatar.jpg") : base_url("public/image/user/{$this->session->userdata('account')->photo}"); ?>" class="img-circle" alt="User Image">
         </div>
         <div class="pull-left info">
            <p><?php echo $this->session->userdata('account')->name; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online </a>
         </div>
      </div>
      <ul class="sidebar-menu">
        <li class="<?php echo active_link_controller('main'); ?>">
            <a href="<?php echo site_url('main') ?>">
               <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="treeview <?php echo active_link_multiple(array('user','account')); ?>">
            <a href="#">
               <i class="fa fa-wrench"></i> <span>Pengaturan</span>
               <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
               </span>
            </a>
          <ul class="treeview-menu">
            <li class="<?php echo active_link_controller('user') ?>">
              <a href="<?php echo site_url('user') ?>?from_url=<?php echo current_url() ?>"><i class="fa fa-angle-double-right"></i> Pengguna Sistem</a>
            </li>
          </ul>
        </li>
      </ul>
      </section>
   </aside>
   <div class="content-wrapper">
      <section class="content-header">
        <?php 
        /**
         * Generated Page Title
         *
         * @return string
         **/
          echo $page_title;

        /**
         * Generate Breadcrumbs from library
         *
         * @var string
         **/
          echo $breadcrumb; 
        ?>
      </section>
      <section class="content">
<?php  
/* End of file left_sidebar.php */
/* Location: ./application/views/template/left_sidebar.php */



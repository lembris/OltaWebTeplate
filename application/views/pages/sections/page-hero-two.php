        <div class="container-fluid bg-primary py-5 mb-5 hero-header row">
                <?php
                    if($this->session->flashdata('error')) {
                        echo '<div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        <strong>Error!</strong> '.$this->session->flashdata('error').'
                                    </div>
                                </div>';
                            }
                            if($this->session->flashdata('success')) {
                        echo '<div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        <strong>Success!</strong> '.$this->session->flashdata('success').'
                                    </div>
                            </div>';
                        } 
                ?>
            <div class="container py-5">
                <div class="row justify-content-center py-5">
                    <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                        <h1 class="display-3 text-white animated slideInDown"><?php echo str_replace('-', ' ', $current_page_name); ?></h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb justify-content-center">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
                                <li class="breadcrumb-item"> <a href="<?php echo base_url().$main_page; ?>"><?php echo $main_page; ?> </a></li>
                                <li class="breadcrumb-item text-white active" aria-current="page"><?php echo str_replace('-', ' ', $current_page_name); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
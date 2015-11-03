<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?>class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->

<?php
global $current_user;
get_currentuserinfo();
$socialdb_logo = get_option('socialdb_logo');
$socialdb_title = get_option('blogname');
?>

<html <?php language_attributes(); ?> xmlns:fb="http://www.facebook.com/2008/fbml" class="no-js"><!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>"><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="google-site-verification" content="29Uww0bx9McdeJom1CDiXyGUZwK5mtoSuF5tA_i59F4" />         
        <link rel="icon" type="image/png" href="<?php echo get_template_directory_uri().'/libraries/images/icone.png' ?>">
        <?php if(wp_title('&raquo;', false)): ?>
        <title><?php wp_title(); ?></title>
        <?php else: ?>
        <title>&raquo;Tainacan</title>
        <?php endif; ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head(); ?>
    </head>
    <!-- TAINACAN: tag body adaptado para o gplus -->
    <body <?php body_class(); ?> itemscope>
        <?php 
        if(is_front_page()): 
            echo  '<header style="background-image: url('.get_template_directory_uri() . '/libraries/images/bg-home'.rand(1,5).'.jpg);">'; 
        endif;
        // require (dirname(__FILE__) . "/models/user/facebook.php");
        global $wp_query;
        $collection_id = $wp_query->post->ID;
        $collection_owner = $wp_query->post->post_author;
        $user_owner = get_user_by('id', $collection_owner);
        $user_owner = $user_owner->user_login;
//        $facebook = new Facebook(array(
//            'appId' => "1003980369621510",
//            'secret' => "3c89421b29a2862d3ea8089e84d64147",
//            'cookie' => true,
//        ));
//        var_dump($facebook);
        ?>
         <!-- TAINACAN: tag nav, utilizando classes do bootstrap nao modificadas, onde estao localizados os links que chamam paginas da administracao do repositorio -->
         <nav <?php if(!is_front_page()): ?> style="background-color: #000;" <?php endif; ?>  
                                             class="navbar navbar-default">
             <!--?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?-->
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <!-- TAINACAN: botao que mostra o menu para dispositivos moveis, copiado do bootstrap -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- TAINACAN: neste local eh mostrado a logo juntamente com o titulo do repositorio  -->
                    <?php
                    if($socialdb_logo!=''&&get_the_post_thumbnail($socialdb_logo, 'thumbnail'))
                    { 
                        ?><a class="navbar-brand" href="<?php echo site_url(); ?>">
                            <?php 
                            if(get_the_post_thumbnail($socialdb_logo, 'thumbnail')){
                                ?><img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($socialdb_logo)); ?>" style="max-width: 150px; max-height: 30px;" ><?php
                            }
                            elseif($socialdb_title!='')
                            {
                               echo $socialdb_title;
                            }
                                    else
                            {
                                echo 'Tainacan';
                            }
                            ?>
                        </a><?php
                    }
                    else
                    {
                       ?><a class="navbar-brand" href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri().'/libraries/images/Tainacan_pb.svg' ?>" width="120"></a><?php
                    }
                    ?>
                </div>
                <?php if(!is_front_page()): ?>
                    <!-- TAINACAN: formulario de busca de colecoes, no input eh utlizado autocomplete, a -->
                    <form class="navbar-form navbar-left" id="formSearchCollections" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search_collections" id="search_collections" placeholder="<?php _e('Search Collection','tainacan'); ?>" style="background-color:#000; color: #FFF;">
                        </div>
                        <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                <?php endif; ?>
                <!-- TAINACAN: container responsavel em listar os links para as acoes no repositorio -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    
                     <!-- TAINACAN: mostra acoes do usuario, cadastro, login, edital perfil suas colecoes -->
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (is_user_logged_in()): ?>
                        
                            <li><a href="<?= get_the_permalink(get_option('collection_root_id')) . '?mycollections=true' ?>"><?php _e('My collections','tainacan'); ?></a></li>  
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo $current_user->display_name; ?><span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <!--li><a href="#"><?php _e('Feed','tainacan'); ?></a></li-->
                                    <li><a href="#" onclick="showProfileScreen('<?php echo get_template_directory_uri() ?>');"><?php _e('Profile','tainacan'); ?></a></li>
                                    <!--li><a href="#"><?php _e('Messages','tainacan'); ?> (1)</a></li>
                                    <li><a href="#"><?php _e('Notifications','tainacan'); ?> (2)</a></li>
                                    <li><a href="#"><?php _e('Favorites','tainacan'); ?> (309)</a></li-->
                                </ul>
                            </li>
                            <li><a href="<?php echo wp_logout_url(get_permalink()); ?>"><?php _e('Logout','tainacan'); ?></a></li>
                        <?php else: ?>
                            <?php if (get_post_type($collection_id) == 'socialdb_collection'): ?>
                                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php echo __('Collection owner:','tainacan').' '.$user_owner; ?></a></li>
                            <?php endif; ?>
                                <li><button class="btn btn-default pull-right" onclick="showLoginScreen('<?php echo get_template_directory_uri() ?>');" href="#">
                                        &nbsp;<?php _e('Login','tainacan') ?>
                                    </button>
                                </li>
                                <li>
                                    <button class="btn btn-default pull-right" id="openmyModalRegister" >
                                        &nbsp;<?php _e('Register','tainacan') ?>
                                    </button>
                                </li>
                        <?php endif; ?>
                    </ul>
                     <ul class="nav navbar-nav navbar-right">
                        <!-- TAINACAN: mostra a busca avancada dentro da tag <div id="configuration"> localizado no arquivo single.php -->
                        <!--li><a onclick="showAdvancedSearch('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-search"></span>&nbsp;<?php _e('Advanced Search','tainacan'); ?></a></li -->
                            <!--button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-chevron-down"></span></button>
                            <!--a class="dropdown-toggle" href="#" data-toggle="dropdown">Sign In <strong class="caret"></strong></a-->
                        <!-- TAINACAN: abre o modal id="myModal" localizado neste arquivo -->   
                        <li><a href="#"  id="click_new_collection"><span class="glyphicon glyphicon-plus"></span><?php _e('Create Collection','tainacan'); ?></a></li>  
                         <!-- TAINACAN: sai da pagina e vai para a colecao raiz -->   
                        <li><a href="<?php echo get_permalink(get_option('collection_root_id')); ?>"><span class="glyphicon glyphicon-book"></span>&nbsp;<?php _e('Collections','tainacan'); ?></a></li>
                        <?php //is_home()
                        if ( current_user_can( 'manage_options' ) && !is_front_page() ) { ?>
                        <!-- TAINACAN: mostra acoes do repositorio dentro da tag <div id="configuration"> localizado no arquivo single.php -->
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span>&nbsp;<?php _e('Repository Configurations','tainacan'); ?><span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a onclick="showRepositoryConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-wrench"></span>&nbsp;<?php _e('Configuration','tainacan'); ?></a></li>
                                <li><a onclick="showPropertiesRepository('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;<?php _e('Metadata','tainacan'); ?></a></li>
                                <!--<li><a href="#"><span class="glyphicon glyphicon-filter"></span>&nbsp;<?php  _e('Search'); ?></a></li>-->
                                <!--<li><a href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Design'); ?></a></li>-->
                                <li class="divider"></li>
                                <!--<li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;<?php _e('Users','tainacan'); ?></a></li>-->
                                <!--<li><a href="#"><span class="glyphicon glyphicon-filter"></span>&nbsp;<?php _e('Categories','tainacan'); ?></a></li>-->
                                <li><a onclick="showAPIConfiguration('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Social / API Keys','tainacan'); ?></a></li>
                                <li><a onclick="showLicensesRepository('<?php echo get_template_directory_uri() ?>');" href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Licenses','tainacan'); ?></a></li>
                                <!--<li><a href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Import','tainacan'); ?></a></li>-->
                                <!--<li><a href="#"><span class="glyphicon glyphicon-picture"></span>&nbsp;<?php _e('Export','tainacan'); ?></a></li>-->
                                <li><a onclick="showEventsRepository('<?php echo get_template_directory_uri() ?>','<?php echo get_option('collection_root_id') ?>');"  href="#"><span  class="glyphicon glyphicon-flash"></span>&nbsp;<?php _e('Events','tainacan'); ?>&nbsp;&nbsp;<span id="notification_events_repository" style="background-color:red;color:white;font-size:13px;"></span></a></li>
                                <li><a onclick="showWelcomeEmail('<?php echo get_template_directory_uri() ?>');"  href="#"><span  class="glyphicon glyphicon-envelope"></span>&nbsp;<?php _e('Welcome Email','tainacan'); ?></a></li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav> 

         <!-- TAINACAN: modal padrao bootstrap aberto via javascript pelo seu id, formulario inicial para criacao de colecao -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?php echo get_template_directory_uri() ?>/controllers/collection/collection_controller.php" method="POST">  
                        <input type="hidden" name="operation" value="simple_add">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php _e('Create Collection','tainacan'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1"><?php _e('Collection name','tainacan'); ?></label>
                                <input type="text" required="required" class="form-control" name="collection_name" id="collection_name" placeholder="<?php _e('Type the name of your collection','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1"><?php _e('Collection object','tainacan'); ?></label>
                                <input type="text" required="required" class="form-control" name="collection_object" id="collection_object"  value="<?php _e('Item'); ?>">
                            </div>
                            <br>
                            <a onclick="showModalImportCollection();" href="#"><?php _e(' Or import a collection','tainacan') ?></a>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan'); ?></button>
                            <button type="submit" class="btn btn-primary"><?php _e('Save'); ?></button>
                        </div>
                    </form>    
                </div>
            </div>
        </div>     
         <!-- TAINACAN: modal padrao bootstrap, aberto pelo id, responsavel pelo o cadastro de usuario -->
        <div class="modal fade" id="myModalRegister" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form  id="formUserRegister" name="formUserRegister" >  
                        <input type="hidden" name="operation" value="add">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php _e('Register','tainacan'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="first_name"><?php _e('First Name','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="text" required="required" class="form-control" name="first_name" id="first_name" placeholder="<?php _e('Type here your first name','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="last_name"><?php _e('Last Name','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="text" required="required" class="form-control" name="last_name" id="last_name" placeholder="<?php _e('Type here your last name','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_email"><?php _e('Email','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="email" required="required" class="form-control" name="user_email" id="user_email" placeholder="<?php _e('Type here your e-mail','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_login"><?php _e('Username','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="text" required="required" class="form-control" name="user_login" id="user_login" placeholder="<?php _e('Type here the username that you will use for login','tainacan'); ?>">
                            </div>
                            <div class="form-group">
                                <label for="user_pass"><?php _e('Password','tainacan'); ?><span style="color: #EE0000;"> *</span></label>
                                <input type="password" required="required" class="form-control" name="user_pass" id="user_pass" placeholder="<?php _e('Type here your password','tainacan'); ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan'); ?></button>
                            <button type="submit" class="btn btn-primary" onclick="check_register_fields(); return false;"><?php _e('Register','tainacan'); ?></button>
                        </div>
                    </form>    
                </div>
            </div>
        </div>
          <!-- TAINACAN: modal padrao bootstrap aberto via javascript pelo seu id, formulario inicial para criacao de colecao -->
        <div class="modal fade" id="modalImportCollection" tabindex="-1" role="dialog" aria-labelledby="modalImportCollectionLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="importCollection">  
                        <input type="hidden" name="operation" value="importCollection">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?php _e('Import Collection','tainacan'); ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="collection_file"><?php _e('Select the file','tainacan'); ?></label>
                                <input type="file" required="required" class="form-control" name="collection_file" id="collection_file" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?php _e('Close','tainacan'); ?></button>
                            <button type="submit" class="btn btn-primary"><?php _e('Import','tainacan'); ?></button>
                        </div>
                    </form>    
                </div>
            </div>
        </div>     







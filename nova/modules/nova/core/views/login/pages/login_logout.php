<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo __("You have successfully logged out. You can :login or proceed to the :main. You will be redirected in <span id='countdown'></span> seconds.", array(':login' => html::anchor('login/index', __("log in again")), ':main' => html::anchor('main/index', __("main site"))));?></p>
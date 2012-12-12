<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title><?php echo $title ?> | </title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/main.css" type="text/css" media="screen, projection" />
    </head>
    <body>
        <div id="wrapper">
            <div id="header">
                <h1>My App</h1>
            </div>
            <div id="container">
                <?php if ($this->uri->segment(1) == 'MainController'): ?>
                <div id="bio">
                    <img src="<?php echo base_url(); ?>images/profile_normal.jpg" alt="James" class="display-pic" />
                    <h2>Greetings <?php echo $this->session->userdata('username'); ?>!</h2>
                    <p><?php echo anchor('#', 'Your Account') . ' | ' . anchor('AuthController/logout', 'Log out'); ?></p>
                </div>
                <?php endif; ?>
                <div id="content">
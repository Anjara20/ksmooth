<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="<?= base_url('assets/bootstrap-4.0.0/dist/css/bootstrap.min.css') ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('assets/css/signin.css') ?>" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin"
     method="POST" action="<?php //echo base_url('backoffice/login')?>" onsubmit="return false;">
        <img class="mb-4" src="<?=base_url('assets/img/logo.png')?>" alt="" width="" height="">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <?php // echo form_error('mail')?>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="mail">
        <small id="checkMail"></small><?php // echo form_error('password')?>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password">
        <small id="checkPassword"></small>
        <input type="hidden" id="checkAll" name='checkAll'>
        <img src="" alt="" >
        <div class="checkbox mb-3">
            <label>
                <input type="checkbox" value="remember-me">Remember me
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" id="submit" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; Andrianilana Anjaramamy Liantsoa</p>
    </form>
</body>
<script src="<?=base_url('assets/bootstrap-4.0.0/js/tests/vendor/jquery-1.9.1.min.js')?>"></script>
<script>
    function checkMail(){
        $.ajax({
            type:"POST",
            url:"<?= base_url('backoffice/login2')?>",
            data:{
                'mail':$('#inputEmail').val()
            },
            success:function(data){
                if(data=='success'){
                    $('#checkMail').html("<img width='20px' height='20px' src='<?=base_url('assets/img/checkmark.svg')?>'>");
                    return true;
                }else{
                    $("#checkMail").css('color','red').html(data);
                }
            }
        });
    };
    function checkPassword(){
        $.ajax({
            type:"POST",
            url:"<?=base_url('backoffice/login2')?>",
            data:{
                'password':$('#inputPassword').val()
            },
            success:function(data){
                if(data=='success'){
                    $('#checkPassword').html("<img width='20px' height='20px' src='<?=base_url('assets/img/checkmark.svg')?>'>");
                    $("input[name='checkAll']").attr('value','Ok');
                    return true;
                }else{
                    $("#checkPassword").css('color','red').html(data);
                }
            }
        })

    };
    $(document).ready(function(){
        $("#inputEmail").keyup(function(){
            checkMail();
        });
        $('#inputPassword').keyup(function(){
            checkPassword();
        });
        $('#submit').click(function(){
            if(($('#inputEmail').val()=="") && $('#inputPassword').val()==""){
                alert('empty field');
            }else{
               $.ajax({
                 type:'POST',
                 url:'<?=base_url('backoffice/login2')?>',
                 data:{
                     'checkAll':$("input[name='checkAll']").val()
                 },
                 success:function(data){
                     if(data=='done'){
                         window.location.href='<?=base_url('backoffice/home')?>';
                     }else{
                         alert('something wrong');
                     }
                 }
               });
            }
        });
    });
</script>
</html>
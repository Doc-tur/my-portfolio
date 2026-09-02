<?php
require_once 'includes/db.php'; 
require_once 'includes/functions.php';

$pageTitle='Contact';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name']??''); 
    $email=trim($_POST['email']??''); 
    $subject=trim($_POST['subject']??''); 
    $message=trim($_POST['message']??'');
    if($name && filter_var($email,FILTER_VALIDATE_EMAIL) && $subject && $message){
        $st=$conn->prepare("INSERT INTO messages(name,email,subject,message) VALUES(?,?,?,?)"); 
        $st->bind_param("ssss",$name,$email,$subject,$message); 
        $st->execute(); 
        flash('success','Your message has been sent successfully.'); 
        
        header('Location: contact.php'); 
        exit;
    } else flash('error','Please complete all fields with a valid email.');
}

include 'includes/header.php'; 
$success=flash('success'); 
$error=flash('error');
?>

<section class="inner-hero">
    <div class="container">
        <span class="section-kicker">GET IN TOUCH</span>
        <h1>Let's build something great.</h1>
        <p class="text-secondary">Have a website idea or project? Send me a message.</p>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <?php if($success): ?>
                    <div class="alert alert-success"><?=e($success)?></div>
                <?php endif; ?>
                <?php if($error): ?>
                    <div class="alert alert-danger"><?=e($error)?></div>
                <?php endif; ?>
                <form method="post" class="contact-card">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input required name="name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label>Email</label>
                            <input required type="email" name="email" class="form-control">
                        </div>
                        <div class="col-12">
                            <label>Subject</label>
                            <input required name="subject" class="form-control">
                        </div>
                        <div class="col-12">
                            <label>Message</label>
                            <textarea required name="message" rows="6" class="form-control"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-accent btn-lg">Send Message <i class="bi bi-send"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
